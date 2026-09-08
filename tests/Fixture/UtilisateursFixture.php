<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UtilisateursFixture
 */
class UtilisateursFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'utilisateur';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id_utilisateur' => 1,
                'nom' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'mot_de_passe' => 'Lorem ipsum dolor sit amet',
                'date_inscription' => '2026-09-07 09:42:26',
            ],
        ];
        parent::init();
    }
}
