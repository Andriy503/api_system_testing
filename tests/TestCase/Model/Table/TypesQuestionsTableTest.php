<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TypesQuestionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TypesQuestionsTable Test Case
 */
class TypesQuestionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TypesQuestionsTable
     */
    public $TypesQuestions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TypesQuestions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TypesQuestions') ? [] : ['className' => TypesQuestionsTable::class];
        $this->TypesQuestions = TableRegistry::getTableLocator()->get('TypesQuestions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TypesQuestions);

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
