<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\PropositionsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\PropositionsController Test Case
 *
 * @link \App\Controller\PropositionsController
 */
class PropositionsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Propositions',
        'app.Utilisateurs',
        'app.Chaussettes',
    ];
}
