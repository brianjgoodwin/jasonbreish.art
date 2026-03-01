<?php
/** @var \Kirby\Cms\Block $block */
$color  = $block->color()->or('#e0e0e0');
$height = $block->height()->or('medium');

// Height mapping
$heightMap = [
  'small'  => '2rem',
  'medium' => '4rem',
  'large'  => '8rem',
  'xlarge' => '12rem'
];

$heightValue = $heightMap[$height] ?? '4rem';
?>
<div
  class="color-bar"
  style="background-color: <?= esc($color, 'css') ?>; height: <?= esc($heightValue, 'css') ?>;"
  role="presentation"
  aria-hidden="true"
></div>
