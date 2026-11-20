<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProspectsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProspectsTable Test Case
 */
class ProspectsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProspectsTable
     */
    protected $Prospects;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Prospects',
        'app.Calls',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Prospects') ? [] : ['className' => ProspectsTable::class];
        $this->Prospects = $this->getTableLocator()->get('Prospects', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Prospects);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ProspectsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
