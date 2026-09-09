<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Chaussette $chaussette
 */
$hasPhoto = $chaussette->photo && file_exists(WWW_ROOT . 'img' . DS . 'chaussettes' . DS . $chaussette->photo);
?>
<h2>Modifier ma chaussette</h2>

<div class="edit-layout">
    <div class="form-card">
        <?= $this->Form->create($chaussette, ['type' => 'file']) ?>
        <?= $this->Form->control('couleur', ['label' => 'Couleur principale', 'placeholder' => 'Ex : bleu marine']) ?>
        <?= $this->Form->control('motif', ['label' => 'Motif', 'placeholder' => 'Ex : rayures fines, unie, à pois...']) ?>

        <div class="field-row">
            <?= $this->Form->control('pointure', ['label' => 'Pointure', 'placeholder' => 'Ex : 39-42']) ?>
            <?= $this->Form->control('matiere', ['label' => 'Matière', 'placeholder' => 'Ex : coton']) ?>
        </div>

        <?= $this->Form->control('note', [
            'label' => 'Petite note (optionnel)',
            'placeholder' => 'Ex : perdue au lavage il y a un mois, presque neuve',
        ]) ?>
        <?= $this->Form->control('photo', [
            'type' => 'file',
            'id' => 'photo-input',
            'label' => $hasPhoto ? 'Remplacer la photo (optionnel)' : 'Photo (optionnel)',
            'accept' => 'image/jpeg,image/png,image/webp',
        ]) ?>

        <?= $this->Form->button('Enregistrer', ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>
    </div>

    <div class="edit-photo" id="photo-preview" style="<?= $hasPhoto ? '' : 'display: none;' ?>">
        <img id="photo-preview-img" src="<?= $hasPhoto ? $this->Url->build('/img/chaussettes/' . $chaussette->photo) : '' ?>" alt="">
        <p id="photo-preview-label">Photo actuelle</p>
    </div>
</div>

<script>
document.getElementById('photo-input').addEventListener('change', function () {
    var file = this.files[0];

    if (!file) {
        return;
    }

    document.getElementById('photo-preview-img').src = URL.createObjectURL(file);
    document.getElementById('photo-preview-label').textContent = 'Nouvelle photo (aperçu)';
    document.getElementById('photo-preview').style.display = 'flex';
});
</script>
