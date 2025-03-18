<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LoginHistorysTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LoginHistorysTable Test Case
 */
class LoginHistorysTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LoginHistorysTable
     */
    protected $LoginHistorys;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.LoginHistorys',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('LoginHistorys') ? [] : ['className' => LoginHistorysTable::class];
        $this->LoginHistorys = $this->getTableLocator()->get('LoginHistorys', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LoginHistorys);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LoginHistorysTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LoginHistorysTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
