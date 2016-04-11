<div class="twelve-eighty">
  <!--snippet:notices-->
  
  <div id="sidebar">
    <div class="well">
      <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_search.inc.php'); ?>
      <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_category_tree.inc.php'); ?>
      <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_recently_viewed_products.inc.php'); ?>
    </div>
  </div>
  
  <div id="main">
   
    <div id="index">
      
      <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_slider.inc.php'); ?>
      
      <div>
        <ul class="nav nav-tabs nav-justified">
          <li class="active"><a href="#latest-products" data-toggle="tab"><?php echo language::translate('title_latest_products', 'Latest Products'); ?></a></li>
          <li><a href="#campaign-products" data-toggle="tab"><?php echo language::translate('title_campaign_products', 'Campaign Products'); ?></a></li>
          <li><a href="#popular-products" data-toggle="tab"><?php echo language::translate('title_popular_products', 'Popular Products'); ?></a></li>
        </ul>

        <div class="tab-content">
          <div class="tab-pane fade in active" id="latest-products">
            <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_latest_products.inc.php'); ?>
          </div>
          
          <div class="tab-pane fade in" id="campaign-products">
            <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_most_popular_products.inc.php'); ?>
          </div>
          
          <div class="tab-pane fade in" id="popular-products">
            <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_campaign_products.inc.php'); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <hr />
  
  <div class="text-center">
    <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_manufacturer_logotypes.inc.php'); ?>
  </div>
</div>