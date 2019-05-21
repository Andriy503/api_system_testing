<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Bundle Entity
 *
 * @property int $id
 * @property string $question
 * @property string $answer
 * @property int $id_answer
 */
class Bundle extends Entity
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
        'a_question' => true,
        'a_answer' => true,
        'id_answer' => true
    ];
}
