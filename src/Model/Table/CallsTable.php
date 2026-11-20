<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Calls Model
 *
 * @property \App\Model\Table\ProspectsTable&\Cake\ORM\Association\BelongsTo $Prospects
 *
 * @method \App\Model\Entity\Call newEmptyEntity()
 * @method \App\Model\Entity\Call newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Call> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Call get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Call findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Call patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Call> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Call|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Call saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Call>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Call>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Call>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Call> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Call>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Call>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Call>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Call> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CallsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('calls');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Prospects', [
            'foreignKey' => 'prospect_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('prospect_id')
            ->notEmptyString('prospect_id');

        $validator
            ->dateTime('call_date')
            ->requirePresence('call_date', 'create')
            ->notEmptyDateTime('call_date');

        $validator
            ->scalar('subject')
            ->maxLength('subject', 255)
            ->allowEmptyString('subject');

        $validator
            ->scalar('comment')
            ->allowEmptyString('comment');

        $validator
            ->dateTime('next_call_date')
            ->allowEmptyDateTime('next_call_date');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['prospect_id'], 'Prospects'), ['errorField' => 'prospect_id']);

        return $rules;
    }
}
