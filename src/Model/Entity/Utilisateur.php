<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * Utilisateur Entity
 *
 * @property int $id_utilisateur
 * @property string $nom
 * @property string $email
 * @property string $mot_de_passe
 * @property \Cake\I18n\DateTime $date_inscription
 */
class Utilisateur extends Entity
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
        'nom' => true,
        'email' => true,
        'mot_de_passe' => true,
        'date_inscription' => true,
    ];

    /**
     * @var array<string>
     */
    protected array $_hidden = [
        'mot_de_passe',
    ];

    /**
     * @param string $value Password
     * @return string
     */
    protected function _setMotDePasse(string $value): string
    {
        $hasher = new DefaultPasswordHasher();

        return $hasher->hash($value);
    }
}
