<?php snippet('header') ?>

<article>
  <header class="intro">
    <h1><?= $page->title()->esc() ?></h1>
  </header>

  <?php snippet('layouts', ['field' => $page->layout()]) ?>
</article>

<?php snippet('footer') ?>
