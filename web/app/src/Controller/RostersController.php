<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\I18n\FrozenTime;

use Cake\Log\Log;

/**
 * Rosters Controller
 *
 * @property \App\Model\Table\RostersTable $Rosters
 * @method \App\Model\Entity\Roster[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RostersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        // 認証情報からアカウントIDを取得する。
        $auth = $this->request->getSession()->read('Auth');

        // 認証情報が取得できない場合はログイン画面にリダイレクトする
        if (!$auth) {
            return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
        }

        // 検索条件で使用する年を、データとして存在する年から取得する
        $years = $this->Rosters->find('list', ['keyField' => 'year', 'valueField' => 'year'])
            ->select(['year' => 'DATE_FORMAT(start_time, \'%Y\')'])
            ->group(['year']);

        $condition = $this->request->getQuery();

        if (empty($condition)) {
            $date = new FrozenTime();
            $year = intval($date->i18nFormat('yyyy'));
            $month = intval($date->i18nFormat('MM'));
            $condition = ['year' => $year, 'month' => $month];
        }

        // データ抽出期間を検索条件から生成
        $start = new FrozenTime($condition['year'] . '-' . $condition['month'] . '-01' . ' 00:00:00');
        $end = $start->addMonth(1);

        // 勤怠データ取得
        $tmpRosters = $this->Rosters->find()
            ->select(['id', 'day' => 'DATE_FORMAT(start_time, \'%d\')', 'start_time', 'end_time', 'status', 'reason'])
            ->where(['users_id' => $auth->id])
            ->where(['start_time >=' => $start])
            ->where(['start_time <' => $end])
            ->order(['start_time' => 'asc']);

        // 取得したデータを１ヶ月分の配列にセットする
        $rosters = array_fill(1, (int)((new FrozenTime())->modify('last day of ' . $condition['year'] . '-' . $condition['month'])->i18nFormat('dd')), null);
        foreach ($tmpRosters as $roster) {
            $rosters[intval($roster->day)] = $roster;
        }

        $this->set(compact('rosters', 'years', 'condition'));
    }

    /**
     * View method
     *
     * @param string|null $id Roster id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $roster = $this->Rosters->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set(compact('roster'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $roster = $this->Rosters->newEmptyEntity();
        if ($this->request->is('post')) {
            $roster = $this->Rosters->patchEntity($roster, $this->request->getData());
            if ($this->Rosters->save($roster)) {
                $this->Flash->success(__('The roster has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The roster could not be saved. Please, try again.'));
        }
        $users = $this->Rosters->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('roster', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Roster id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Authentication->getIdentity();
        $roster = null;

        $date = new FrozenTime($this->request->getQuery('date'));
        $year = intval($date->i18nFormat('yyyy'));
        $month = intval($date->i18nFormat('MM'));
    
        if (empty($id)) {
            $roster = $this->Rosters->newEmptyEntity();
            $roster->users_id = $user->id;
            $roster->start_time = new FrozenTime($this->request->getQuery('date'));
            $roster->end_time = new FrozenTime($this->request->getQuery('date'));
        } else {
            $roster = $this->Rosters->get($id, ['contain' => []]);
        }
    
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // Debug the incoming data to check start_time and end_time
            // debug($data['start_time']);
            // debug($data['end_time']);
            // exit; // Halt execution to check the values in the browser        

            // Convert input times to DateTime format
            $originalStart = $roster->start_time;
            $originalEnd = $roster->end_time;
            
            try {
                // Check if start_time and end_time are provided
                if (empty($data['start_time']) || empty($data['end_time'])) {
                    $this->Flash->error(__('Start time and end time cannot be empty.'));
                    return $this->redirect($this->referer());
                }

                // Log::write('debug', 'Start Time: ' . $data['start_time']);
                // Log::write('debug', 'End Time: ' . $data['end_time']);

                $startTime = FrozenTime::createFromFormat('H:i:s', trim($data['start_time']));

                
                $endTime = FrozenTime::createFromFormat('H:i:s', trim($data['end_time']));
            
                // If parsing failed, show an error
                if (!$startTime || !$endTime || !$startTime->getTimestamp() || !$endTime->getTimestamp()) {
                    throw new \Exception('Invalid time format.');
                }
            
                // Preserve original date, update only time
                $roster->start_time = $originalStart->setTime($startTime->hour, $startTime->minute, 0);
                $roster->end_time = $originalEnd->setTime($endTime->hour, $endTime->minute, 0);
            
            } catch (\Exception $e) {
                // Log the error message
                // Log::write('debug', 'Error parsing time: ' . $e->getMessage());
            
                // Provide user feedback
                $this->Flash->error(__('Invalid time format.'));
                return $this->redirect($this->referer());
            }
    
            // Remove start_time and end_time from data before patching
            unset($data['start_time'], $data['end_time']);
    
            $roster = $this->Rosters->patchEntity($roster, $data, ['fields' => ['status', 'reason']]);
    
            if ($this->Rosters->save($roster)) {
                $this->Flash->success(__('The roster has been saved.'));
                return $this->redirect(['action' => 'index?year=' . $year . '&month=' . $month]);
            }
    
            $this->Flash->error(__('The roster could not be saved. Please, try again.'));
        }
    
        $users = $this->Rosters->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('roster', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Roster id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $roster = $this->Rosters->get($id);
        if ($this->Rosters->delete($roster)) {
            $this->Flash->success(__('The roster has been deleted.'));
        } else {
            $this->Flash->error(__('The roster could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    // public function stamp() {
    //     if ($this->request->is(['patch', 'post', 'put'])) {
    //         $account = $this->request->getData('account');
    //         $kubun = $this->request->getData('kubun');

    //         // エンティティにpatchするための配列
    //         $tmpArr = array();
    //         $msg = '';

    //         // 区分から出勤、退勤時刻を判断し日時を取得する
    //         if ($kubun === 'sta') {
    //             $tmpArr['start_time'] = FrozenTime::now();
    //             $msg = 'おはようございます。';
    //         }
    //         elseif ($kubun === 'end') {
    //             $tmpArr['end_time'] = FrozenTime::now();
    //             $msg = 'お疲れさまでした。';
    //         }

    //         // accountからユーザーID取得
    //         $this->Users = $this->fetchTable('Users');
    //         $user = $this->Users->find()->where(['account' => $account])->first();

    //         // ユーザー情報が取得できたら打刻する
    //         if ($user) {
    //             $tmpArr['users_id'] = $user->id;

    //             // 保存用エンティティの生成
    //             $roster = $this->Rosters->newEmptyEntity();
    //             $roster = $this->Rosters->patchEntity($roster, $tmpArr);

    //             if ($this->Rosters->save($roster)) {
    //                 $this->Flash->success($msg);
    //             }
    //             else {
    //                 $this->Flash->error('打刻でエラーが発生しました。');
    //             }
    //         }
    //         else {
    //             $this->Flash->error('入力されたアカウントが存在しません。');
    //         }
    //     }

    //     $this -> render ( "stamp", "roster" );
    // }

    public function stamp()
    {
        // Layoutの指定
        $this->viewBuilder()->setLayout('roster');

        if ($this->request->is(['patch', 'post', 'put'])) {
            // 送信データ取得
            $account = $this->request->getData('account');
            $kubun = $this->request->getData('kubun');

            // accountからユーザーID取得
            $this->Users = $this->fetchTable('Users');
            $user = $this->Users->find()->where(['account' => $account])->first();

            if (!$user) {
                $this->Flash->error('入力されたアカウントが存在しません。');
                return;
            }

            // 当日のデータを取得
            $now = new FrozenTime();
            $roster = $this->Rosters->find()
                ->where(['users_id' => $user->id])
                ->where(['start_time >=' =>  $now->i18nFormat('yyyy-MM-dd') . ' 00:00:00'])
                ->where(['start_time <' =>  $now->addDay(1)->i18nFormat('yyyy-MM-dd') . ' 00:00:00'])
                ->order(['created' => 'desc'])
                ->first();

            // 出退勤済みの当日データが既にある場合は打刻しない
            if (isset($roster)) {
                if ($roster->start_time != NULL and $roster->end_time != NULL) {
                    $this->Flash->error('既に出退勤済みです。');
                    return;
                }
            }

            // エンティティにpatchするための配列
            $tmpArr = array();
            $msg = '';

            // ユーザーIDをセット
            $tmpArr['users_id'] = $user->id;

            // 区分から出勤、退勤時刻を判断し日時をセットする
            if ($kubun === 'sta') {
                if (isset($roster)) {
                    $this->Flash->error('既に出勤しています。');
                    return;
                } else {
                    $tmpArr['start_time'] = $now;
                    $msg = 'おはようございます。';
                    $roster = $this->Rosters->newEmptyEntity();
                }
            } elseif ($kubun === 'end') {
                if (isset($roster)) {
                    $tmpArr['end_time'] = $now;
                    $msg = 'お疲れさまでした。';
                } else {
                    $this->Flash->error('まだ出勤していません。');
                    return;
                }
            }

            // エンティティに時刻をセットする
            $roster = $this->Rosters->patchEntity($roster, $tmpArr);
            if ($this->Rosters->save($roster)) {
                $this->Flash->success($msg);
            } else {
                $this->Flash->error('打刻でエラーが発生しました。');
            }
        }
    }
    /**
     * beforeFilter method
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['stamp']);
    }
}
