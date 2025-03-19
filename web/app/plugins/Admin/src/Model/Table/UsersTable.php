<?php
declare(strict_types=1);

namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Admin\Model\Table\LoginHistorysTable&\Cake\ORM\Association\HasMany $LoginHistorys
 *
 * @method \Admin\Model\Entity\User newEmptyEntity()
 * @method \Admin\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \Admin\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\User get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Admin\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Admin\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Admin\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Admin\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('LoginHistorys', [
            'foreignKey' => 'user_id',
            'className' => 'Admin.LoginHistorys',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('account')
            ->maxLength('account', 20)
            ->requirePresence('account', 'create')
            ->notEmptyString('account')
            ->add('account', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->scalar('name')
            ->maxLength('name', 20)
            ->notEmptyString('name');

        $validator
            ->email('email')
            ->notEmptyString('email');

        $validator
            ->dateTime('deleted')
            ->allowEmptyDateTime('deleted');

        $validator
            ->scalar('created_user')
            ->maxLength('created_user', 45)
            ->allowEmptyString('created_user');

        $validator
            ->scalar('modified_user')
            ->maxLength('modified_user', 45)
            ->allowEmptyString('modified_user');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);
        $rules->add($rules->isUnique(['account']), ['errorField' => 'account']);

        return $rules;
    }
}
