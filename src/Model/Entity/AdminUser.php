<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * AdminUser Entity
 *
 * @property int $id
 * @property bool $is_delete
 * @property bool $is_ver
 * @property string $login
 * @property string $password
 * @property string $name
 * @property string $last_name
 * @property string|null $avatar_path
 * @property string|null $about
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class AdminUser extends Entity
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
        'is_delete' => true,
        'is_ver' => true,
        'login' => true,
        'password' => true,
        'name' => true,
        'last_name' => true,
        'avatar_path' => true,
        'about' => true,
        'role_id' => true,
        'created' => true,
        'modified' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    protected function _setPassword($password) {
        return (new DefaultPasswordHasher())->hash($password);
    }
}
