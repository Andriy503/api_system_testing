<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EntrantToTicket Model
 *
 * @method \App\Model\Entity\EntrantToTicket get($primaryKey, $options = [])
 * @method \App\Model\Entity\EntrantToTicket newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EntrantToTicket[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EntrantToTicket|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EntrantToTicket|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EntrantToTicket patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EntrantToTicket[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EntrantToTicket findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EntrantToTicketTable extends Table
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

        $this->setTable('entrant_to_ticket');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Tickets', [
            'foreignKey' => 'id_ticket',
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
            ->integer('id_entrant')
            ->requirePresence('id_entrant', 'create')
            ->allowEmptyString('id_entrant', false);

        $validator
            ->integer('id_ticket')
            ->requirePresence('id_ticket', 'create')
            ->allowEmptyString('id_ticket', false);

        $validator
            ->boolean('is_done')
            ->requirePresence('is_done', 'create')
            ->allowEmptyString('is_done', false);

        $validator
            ->integer('rating')
            ->requirePresence('rating', 'create')
            ->allowEmptyString('rating', false);

        return $validator;
    }
}
