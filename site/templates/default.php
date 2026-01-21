<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $page->title() ?></title>
  <link rel="stylesheet" href="<?= url('assets/css/style.css') ?>">
</head>
<body>
  <h1><?= $page->title() ?></h1>

  <?= $page->text()->toBlocks() ?>

  <script src="<?= url('assets/js/gallery.js') ?>"></script>
</body>
</html>
