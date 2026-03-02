<?php
/**
 * Custom image block with size, shape, and lightbox options
 */

$alt      = $block->alt();
$caption  = $block->caption();
$crop     = $block->crop()->isTrue();
$link     = $block->link();
$ratio    = $block->ratio()->or('auto');
$src      = null;
$size     = $block->size()->isNotEmpty() ? $block->size()->value() : 'full';
$shape    = $block->shape()->isNotEmpty() ? $block->shape()->value() : 'square';
$noLightbox = $block->noLightbox()->isTrue();

if ($block->image()->toFile()) {
    $image = $block->image()->toFile();
    $src   = $crop ? $image->crop(1024, 1024)->url() : $image->url();
}

// Determine size class
$sizeClass = 'img-full';
if ($size === 'small') {
    $sizeClass = 'img-small';
} elseif ($size === 'medium') {
    $sizeClass = 'img-medium';
} elseif ($size === 'large') {
    $sizeClass = 'img-large';
}

// Determine shape class
$shapeClass = ($shape === 'circle') ? 'img-circle' : '';

// Build classes array
$classes = ['img', $sizeClass];
if ($shapeClass) {
    $classes[] = $shapeClass;
}
if ($noLightbox) {
    $classes[] = 'no-lightbox';
}

// Create class string
$classString = implode(' ', array_filter($classes));

// Debug: uncomment to see what values are being retrieved
// echo "<!-- Debug: size=$size, shape=$shape, classes=$classString -->";

?>
<?php if ($src): ?>
<figure class="<?= $classString ?>">
    <?php if ($link->isNotEmpty()): ?>
    <a href="<?= esc($link, 'attr') ?>">
        <img src="<?= esc($src, 'attr') ?>" alt="<?= esc($alt, 'attr') ?>">
    </a>
    <?php else: ?>
    <img src="<?= esc($src, 'attr') ?>" alt="<?= esc($alt, 'attr') ?>">
    <?php endif ?>

    <?php if ($caption->isNotEmpty()): ?>
    <figcaption class="img-caption">
        <?= $caption ?>
    </figcaption>
    <?php endif ?>
</figure>
<?php endif ?>
