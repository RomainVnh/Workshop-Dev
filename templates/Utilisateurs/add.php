<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Utilisateur $utilisateur
 */
?>
<div class="auth-card">
    <h1>Inscription</h1>
    <?= $this->Form->create($utilisateur) ?>
    <?= $this->Form->control('nom', ['label' => 'Nom']) ?>
    <?= $this->Form->control('email', ['type' => 'email', 'label' => 'Email']) ?>
    <?= $this->Form->control('mot_de_passe', ['type' => 'password', 'label' => 'Mot de passe']) ?>
    <?= $this->Form->button("S'inscrire", ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>

    <p><?= $this->Html->link('Déjà un compte ? Se connecter', ['action' => 'login']) ?></p>
</div>
