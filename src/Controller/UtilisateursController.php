<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Utilisateurs Controller
 *
 * @property \App\Model\Table\UtilisateursTable $Utilisateurs
 */
class UtilisateursController extends AppController
{
    /**
     * @param \Cake\Event\EventInterface $event Event
     * @return void
     */
    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);

        $this->Authentication->addUnauthenticatedActions(['login', 'add']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function login(): ?Response
    {
        $result = $this->Authentication->getResult();

        if ($result && $result->isValid()) {
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Chaussettes',
                'action' => 'index',
            ]);

            return $this->redirect($redirect);
        }

        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Email ou mot de passe incorrect.');
        }

        return null;
    }

    /**
     * @return \Cake\Http\Response
     */
    public function logout(): Response
    {
        $this->Authentication->logout();

        return $this->redirect(['action' => 'login']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function add(): ?Response
    {
        $utilisateur = $this->Utilisateurs->newEmptyEntity();

        if ($this->request->is('post')) {
            $utilisateur = $this->Utilisateurs->patchEntity($utilisateur, $this->request->getData());

            if ($this->Utilisateurs->save($utilisateur)) {
                $this->Flash->success('Compte créé, tu peux te connecter.');

                return $this->redirect(['action' => 'login']);
            }

            $this->Flash->error("Le compte n'a pas pu être créé.");
        }

        $this->set(compact('utilisateur'));

        return null;
    }
}
