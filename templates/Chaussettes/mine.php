<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Chaussette> $chaussettes
 */
?>
<div class="page-head">
    <div>
        <h2>Mon tiroir</h2>
        <p class="muted">Tes chaussettes seules, en attente d'une jumelle.</p>
    </div>
    <?= $this->Html->link('+ Déposer une chaussette', ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
</div>

<div class="sock-grid">
    <?php if (!$chaussettes->count()) : ?>
        <div class="empty-state">Ton tiroir est vide pour l'instant — dépose une chaussette pour commencer.</div>
    <?php else : ?>
        <?php foreach ($chaussettes as $chaussette) : ?>
            <?= $this->element('sock_card', ['chaussette' => $chaussette, 'mode' => 'mine']) ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
