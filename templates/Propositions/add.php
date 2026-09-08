<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Proposition $proposition
 * @var \App\Model\Entity\Chaussette $chaussetteConvoitee
 * @var iterable<\App\Model\Entity\Chaussette> $mesChaussettes
 */
?>
<h2>Proposer un échange</h2>

<div class="form-card">
    <div class="target-sock">
        <div class="sock-visual">🧦</div>
        <div>
            <strong><?= h($chaussetteConvoitee->couleur) ?><?= $chaussetteConvoitee->motif ? ' · ' . h($chaussetteConvoitee->motif) : '' ?></strong>
            <br>
            <span class="small muted">Chez <?= h($chaussetteConvoitee->utilisateur->nom) ?> · pointure <?= h($chaussetteConvoitee->pointure) ?></span>
        </div>
    </div>

    <?= $this->Form->create($proposition) ?>

    <label>Choisis une de tes chaussettes à proposer en échange</label>
    <div class="sock-pick">
        <?php foreach ($mesChaussettes as $chaussette) : ?>
            <label class="pick-chip">
                <input type="radio" name="id_chaussette_offerte" value="<?= $chaussette->id_chaussette ?>" required>
                <?= h($chaussette->couleur) ?><?= $chaussette->motif ? ' · ' . h($chaussette->motif) : '' ?>
            </label>
        <?php endforeach; ?>
    </div>

    <?= $this->Form->control('message', ['label' => 'Petit mot (optionnel)', 'placeholder' => 'Ex : elle irait très bien avec ta rayée bleue !']) ?>
    <?= $this->Form->button('Envoyer la proposition', ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
</div>
