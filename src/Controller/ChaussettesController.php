<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;
use finfo;
use Psr\Http\Message\UploadedFileInterface;

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

        // Gestion de la photo
        $photo = $data['photo'] ?? null;

        if ($photo instanceof UploadedFileInterface && $photo->getError() !== UPLOAD_ERR_NO_FILE) {
            if ($photo->getError() !== UPLOAD_ERR_OK) {
                $this->Flash->error("La photo n'a pas pu être envoyée.");
                $this->set(compact('chaussette'));
                return null;
            }

            // Taille maximale : 5 Mo
            if ($photo->getSize() > 5 * 1024 * 1024) {
                $this->Flash->error('La photo ne doit pas dépasser 5 Mo.');
                $this->set(compact('chaussette'));
                return null;
            }

            // Vérification réelle du type du fichier
            $tmpFile = $photo->getStream()->getMetadata('uri');

            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($tmpFile);

            $allowedTypes = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp',
            ];

            if (!isset($allowedTypes[$mimeType])) {
                $this->Flash->error(
                    'Format de photo non autorisé. Utilise uniquement JPG, PNG ou WEBP.'
                );

                $this->set(compact('chaussette'));
                return null;
            }

            // Création du dossier de stockage si nécessaire
            $uploadDirectory = WWW_ROOT . 'img' . DS . 'chaussettes' . DS;

            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0775, true);
            }

            // Nom unique et sécurisé
            $extension = $allowedTypes[$mimeType];
            $filename = bin2hex(random_bytes(16)) . '.' . $extension;

            // Déplacement de la photo
            $photo->moveTo($uploadDirectory . $filename);

            // On stocke uniquement le nom du fichier en BDD
            $data['photo'] = $filename;
        } else {
            // Aucune photo sélectionnée
            $data['photo'] = null;
        }

        $chaussette = $this->Chaussettes->patchEntity(
            $chaussette,
            $data,
            [
                'accessibleFields' => [
                    'id_utilisateur' => true
                ],
            ]
        );

        if ($this->Chaussettes->save($chaussette)) {
            $this->Flash->success('Chaussette ajoutée à ton tiroir.');

            return $this->redirect(['action' => 'mine']);
        }

        $this->Flash->error("La chaussette n'a pas pu être ajoutée.");
    }

    $this->set(compact('chaussette'));

    return null;
}

    /**
     * @param string|null $id Chaussette id
     * @return \Cake\Http\Response|null
     */
    public function edit(?string $id = null): ?Response
    {
        $chaussette = $this->Chaussettes->get($id);

        if ($chaussette->id_utilisateur !== $this->currentUserId()) {
            $this->Flash->error("Cette chaussette n'est pas dans ton tiroir.");

            return $this->redirect(['action' => 'mine']);
        }

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();

            $photo = $data['photo'] ?? null;

            if ($photo instanceof UploadedFileInterface && $photo->getError() !== UPLOAD_ERR_NO_FILE) {
                if ($photo->getError() !== UPLOAD_ERR_OK) {
                    $this->Flash->error("La photo n'a pas pu être envoyée.");
                    $this->set(compact('chaussette'));

                    return null;
                }

                if ($photo->getSize() > 5 * 1024 * 1024) {
                    $this->Flash->error('La photo ne doit pas dépasser 5 Mo.');
                    $this->set(compact('chaussette'));

                    return null;
                }

                $tmpFile = $photo->getStream()->getMetadata('uri');

                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mimeType = $finfo->file($tmpFile);

                $allowedTypes = [
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/webp' => 'webp',
                ];

                if (!isset($allowedTypes[$mimeType])) {
                    $this->Flash->error('Format de photo non autorisé. Utilise uniquement JPG, PNG ou WEBP.');
                    $this->set(compact('chaussette'));

                    return null;
                }

                $uploadDirectory = WWW_ROOT . 'img' . DS . 'chaussettes' . DS;

                if (!is_dir($uploadDirectory)) {
                    mkdir($uploadDirectory, 0775, true);
                }

                $extension = $allowedTypes[$mimeType];
                $filename = bin2hex(random_bytes(16)) . '.' . $extension;
                $photo->moveTo($uploadDirectory . $filename);

                $data['photo'] = $filename;
            } else {
                unset($data['photo']);
            }

            $chaussette = $this->Chaussettes->patchEntity($chaussette, $data);

            if ($this->Chaussettes->save($chaussette)) {
                $this->Flash->success('Chaussette mise à jour.');

                return $this->redirect(['action' => 'mine']);
            }

            $this->Flash->error("La chaussette n'a pas pu être mise à jour.");
        }

        $this->set(compact('chaussette'));

        return null;
    }

    /**
     * @param string|null $id Chaussette id
     * @return \Cake\Http\Response|null
     */
    public function delete(?string $id = null): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);

        $chaussette = $this->Chaussettes->get($id);

        if ($chaussette->id_utilisateur !== $this->currentUserId()) {
            $this->Flash->error("Cette chaussette n'est pas dans ton tiroir.");

            return $this->redirect(['action' => 'mine']);
        }

        if ($this->Chaussettes->delete($chaussette)) {
            $this->Flash->success('Chaussette supprimée.');
        } else {
            $this->Flash->error("La chaussette n'a pas pu être supprimée.");
        }

        return $this->redirect(['action' => 'mine']);
    }
}