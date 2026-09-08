<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;

/**
 * Chaussettes Controller
 *
 * @property \App\Model\Table\ChaussettesTable $Chaussettes
 */
class ChaussettesController extends AppController
{
    /**
     * @return void
     */
    public function index(): void
    {
        $idUtilisateur = $this->currentUserId();

        $couleur = $this->request->getQuery('couleur');

        $query = $this->Chaussettes->find()
            ->contain(['Utilisateurs'])
            ->where([
                'Chaussettes.statut' => 'disponible',
                'Chaussettes.id_utilisateur !=' => $idUtilisateur,
            ])
            ->orderBy(['Chaussettes.id_chaussette' => 'DESC']);

        if ($couleur) {
            $query->where(['Chaussettes.couleur' => $couleur]);
        }

        $chaussettes = $query->all();

        $couleurs = $this->Chaussettes->find()
            ->select(['couleur'])
            ->distinct()
            ->orderBy(['couleur' => 'ASC'])
            ->all()
            ->extract('couleur')
            ->toArray();

        $this->set(compact('chaussettes', 'couleurs', 'couleur'));
    }

    /**
     * @return void
     */
    public function mine(): void
    {
        $idUtilisateur = $this->currentUserId();

        $chaussettes = $this->Chaussettes->find()
            ->where(['id_utilisateur' => $idUtilisateur])
            ->orderBy(['id_chaussette' => 'DESC'])
            ->all();

        $this->set(compact('chaussettes'));
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function add(): ?Response
    {
        $chaussette = $this->Chaussettes->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['id_utilisateur'] = $this->currentUserId();

            $chaussette = $this->Chaussettes->patchEntity($chaussette, $data, [
                'accessibleFields' => ['id_utilisateur' => true],
            ]);

            if ($this->Chaussettes->save($chaussette)) {
                $this->Flash->success('Chaussette ajoutée à ton tiroir.');

                return $this->redirect(['action' => 'mine']);
            }

            $this->Flash->error("La chaussette n'a pas pu être ajoutée.");
        }

        $this->set(compact('chaussette'));

        return null;
    }
}
