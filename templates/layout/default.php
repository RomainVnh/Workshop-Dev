<?php
/**
 * @var \App\View\AppView $this
 */
$identity = $this->request->getAttribute('identity');
$controller = $this->request->getParam('controller');
$action = $this->request->getParam('action');

$isActive = fn(string $ctrl, string $act): string => $controller === $ctrl && $action === $act ? ' is-active' : '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chaussette Orpheline — <?= $this->fetch('title') ?: 'troc de chaussettes seules' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <?= $this->Html->css('app') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body<?= $identity ? '' : ' class="guest-bg"' ?>>

<header class="app-header">
    <div class="wrap header-inner<?= $identity ? '' : ' header-inner--center' ?>">
        <div class="brand">
            <?= $this->Html->image('logo.png', ['class' => 'brand-icon', 'alt' => '']) ?>
            <div>
                <h1><a href="<?= $this->Url->build('/') ?>">Chaussette Orpheline</a></h1>
                <p class="tagline">Le troc des chaussettes qui ont perdu leur moitié</p>
            </div>
        </div>
        <?php if ($identity) : ?>
        <nav class="tabs" aria-label="Navigation principale">
            <a class="tab-link<?= $isActive('Chaussettes', 'index') ?>" href="<?= $this->Url->build(['controller' => 'Chaussettes', 'action' => 'index']) ?>">Parcourir</a>
            <a class="tab-link<?= $isActive('Chaussettes', 'mine') ?>" href="<?= $this->Url->build(['controller' => 'Chaussettes', 'action' => 'mine']) ?>">Mon tiroir</a>
            <a class="tab-link<?= $isActive('Propositions', 'index') ?>" href="<?= $this->Url->build(['controller' => 'Propositions', 'action' => 'index']) ?>">Propositions</a>
            <?= $this->Form->postLink('Déconnexion', ['controller' => 'Utilisateurs', 'action' => 'logout'], ['class' => 'tab-link']) ?>
        </nav>
        <?php endif; ?>
    </div>
</header>

<main class="wrap">
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</main>

<footer class="app-footer">
</footer>

</body>
</html>
