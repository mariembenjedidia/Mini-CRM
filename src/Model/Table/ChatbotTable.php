<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class ChatbotTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('chatbot');
        $this->setPrimaryKey('id');
    }
}