<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DepartamentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DepartamentsTable Test Case
 */
class DepartamentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DepartamentsTable
     */
    public $Departaments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Departaments'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Departaments') ? [] : ['className' => DepartamentsTable::class];
        $this->Departaments = TableRegistry::getTableLocator()->get('Departaments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Departaments);

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
