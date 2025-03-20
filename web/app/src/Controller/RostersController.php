<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\I18n\FrozenTime;

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
        $condition = "";

        // 検索条件で使用する年を、データとして存在する年から取得する
        $years = $this->Rosters->find('list', ['keyField' => 'year', 'valueField' => 'year'])
            ->select(['year' => 'DATE_FORMAT(start_time, \'%Y\')'])
            ->group(['year']);

        if ($this->request->is('post')) {
            // 認証情報からアカウントIDを取得する
            $auth = $this->Authentication->getIdentity(); // CakePHP 4+

            // 認証情報が取得できない場合はログイン画面にリダイレクトする
            if (!$auth) {
                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            }

            // データ抽出期間を検索条件から生成
            $condition = $this->request->getData();
            $start = new FrozenTime($condition['year'] . '-' . $condition['month'] . '-01' . ' 00:00:00');
            $end = (clone $start)->addMonth(1);

            // 勤怠データ取得
            $tmpRosters = $this->Rosters->find()
                ->select(['id', 'day' => 'DATE_FORMAT(start_time, \'%d\')', 'start_time', 'end_time', 'status', 'reason'])
                ->where(['users_id' => $auth->id])
                ->where(['start_time >=' => $start])
                ->where(['start_time <' => $end])
                ->order(['start_time' => 'asc']);

            // 取得したデータを１ヶ月分の配列にセットする
            $lastDay = (new FrozenTime())->modify('last day of ' . $condition['year'] . '-' . $condition['month'])->i18nFormat('dd');
            $rosters = array_fill(1, (int)$lastDay, null);

            foreach ($tmpRosters as $roster) {
                $rosters[intval($roster->day)] = $roster;
            }

            $this->set(compact('rosters'));
        }

        $this->set(compact('years', 'condition'));
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

        if (empty($id)) {
            $roster = $this->Rosters->newEmptyEntity();
            $roster->users_id = $user->id;
            $roster->start_time = new FrozenTime($this->request->getQuery('date'));
            $roster->end_time = new FrozenTime($this->request->getQuery('date'));
        } else {
            $roster = $this->Rosters->get($id, [
                'contain' => [],
            ]);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
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
