<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PropositionsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PropositionsTable Test Case
 */
class PropositionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PropositionsTable
     */
    protected $Propositions;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Propositions',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Propositions') ? [] : ['className' => PropositionsTable::class];
        $this->Propositions = $this->getTableLocator()->get('Propositions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Propositions);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\PropositionsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
