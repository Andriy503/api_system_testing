<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BundlesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BundlesTable Test Case
 */
class BundlesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BundlesTable
     */
    public $Bundles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Bundles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Bundles') ? [] : ['className' => BundlesTable::class];
        $this->Bundles = TableRegistry::getTableLocator()->get('Bundles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Bundles);

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
