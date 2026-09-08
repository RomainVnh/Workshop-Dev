<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Chaussettes Model
 *
 * @method \App\Model\Entity\Chaussette newEmptyEntity()
 * @method \App\Model\Entity\Chaussette newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Chaussette> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Chaussette get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Chaussette findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Chaussette patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Chaussette> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Chaussette|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Chaussette saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Chaussette>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Chaussette>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Chaussette>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Chaussette> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Chaussette>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Chaussette>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Chaussette>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Chaussette> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ChaussettesTable extends Table
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

        $this->setTable('chaussette');
        $this->setDisplayField('couleur');
        $this->setPrimaryKey('id_chaussette');

        $this->belongsTo('Utilisateurs', [
            'foreignKey' => 'id_utilisateur',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('PropositionsOffertes', [
            'className' => 'Propositions',
            'foreignKey' => 'id_chaussette_offerte',
        ]);
        $this->hasMany('PropositionsConvoitees', [
            'className' => 'Propositions',
            'foreignKey' => 'id_chaussette_convoitee',
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
            ->integer('id_utilisateur')
            ->requirePresence('id_utilisateur', 'create')
            ->notEmptyString('id_utilisateur');

        $validator
            ->scalar('couleur')
            ->maxLength('couleur', 100)
            ->requirePresence('couleur', 'create')
            ->notEmptyString('couleur');

        $validator
            ->scalar('motif')
            ->maxLength('motif', 150)
            ->allowEmptyString('motif');

        $validator
            ->scalar('pointure')
            ->maxLength('pointure', 20)
            ->requirePresence('pointure', 'create')
            ->notEmptyString('pointure');

        $validator
            ->scalar('matiere')
            ->maxLength('matiere', 100)
            ->allowEmptyString('matiere');

        $validator
            ->scalar('note')
            ->maxLength('note', 255)
            ->allowEmptyString('note');

        $validator
            ->scalar('photo')
            ->maxLength('photo', 255)
            ->allowEmptyString('photo');

        $validator
            ->scalar('statut')
            ->notEmptyString('statut');

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
        $rules->add($rules->existsIn(['id_utilisateur'], 'Utilisateurs'), ['errorField' => 'id_utilisateur']);

        return $rules;
    }
}
