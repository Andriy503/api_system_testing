<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Question Entity
 *
 * @property int $id
 * @property string $title
 * @property string|null $pre_img
 * @property int $rating
 * @property int $id_ticket
 * @property int $id_type
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class Question extends Entity
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
        'pre_img' => true,
        'rating' => true,
        'id_ticket' => true,
        'id_type' => true,
        'created' => true,
        'modified' => true,
        'points' => true
    ];
}
