<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EntrantToTicketFixture
 *
 */
class EntrantToTicketFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'entrant_to_ticket';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'id_entrant' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'id_ticket' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'is_done' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'rating' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'id_entrant' => ['type' => 'index', 'columns' => ['id_entrant'], 'length' => []],
            'id_ticket' => ['type' => 'index', 'columns' => ['id_ticket'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'entrant_to_ticket_ibfk_1' => ['type' => 'foreign', 'columns' => ['id_entrant'], 'references' => ['entrants', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'entrant_to_ticket_ibfk_2' => ['type' => 'foreign', 'columns' => ['id_ticket'], 'references' => ['tickets', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'id_entrant' => 1,
                'id_ticket' => 1,
                'is_done' => 1,
                'rating' => 1,
                'created' => 1558634904,
                'modified' => 1558634904
            ],
        ];
        parent::init();
    }
}
