<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Chaussette $chaussette
 * @var string $mode 'browse' or 'mine'
 */
$palette = ['#FF6B5C', '#F2A93B', '#2FA6A0', '#6C8EBF', '#B266B2', '#5CB85C'];
$hash = crc32($chaussette->couleur . $chaussette->motif);
$swatch = $palette[$hash % count($palette)];
$hasPhoto = $chaussette->photo && file_exists(WWW_ROOT . 'img' . DS . 'chaussettes' . DS . $chaussette->photo);
?>
<article class="sock-card">
    <div class="sock-visual" style="--sock-bg: <?= $swatch ?>">
        <?php if ($hasPhoto) : ?>
            <img
                src="<?= $this->Url->build('/img/chaussettes/' . $chaussette->photo) ?>"
                alt="Photo de la chaussette"
            >
        <?php else : ?>
            🧦
        <?php endif; ?>
    </div>

    <?php if ($mode === 'browse') : ?>
        <span class="sock-owner">Chez <?= h($chaussette->utilisateur->nom) ?></span>
    <?php else : ?>
        <span class="status-pill status-<?= h($chaussette->statut) ?>"><?= h($chaussette->statut) ?></span>
    <?php endif; ?>

    <div class="sock-name"><?= h($chaussette->couleur) ?><?= $chaussette->motif ? ' · ' . h($chaussette->motif) : '' ?></div>
    <div class="sock-meta">Pointure <?= h($chaussette->pointure) ?><?= $chaussette->matiere ? ' · ' . h($chaussette->matiere) : '' ?></div>

    <?php if ($chaussette->note) : ?>
        <div class="sock-note">« <?= h($chaussette->note) ?> »</div>
    <?php endif; ?>

    <?php if ($mode === 'browse') : ?>
        <?= $this->Html->link('Proposer un échange', [
            'controller' => 'Propositions',
            'action' => 'add',
            $chaussette->id_chaussette,
        ], ['class' => 'btn btn-primary']) ?>
    <?php else : ?>
        <?= $this->Html->link('Modifier', [
            'action' => 'edit',
            $chaussette->id_chaussette,
        ], ['class' => 'btn btn-ghost']) ?>
        <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $chaussette->id_chaussette], ['class' => 'btn btn-decline btn-sm', 'confirm' => 'Supprimer cette chaussette ?']) ?>
    <?php endif; ?>
</article>



