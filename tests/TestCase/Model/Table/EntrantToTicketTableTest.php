<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EntrantToTicketTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EntrantToTicketTable Test Case
 */
class EntrantToTicketTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EntrantToTicketTable
     */
    public $EntrantToTicket;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EntrantToTicket'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EntrantToTicket') ? [] : ['className' => EntrantToTicketTable::class];
        $this->EntrantToTicket = TableRegistry::getTableLocator()->get('EntrantToTicket', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EntrantToTicket);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
