<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Call Entity
 *
 * @property int $id
 * @property int $prospect_id
 * @property \Cake\I18n\DateTime $call_date
 * @property string|null $subject
 * @property string|null $comment
 * @property \Cake\I18n\DateTime|null $next_call_date
 * @property \Cake\I18n\DateTime|null $created
 *
 * @property \App\Model\Entity\Prospect $prospect
 */
class Call extends Entity
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
        'prospect_id' => true,
        'call_date' => true,
        'subject' => true,
        'comment' => true,
        'next_call_date' => true,
        'created' => true,
        'prospect' => true,
    ];
}
