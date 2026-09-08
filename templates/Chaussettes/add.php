<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Chaussette $chaussette
 */
?>
<h2>Déposer une chaussette seule</h2>

<div class="form-card">
    <?= $this->Form->create($chaussette, ['type' => 'file']) ?>

    <?= $this->Form->control('couleur', [
        'label' => 'Couleur principale',
        'placeholder' => 'Ex : bleu marine'
    ]) ?>

    <?= $this->Form->control('motif', [
        'label' => 'Motif',
        'placeholder' => 'Ex : rayures fines, unie, à pois...'
    ]) ?>

    <div class="field-row">
        <?= $this->Form->control('pointure', [
            'label' => 'Pointure',
            'placeholder' => 'Ex : 39-42'
        ]) ?>

        <?= $this->Form->control('matiere', [
            'label' => 'Matière',
            'placeholder' => 'Ex : coton'
        ]) ?>
    </div>

    <?= $this->Form->control('note', [
        'label' => 'Petite note (optionnel)',
        'placeholder' => 'Ex : perdue au lavage il y a un mois, presque neuve'
    ]) ?>

    <?= $this->Form->control('photo', [
        'type' => 'file',
        'label' => 'Photo de la chaussette',
        'accept' => 'image/jpeg,image/png,image/webp'
    ]) ?>

    <?= $this->Form->button('Ajouter à mon tiroir', [
        'class' => 'btn btn-primary'
    ]) ?>

    <?= $this->Form->end() ?>
</div>