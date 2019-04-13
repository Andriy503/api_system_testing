<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TicketsFixture
 *
 */
class TicketsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'title' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'time_of_passing' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '3600', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'count_question' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '20', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'id_specialty' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'id_course' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'id_specialty' => ['type' => 'index', 'columns' => ['id_specialty'], 'length' => []],
            'id_course' => ['type' => 'index', 'columns' => ['id_course'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'tickets_ibfk_1' => ['type' => 'foreign', 'columns' => ['id_specialty'], 'references' => ['specialty', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'tickets_ibfk_2' => ['type' => 'foreign', 'columns' => ['id_course'], 'references' => ['courses', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'title' => 'Lorem ipsum dolor sit amet',
                'time_of_passing' => 1,
                'count_question' => 1,
                'id_specialty' => 1,
                'id_course' => 1,
                'created' => 1554632805,
                'modified' => 1554632805
            ],
        ];
        parent::init();
    }
}
