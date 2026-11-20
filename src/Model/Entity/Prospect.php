<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Prospect Entity
 *
 * @property int $id
 * @property string $company_name
 * @property string $contact_name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $city
 * @property string|null $source
 * @property string|null $status
 * @property string|null $notes
 *
 * @property \App\Model\Entity\Call[] $calls
 */
class Prospect extends Entity
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
        'company_name' => true,
        'contact_name' => true,
        'email' => true,
        'phone' => true,
        'city' => true,
        'source' => true,
        'status' => true,
        'notes' => true,
        'calls' => true,
    ];
}
