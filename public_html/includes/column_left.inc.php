<?php ob_start(); // Begin capture column left ?>
<aside class="shadow rounded-corners">
  <?php include(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'search.inc.php'); ?>
  <?php include(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'category_tree.inc.php'); ?>
  <?php include(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'manufacturers.inc.php'); ?>
</aside>
<?php document::$snippets['column_left'] = ob_get_clean(); // End capture ?>