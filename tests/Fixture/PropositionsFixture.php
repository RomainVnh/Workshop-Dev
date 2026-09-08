<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PropositionsFixture
 */
class PropositionsFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'proposition';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id_proposition' => 1,
                'id_utilisateur_emetteur' => 1,
                'id_utilisateur_receveur' => 1,
                'id_chaussette_offerte' => 1,
                'id_chaussette_convoitee' => 1,
                'message' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'statut' => 'Lorem ipsum dolor sit amet',
                'date_proposition' => '2026-09-07 09:42:30',
            ],
        ];
        parent::init();
    }
}
