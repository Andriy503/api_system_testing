<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AdminUsers Model
 *
 * @method \App\Model\Entity\AdminUser get($primaryKey, $options = [])
 * @method \App\Model\Entity\AdminUser newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AdminUser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AdminUser|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AdminUser|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AdminUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AdminUser[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AdminUser findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AdminUsersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('admin_users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->boolean('is_delete')
            ->allowEmptyString('is_delete', false);

        $validator
            ->boolean('is_ver')
            ->allowEmptyString('is_ver', false);

        $validator
            ->scalar('login')
            ->maxLength('login', 50, 'Логін занадто довгий!')
            ->minLength('login', 5, 'Логін занадто короткий!')
            ->requirePresence('login', 'create')
            ->notEmpty('login', 'Логін не може бути пустим!');

        $validator
            ->scalar('password')
            ->maxLength('password', 255, 'Пароль занадто довгий!')
            ->minLength('password', 5, 'Пароль занадто короткий!')
            ->requirePresence('password', 'create')
            ->notEmpty('password', 'Пароль не може бути пустим!');

        $validator
            ->scalar('name')
            ->maxLength('name', 50, 'Ім`я занадто довге!')
            ->minLength('name', 2, 'Ім`я занадто коротке!')
            ->requirePresence('name', 'create')
            ->notEmpty('name', 'Ім`я не може бути пустим!');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 50, 'Прізвище занадто довге!')
            ->minLength('last_name', 2, 'Прізвище занадто коротке!')
            ->requirePresence('last_name', 'create')
            ->notEmpty('last_name', 'Прізвище не може бути пустим!');

        $validator
            ->scalar('avatar_path')
            ->maxLength('avatar_path', 255)
            ->allowEmptyString('avatar_path');

        $validator
            ->scalar('about')
            ->allowEmptyString('about');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['login']));

        return $rules;
    }
}
