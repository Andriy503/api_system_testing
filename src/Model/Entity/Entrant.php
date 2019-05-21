<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Entrant Entity
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property \Cake\I18n\FrozenDate $age
 * @property string $city
 * @property bool $isPassed
 * @property int $id_specialty
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Specialty $specialty
 */
class Entrant extends Entity
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
        'first_name' => true,
        'last_name' => true,
        'middle_name' => true,
        'age' => true,
        'city' => true,
        'is_passed' => true,
        'id_specialty' => true,
        'created' => true,
        'modified' => true,
        'specialty' => true
    ];
}
