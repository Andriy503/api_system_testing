<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Specialty Model
 *
 * @method \App\Model\Entity\Specialty get($primaryKey, $options = [])
 * @method \App\Model\Entity\Specialty newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Specialty[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Specialty|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Specialty|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Specialty patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Specialty[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Specialty findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SpecialtyTable extends Table
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

        $this->setTable('specialty');
        $this->setDisplayField('title');
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
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->allowEmptyString('title', false);

        $validator
            ->boolean('is_delete')
            ->requirePresence('is_delete', 'create')
            ->allowEmptyString('is_delete', false);

        $validator
            ->scalar('short_title')
            ->maxLength('short_title', 255)
            ->allowEmptyString('short_title');

        $validator
            ->scalar('full_name')
            ->allowEmptyString('full_name');

        $validator
            ->integer('id_departament')
            ->requirePresence('id_departament', 'create')
            ->allowEmptyString('id_departament', false);

        return $validator;
    }
}
