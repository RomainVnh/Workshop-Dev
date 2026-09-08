<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\UtilisateursController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\UtilisateursController Test Case
 *
 * @link \App\Controller\UtilisateursController
 */
class UtilisateursControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Utilisateurs',
        'app.Chaussettes',
        'app.Propositions',
    ];
}
