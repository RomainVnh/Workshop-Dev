<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Proposition> $recues
 * @var iterable<\App\Model\Entity\Proposition> $envoyees
 */
$statutLabel = [
    'en_attente' => 'En attente',
    'acceptee' => 'Acceptée',
    'refusee' => 'Refusée',
];
$sockLabel = fn($sock) => h($sock->couleur) . ($sock->motif ? ' · ' . h($sock->motif) : '');
?>
<h2>Mes propositions</h2>

<div class="proposals-cols">
    <div>
        <h3 class="section-title">Reçues</h3>
        <ul class="proposal-list">
            <?php if (!$recues->count()) : ?>
                <li class="empty-note">Aucune proposition reçue pour le moment.</li>
            <?php endif; ?>
            <?php foreach ($recues as $proposition) : ?>
                <li class="proposal-card">
                    <div class="prop-top">
                        <span class="prop-who"><?= h($proposition->utilisateur_emetteur->nom) ?> te propose un échange</span>
                        <span class="status-pill status-<?= h($proposition->statut) ?>"><?= $statutLabel[$proposition->statut] ?></span>
                    </div>
                    <div class="prop-swap">
                        <span class="mini-sock"><?= $sockLabel($proposition->chaussette_offerte) ?></span>
                        <span aria-hidden="true">→</span>
                        <span class="mini-sock"><?= $sockLabel($proposition->chaussette_convoitee) ?></span>
                    </div>
                    <?php if ($proposition->message) : ?>
                        <div class="prop-message">« <?= h($proposition->message) ?> »</div>
                    <?php endif; ?>
                    <?php if ($proposition->statut === 'en_attente') : ?>
                        <div class="prop-actions">
                            <?= $this->Form->postLink('Accepter', ['action' => 'accepter', $proposition->id_proposition], ['class' => 'btn btn-accept btn-sm']) ?>
                            <?= $this->Form->postLink('Refuser', ['action' => 'refuser', $proposition->id_proposition], ['class' => 'btn btn-decline btn-sm']) ?>
                        </div>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div>
        <h3 class="section-title">Envoyées</h3>
        <ul class="proposal-list">
            <?php if (!$envoyees->count()) : ?>
                <li class="empty-note">Tu n'as encore proposé aucun échange.</li>
            <?php endif; ?>
            <?php foreach ($envoyees as $proposition) : ?>
                <li class="proposal-card">
                    <div class="prop-top">
                        <span class="prop-who">Toi → <?= h($proposition->utilisateur_receveur->nom) ?></span>
                        <span class="status-pill status-<?= h($proposition->statut) ?>"><?= $statutLabel[$proposition->statut] ?></span>
                    </div>
                    <div class="prop-swap">
                        <span class="mini-sock"><?= $sockLabel($proposition->chaussette_offerte) ?></span>
                        <span aria-hidden="true">→</span>
                        <span class="mini-sock"><?= $sockLabel($proposition->chaussette_convoitee) ?></span>
                    </div>
                    <?php if ($proposition->message) : ?>
                        <div class="prop-message">« <?= h($proposition->message) ?> »</div>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
