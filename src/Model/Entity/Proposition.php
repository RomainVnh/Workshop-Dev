<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Proposition Entity
 *
 * @property int $id_proposition
 * @property int $id_utilisateur_emetteur
 * @property int $id_utilisateur_receveur
 * @property int $id_chaussette_offerte
 * @property int $id_chaussette_convoitee
 * @property string|null $message
 * @property string $statut
 * @property \Cake\I18n\DateTime $date_proposition
 */
class Proposition extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'id_chaussette_offerte' => true,
        'message' => true,
    ];
}
