<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EntrantAnswersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EntrantAnswersTable Test Case
 */
class EntrantAnswersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EntrantAnswersTable
     */
    public $EntrantAnswers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EntrantAnswers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EntrantAnswers') ? [] : ['className' => EntrantAnswersTable::class];
        $this->EntrantAnswers = TableRegistry::getTableLocator()->get('EntrantAnswers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EntrantAnswers);

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
