<?php
/** @var \Kirby\Cms\Block $block */
$caption         = $block->caption();
$crop            = $block->crop()->isTrue();
$ratio           = $block->ratio()->or('auto');
$lightbox        = $block->lightbox()->isNotEmpty() ? $block->lightbox()->toBool() : true;
$autorotate      = $block->autorotate()->isNotEmpty() ? $block->autorotate()->toBool() : true;
$rotateInterval  = $block->rotateInterval()->isNotEmpty() ? $block->rotateInterval()->toInt() : 4;
$showNavigation  = $block->showNavigation()->isNotEmpty() ? $block->showNavigation()->toBool() : true;
?>
<figure<?= Html::attr([
  'data-ratio' => $ratio,
  'data-crop' => $crop,
  'data-lightbox' => $lightbox ? 'true' : 'false',
  'data-autorotate' => $autorotate ? 'true' : 'false',
  'data-rotate-interval' => $rotateInterval * 1000,
  'data-show-navigation' => $showNavigation ? 'true' : 'false'
], null, ' ') ?> class="gallery-block">
  <ul>
    <?php foreach ($block->images()->toFiles() as $image): ?>
    <li>
      <?php if ($lightbox): ?>
      <a href="<?= $image->url() ?>" class="glightbox" data-gallery="gallery-<?= $block->id() ?>">
        <img src="<?= $image->url() ?>" alt="<?= $image->alt()->or('Gallery image') ?>" loading="lazy">
      </a>
      <?php else: ?>
      <img src="<?= $image->url() ?>" alt="<?= $image->alt()->or('Gallery image') ?>" loading="lazy">
      <?php endif ?>
    </li>
    <?php endforeach ?>
  </ul>
  <?php if ($caption->isNotEmpty()): ?>
  <figcaption>
    <?= $caption ?>
  </figcaption>
  <?php endif ?>
</figure>
