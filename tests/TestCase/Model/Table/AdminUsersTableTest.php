<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AdminUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AdminUsersTable Test Case
 */
class AdminUsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AdminUsersTable
     */
    public $AdminUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.AdminUsers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AdminUsers') ? [] : ['className' => AdminUsersTable::class];
        $this->AdminUsers = TableRegistry::getTableLocator()->get('AdminUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AdminUsers);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
