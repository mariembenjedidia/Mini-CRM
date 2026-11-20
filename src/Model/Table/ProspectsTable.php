<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ProspectsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('prospects');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->hasOne('Clients', [
            'foreignKey' => 'prospect_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('company_name', 'Le nom de l\'entreprise est requis.')
            ->allowEmptyString('email')
            ->email('email', false, 'Email invalide.')
            ->allowEmptyString('phone')
            ->allowEmptyString('city');

        return $validator;
    }
}