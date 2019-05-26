<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EntrantAnswer Entity
 *
 * @property int $id
 * @property int $id_entrant
 * @property int $id_question
 * @property string $answers
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class EntrantAnswer extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'id_entrant' => true,
        'id_question' => true,
        'answers' => true,
        'created' => true,
        'modified' => true
    ];
}
