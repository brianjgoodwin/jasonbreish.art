<?php snippet('header') ?>

<article>
  <header class="intro">
    <h1><?= $page->title()->esc() ?></h1>
    <?php if ($page->text()->isNotEmpty()): ?>
    <div class="text">
      <?= $page->text()->kirbytext() ?>
    </div>
    <?php endif ?>
  </header>

  <?php
  $articles = $page->children()->listed()->sortBy('date', 'desc');
  $pagination = $articles->paginate(10);
  ?>

  <?php if ($articles->count() > 0): ?>
  <div class="articles">
    <?php foreach ($pagination as $article): ?>
    <article class="article-preview">
      <header>
        <h2><a href="<?= $article->url() ?>"><?= $article->title()->esc() ?></a></h2>
        <?php if ($article->date()->isNotEmpty()): ?>
        <time datetime="<?= $article->date()->toDate('c') ?>"><?= $article->date()->toDate('F j, Y') ?></time>
        <?php endif ?>
      </header>
      <?php if ($article->text()->isNotEmpty()): ?>
      <div class="excerpt">
        <?php
        // Handle both blocks and plain text content
        $text = $article->text();
        echo $text->toBlocks()->isNotEmpty()
          ? $text->toBlocks()->excerpt(300)
          : $text->kirbytext()->excerpt(300);
        ?>
      </div>
      <?php endif ?>
    </article>
    <?php endforeach ?>
  </div>

  <?php snippet('pagination', ['pagination' => $pagination]) ?>
  <?php endif ?>
</article>

<?php snippet('footer') ?>
