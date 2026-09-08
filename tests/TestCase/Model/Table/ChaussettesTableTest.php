<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ChaussettesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ChaussettesTable Test Case
 */
class ChaussettesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ChaussettesTable
     */
    protected $Chaussettes;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Chaussettes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Chaussettes') ? [] : ['className' => ChaussettesTable::class];
        $this->Chaussettes = $this->getTableLocator()->get('Chaussettes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Chaussettes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ChaussettesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
