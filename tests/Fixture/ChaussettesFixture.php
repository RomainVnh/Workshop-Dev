<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ChaussettesFixture
 */
class ChaussettesFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'chaussette';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id_chaussette' => 1,
                'id_utilisateur' => 1,
                'couleur' => 'Lorem ipsum dolor sit amet',
                'motif' => 'Lorem ipsum dolor sit amet',
                'pointure' => 'Lorem ipsum dolor ',
                'matiere' => 'Lorem ipsum dolor sit amet',
                'note' => 'Lorem ipsum dolor sit amet',
                'photo' => 'Lorem ipsum dolor sit amet',
                'statut' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
