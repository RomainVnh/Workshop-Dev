<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Propositions Model
 *
 * @method \App\Model\Entity\Proposition newEmptyEntity()
 * @method \App\Model\Entity\Proposition newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Proposition> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Proposition get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Proposition findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Proposition patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Proposition> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Proposition|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Proposition saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Proposition>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Proposition>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Proposition>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Proposition> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Proposition>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Proposition>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Proposition>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Proposition> deleteManyOrFail(iterable $entities, array $options = [])
 */
class PropositionsTable extends Table
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

        $this->setTable('proposition');
        $this->setDisplayField('statut');
        $this->setPrimaryKey('id_proposition');

        $this->belongsTo('UtilisateurEmetteur', [
            'className' => 'Utilisateurs',
            'foreignKey' => 'id_utilisateur_emetteur',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('UtilisateurReceveur', [
            'className' => 'Utilisateurs',
            'foreignKey' => 'id_utilisateur_receveur',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ChaussetteOfferte', [
            'className' => 'Chaussettes',
            'foreignKey' => 'id_chaussette_offerte',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ChaussetteConvoitee', [
            'className' => 'Chaussettes',
            'foreignKey' => 'id_chaussette_convoitee',
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
            ->integer('id_utilisateur_emetteur')
            ->requirePresence('id_utilisateur_emetteur', 'create')
            ->notEmptyString('id_utilisateur_emetteur');

        $validator
            ->integer('id_utilisateur_receveur')
            ->requirePresence('id_utilisateur_receveur', 'create')
            ->notEmptyString('id_utilisateur_receveur');

        $validator
            ->integer('id_chaussette_offerte')
            ->requirePresence('id_chaussette_offerte', 'create')
            ->notEmptyString('id_chaussette_offerte');

        $validator
            ->integer('id_chaussette_convoitee')
            ->requirePresence('id_chaussette_convoitee', 'create')
            ->notEmptyString('id_chaussette_convoitee');

        $validator
            ->scalar('message')
            ->allowEmptyString('message');

        $validator
            ->scalar('statut')
            ->notEmptyString('statut')
            ->inList('statut', ['en_attente', 'acceptee', 'refusee']);

        $validator
            ->dateTime('date_proposition')
            ->notEmptyDateTime('date_proposition');

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
        $rules->add(
            $rules->existsIn(['id_utilisateur_emetteur'], 'UtilisateurEmetteur'),
            ['errorField' => 'id_utilisateur_emetteur'],
        );
        $rules->add(
            $rules->existsIn(['id_utilisateur_receveur'], 'UtilisateurReceveur'),
            ['errorField' => 'id_utilisateur_receveur'],
        );
        $rules->add(
            $rules->existsIn(['id_chaussette_offerte'], 'ChaussetteOfferte'),
            ['errorField' => 'id_chaussette_offerte'],
        );
        $rules->add(
            $rules->existsIn(['id_chaussette_convoitee'], 'ChaussetteConvoitee'),
            ['errorField' => 'id_chaussette_convoitee'],
        );

        return $rules;
    }
}
