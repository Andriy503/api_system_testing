<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EntrantsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EntrantsTable Test Case
 */
class EntrantsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EntrantsTable
     */
    public $Entrants;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Entrants',
        'app.Specialty'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Entrants') ? [] : ['className' => EntrantsTable::class];
        $this->Entrants = TableRegistry::getTableLocator()->get('Entrants', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Entrants);

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
