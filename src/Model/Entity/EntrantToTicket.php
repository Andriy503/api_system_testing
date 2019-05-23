<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EntrantToTicket Entity
 *
 * @property int $id
 * @property int $id_entrant
 * @property int $id_ticket
 * @property bool $is_done
 * @property int $rating
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class EntrantToTicket extends Entity
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
        'id_ticket' => true,
        'is_done' => true,
        'rating' => true,
        'created' => true,
        'modified' => true
    ];
}
