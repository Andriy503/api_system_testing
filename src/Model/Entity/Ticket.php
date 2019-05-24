<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Ticket Entity
 *
 * @property int $id
 * @property string $title
 * @property int $time_of_passing
 * @property int $count_question
 * @property int $id_specialty
 * @property int $id_course
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class Ticket extends Entity
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
        'title' => true,
        'time_of_passing' => true,
        'count_question' => true,
        'id_specialty' => true,
        'id_course' => true,
        'created' => true,
        'modified' => true,
        'is_progress' => true
    ];
}
