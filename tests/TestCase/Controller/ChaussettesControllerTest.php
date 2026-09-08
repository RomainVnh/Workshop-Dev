<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ChaussettesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ChaussettesController Test Case
 *
 * @link \App\Controller\ChaussettesController
 */
class ChaussettesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Chaussettes',
        'app.Utilisateurs',
        'app.Propositions',
    ];
}
