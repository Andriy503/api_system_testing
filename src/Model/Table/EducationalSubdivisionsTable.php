<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EducationalSubdivisions Model
 *
 * @method \App\Model\Entity\EducationalSubdivision get($primaryKey, $options = [])
 * @method \App\Model\Entity\EducationalSubdivision newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EducationalSubdivision[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EducationalSubdivision|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EducationalSubdivision|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EducationalSubdivision patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EducationalSubdivision[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EducationalSubdivision findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EducationalSubdivisionsTable extends Table
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

        $this->setTable('educational_subdivisions');
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
            ->maxLength('title', 200)
            ->requirePresence('title', 'create')
            ->allowEmptyString('title', false);

        return $validator;
    }
}
