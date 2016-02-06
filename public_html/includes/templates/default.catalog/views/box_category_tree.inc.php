<div id="category-tree" class="box">
  <h3><?php echo language::translate('title_categories', 'Categories'); ?></h3>
<?php
  if (!function_exists('custom_draw_category_tree')) {
    function custom_draw_category_tree($categories, $indent=0) {
      echo '<ul class="">' . PHP_EOL;
      foreach ($categories as $category) {
        echo '  <li class="category-'. $category['id'] . (!empty($category['active']) ? ' active' : '') .'">'. functions::draw_fonticon(!empty($category['opened']) ? 'fa-minus-square' : 'fa-plus-square', 'style="font-size: 0.9em;"') .' <a href="'. htmlspecialchars($category['link']) .'">'. $category['name'] .'</a>';
        if (!empty($category['subcategories'])) {
          echo PHP_EOL . custom_draw_category_tree($category['subcategories'], $indent+1);
        }
        echo '  </li>' . PHP_EOL;
      }
      echo '</ul>' . PHP_EOL;
    }
  }
  custom_draw_category_tree($categories);
?>
</div>