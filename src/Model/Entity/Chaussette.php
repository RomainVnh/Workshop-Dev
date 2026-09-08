<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Chaussette Entity
 *
 * @property int $id_chaussette
 * @property int $id_utilisateur
 * @property string $couleur
 * @property string|null $motif
 * @property string $pointure
 * @property string|null $matiere
 * @property string|null $note
 * @property string|null $photo
 * @property string $statut
 */
class Chaussette extends Entity
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
        'couleur' => true,
        'motif' => true,
        'pointure' => true,
        'matiere' => true,
        'note' => true,
        'photo' => true,
    ];
}
