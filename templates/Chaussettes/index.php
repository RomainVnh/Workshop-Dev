<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Chaussette> $chaussettes
 * @var array<string> $couleurs
 * @var string|null $couleur
 */
?>
<div class="page-head">
    <div>
        <h2>Les chaussettes en attente d'une moitié</h2>
        <p class="muted">Parcours les chaussettes seules déposées par la communauté et propose un échange.</p>
    </div>
    <?= $this->Form->create(null, ['type' => 'get', 'class' => 'filter-row']) ?>
    <?= $this->Form->control('couleur', [
        'type' => 'select',
        'label' => 'Couleur',
        'options' => array_combine($couleurs, $couleurs),
        'empty' => 'Toutes',
        'value' => $couleur,
        'onchange' => 'this.form.submit()',
    ]) ?>
    <?= $this->Form->end() ?>
</div>

<div class="sock-grid">
    <?php if (!$chaussettes->count()) : ?>
        <div class="empty-state">Aucune chaussette ne correspond à ce filtre pour le moment.</div>
    <?php else : ?>
        <?php foreach ($chaussettes as $chaussette) : ?>
            <?= $this->element('sock_card', ['chaussette' => $chaussette, 'mode' => 'browse']) ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
