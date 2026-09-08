<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="auth-card">
    <h1>Connexion</h1>
    <?= $this->Form->create() ?>
    <?= $this->Form->control('email', ['type' => 'email', 'label' => 'Email']) ?>
    <?= $this->Form->control('mot_de_passe', ['type' => 'password', 'label' => 'Mot de passe']) ?>
    <?= $this->Form->button('Se connecter', ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>

    <p><?= $this->Html->link("Pas encore de compte ? S'inscrire", ['action' => 'add']) ?></p>
</div>
