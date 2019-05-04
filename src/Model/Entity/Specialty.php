<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Specialty Entity
 *
 * @property int $id
 * @property string $title
 * @property bool $is_delete
 * @property string|null $short_title
 * @property string|null $full_name
 * @property int $id_departament
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class Specialty extends Entity
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
        'is_delete' => true,
        'short_title' => true,
        'full_name' => true,
        'id_departament' => true,
        'created' => true,
        'modified' => true,
        'pre_path' => true
    ];
}
