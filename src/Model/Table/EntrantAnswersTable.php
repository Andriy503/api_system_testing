<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EntrantAnswers Model
 *
 * @method \App\Model\Entity\EntrantAnswer get($primaryKey, $options = [])
 * @method \App\Model\Entity\EntrantAnswer newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EntrantAnswer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EntrantAnswer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EntrantAnswer|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EntrantAnswer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EntrantAnswer[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EntrantAnswer findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EntrantAnswersTable extends Table
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

        $this->setTable('entrant_answers');
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
            ->integer('id_entrant')
            ->requirePresence('id_entrant', 'create')
            ->allowEmptyString('id_entrant', false);

        $validator
            ->integer('id_question')
            ->requirePresence('id_question', 'create')
            ->allowEmptyString('id_question', false);

        $validator
            ->scalar('answers')
            ->maxLength('answers', 255)
            ->requirePresence('answers', 'create')
            ->allowEmptyString('answers', false);

        return $validator;
    }
}
