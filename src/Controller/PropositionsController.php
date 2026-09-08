<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;

/**
 * Propositions Controller
 *
 * @property \App\Model\Table\PropositionsTable $Propositions
 * @property \App\Model\Table\ChaussettesTable $Chaussettes
 */
class PropositionsController extends AppController
{
    /**
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->Chaussettes = $this->fetchTable('Chaussettes');
    }

    /**
     * @return void
     */
    public function index(): void
    {
        $idUtilisateur = $this->currentUserId();

        $recues = $this->Propositions->find()
            ->contain(['UtilisateurEmetteur', 'ChaussetteOfferte', 'ChaussetteConvoitee'])
            ->where(['id_utilisateur_receveur' => $idUtilisateur])
            ->orderBy(['date_proposition' => 'DESC'])
            ->all();

        $envoyees = $this->Propositions->find()
            ->contain(['UtilisateurReceveur', 'ChaussetteOfferte', 'ChaussetteConvoitee'])
            ->where(['id_utilisateur_emetteur' => $idUtilisateur])
            ->orderBy(['date_proposition' => 'DESC'])
            ->all();

        $this->set(compact('recues', 'envoyees'));
    }

    /**
     * @param string|null $idChaussetteConvoitee Id of the coveted sock
     * @return \Cake\Http\Response|null
     */
    public function add(?string $idChaussetteConvoitee = null): ?Response
    {
        $idUtilisateur = $this->currentUserId();

        $chaussetteConvoitee = $this->Chaussettes->find()
            ->where([
                'id_chaussette' => $idChaussetteConvoitee,
                'statut' => 'disponible',
            ])
            ->firstOrFail();

        if ($chaussetteConvoitee->id_utilisateur === $idUtilisateur) {
            $this->Flash->error('Tu ne peux pas proposer un échange sur ta propre chaussette.');

            return $this->redirect(['controller' => 'Chaussettes', 'action' => 'index']);
        }

        $mesChaussettes = $this->Chaussettes->find()
            ->where([
                'id_utilisateur' => $idUtilisateur,
                'statut' => 'disponible',
            ])
            ->all();

        $proposition = $this->Propositions->newEmptyEntity();

        if ($this->request->is('post')) {
            $idChaussetteOfferte = $this->request->getData('id_chaussette_offerte');

            $chaussetteOfferte = $this->Chaussettes->find()
                ->where([
                    'id_chaussette' => $idChaussetteOfferte,
                    'id_utilisateur' => $idUtilisateur,
                    'statut' => 'disponible',
                ])
                ->first();

            if (!$chaussetteOfferte) {
                $this->Flash->error('Choisis une de tes chaussettes disponibles à proposer en échange.');
            } else {
                $data = $this->request->getData();
                $data['id_utilisateur_emetteur'] = $idUtilisateur;
                $data['id_utilisateur_receveur'] = $chaussetteConvoitee->id_utilisateur;
                $data['id_chaussette_convoitee'] = $chaussetteConvoitee->id_chaussette;

                $proposition = $this->Propositions->patchEntity($proposition, $data, [
                    'accessibleFields' => [
                        'id_utilisateur_emetteur' => true,
                        'id_utilisateur_receveur' => true,
                        'id_chaussette_convoitee' => true,
                    ],
                ]);

                if ($this->Propositions->save($proposition)) {
                    $this->Flash->success('Proposition envoyée.');

                    return $this->redirect(['action' => 'index']);
                }

                $this->Flash->error("La proposition n'a pas pu être envoyée.");
            }
        }

        $this->set(compact('proposition', 'chaussetteConvoitee', 'mesChaussettes'));

        return null;
    }

    /**
     * @param string|null $id Proposition id
     * @return \Cake\Http\Response
     */
    public function accepter(?string $id = null): Response
    {
        $this->request->allowMethod(['post']);

        $proposition = $this->Propositions->get($id, contain: ['ChaussetteOfferte', 'ChaussetteConvoitee']);

        if ($proposition->id_utilisateur_receveur !== $this->currentUserId()) {
            $this->Flash->error("Cette proposition ne t'est pas destinée.");

            return $this->redirect(['action' => 'index']);
        }

        if ($proposition->statut !== 'en_attente') {
            $this->Flash->error('Cette proposition a déjà été traitée.');

            return $this->redirect(['action' => 'index']);
        }

        $chaussetteOfferte = $proposition->chaussette_offerte;
        $chaussetteConvoitee = $proposition->chaussette_convoitee;

        $this->Propositions->getConnection()->transactional(
            function () use ($proposition, $chaussetteOfferte, $chaussetteConvoitee): void {
                $chaussetteOfferte->id_utilisateur = $proposition->id_utilisateur_receveur;
                $chaussetteOfferte->statut = 'echangee';
                $this->Chaussettes->save($chaussetteOfferte);

                $chaussetteConvoitee->id_utilisateur = $proposition->id_utilisateur_emetteur;
                $chaussetteConvoitee->statut = 'echangee';
                $this->Chaussettes->save($chaussetteConvoitee);

                $proposition->statut = 'acceptee';
                $this->Propositions->save($proposition);

                $chaussettesEchangees = [$chaussetteOfferte->id_chaussette, $chaussetteConvoitee->id_chaussette];

                $this->Propositions->updateAll(
                    ['statut' => 'refusee'],
                    [
                        'statut' => 'en_attente',
                        'id_proposition !=' => $proposition->id_proposition,
                        'OR' => [
                            'id_chaussette_offerte IN' => $chaussettesEchangees,
                            'id_chaussette_convoitee IN' => $chaussettesEchangees,
                        ],
                    ],
                );
            },
        );

        $this->Flash->success('Échange conclu !');

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @param string|null $id Proposition id
     * @return \Cake\Http\Response
     */
    public function refuser(?string $id = null): Response
    {
        $this->request->allowMethod(['post']);

        $proposition = $this->Propositions->get($id);

        if ($proposition->id_utilisateur_receveur !== $this->currentUserId()) {
            $this->Flash->error("Cette proposition ne t'est pas destinée.");

            return $this->redirect(['action' => 'index']);
        }

        if ($proposition->statut !== 'en_attente') {
            $this->Flash->error('Cette proposition a déjà été traitée.');

            return $this->redirect(['action' => 'index']);
        }

        $proposition->statut = 'refusee';
        $this->Propositions->save($proposition);

        $this->Flash->success('Proposition refusée.');

        return $this->redirect(['action' => 'index']);
    }
}
