<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Answers Model
 *
 * @method \App\Model\Entity\Answer get($primaryKey, $options = [])
 * @method \App\Model\Entity\Answer newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Answer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Answer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Answer|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Answer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Answer[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Answer findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AnswersTable extends Table
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

        $this->setTable('answers');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->hasMany('Bundles', [
            'foreignKey' => 'id_answer',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('Questions', [
            'foreignKey' => 'id_question',
            'joinType' => 'INNER'
        ]);

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
            ->requirePresence('title', 'create')
            ->allowEmptyString('title', true);

        $validator
            ->boolean('current_answer')
            ->allowEmptyString('current_answer', false);

        $validator
            ->integer('id_question')
            ->requirePresence('id_question', 'create')
            ->allowEmptyString('id_question', false);

        return $validator;
    }
}
