<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Bundles Model
 *
 * @method \App\Model\Entity\Bundle get($primaryKey, $options = [])
 * @method \App\Model\Entity\Bundle newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Bundle[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Bundle|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Bundle|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Bundle patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Bundle[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Bundle findOrCreate($search, callable $callback = null, $options = [])
 */
class BundlesTable extends Table
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

        $this->setTable('bundles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Answers', [
            'foreignKey' => 'id_answer',
            'joinType' => 'LEFT'
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
            ->scalar('a_question')
            ->maxLength('a_question', 255)
            ->requirePresence('a_question', 'create')
            ->allowEmptyString('a_question', false);

        $validator
            ->scalar('a_answer')
            ->maxLength('a_answer', 255)
            ->requirePresence('a_answer', 'create')
            ->allowEmptyString('a_answer', false);

        $validator
            ->integer('id_answer')
            ->requirePresence('id_answer', 'create')
            ->allowEmptyString('id_answer', false);

        return $validator;
    }
}
