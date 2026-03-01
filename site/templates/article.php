<?php snippet('header') ?>

<article>
  <header class="article-header intro">
    <h1><?= $page->title()->esc() ?></h1>

    <div class="article-meta">
      <?php if ($page->date()->isNotEmpty()): ?>
      <time datetime="<?= $page->date()->toDate('c') ?>">
        <?= $page->date()->toDate('F j, Y') ?>
      </time>
      <?php endif ?>

      <?php if ($page->author()->isNotEmpty()): ?>
      <span class="author">by <?= $page->author()->esc() ?></span>
      <?php endif ?>
    </div>
  </header>

  <?php snippet('layouts', ['field' => $page->layout()]) ?>
</article>

<?php snippet('footer') ?>
