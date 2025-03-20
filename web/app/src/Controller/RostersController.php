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
        $this->paginate = [
            'contain' => ['Users'],
        ];
        $rosters = $this->paginate($this->Rosters);

        $this->set(compact('rosters'));
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
        $roster = $this->Rosters->get($id, [
            'contain' => [],
        ]);
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


    public function stamp() {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $account = $this->request->getData('account');
            $kubun = $this->request->getData('kubun');

            // エンティティにpatchするための配列
            $tmpArr = array();
            $msg = '';

            // 区分から出勤、退勤時刻を判断し日時を取得する
            if ($kubun === 'sta') {
                $tmpArr['start_time'] = FrozenTime::now();
                $msg = 'おはようございます。';
            }
            elseif ($kubun === 'end') {
                $tmpArr['end_time'] = FrozenTime::now();
                $msg = 'お疲れさまでした。';
            }

            // accountからユーザーID取得
            $this->Users = $this->fetchTable('Users');
            $user = $this->Users->find()->where(['account' => $account])->first();

            // ユーザー情報が取得できたら打刻する
            if ($user) {
                $tmpArr['users_id'] = $user->id;

                // 保存用エンティティの生成
                $roster = $this->Rosters->newEmptyEntity();
                $roster = $this->Rosters->patchEntity($roster, $tmpArr);

                if ($this->Rosters->save($roster)) {
                    $this->Flash->success($msg);
                }
                else {
                    $this->Flash->error('打刻でエラーが発生しました。');
                }
            }
            else {
                $this->Flash->error('入力されたアカウントが存在しません。');
            }
        }

        $this -> render ( "stamp", "roster" );
    }
}
