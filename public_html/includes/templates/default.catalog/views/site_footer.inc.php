<hr style="clear: both;" />

<footer id="footer">
  <div class="col-md-12">
    <div class="row">
      <div class="account col-xs-6 col-sm-4 col-md-2">
        <h4><?php echo language::translate('title_account', 'Account'); ?></h4>
        <ul class="list-unstyled">
          <li><a href="<?php echo document::href_ilink('regional_settings'); ?>"><?php echo language::translate('title_regional_settings', 'Regional Settings'); ?></a></li>
          <li><a href="<?php echo document::ilink('customer_service'); ?>"><?php echo language::translate('title_customer_service', 'Customer Service'); ?></a></li>
          <?php if (!empty(customer::$data['id'])) { ?>
          <li><a href="<?php echo document::href_ilink('order_history'); ?>"><?php echo language::translate('title_order_history', 'Order History'); ?></a></li>
          <li><a href="<?php echo document::href_ilink('edit_account'); ?>"><?php echo language::translate('title_edit_account', 'Edit Account'); ?></a></li>
          <li><a href="<?php echo document::href_ilink('logout'); ?>"><?php echo language::translate('title_logout', 'Logout'); ?></a></li>
          <?php } else { ?>
          <li><a href="<?php echo document::href_ilink('create_account'); ?>"><?php echo language::translate('title_create_account', 'Create Account'); ?></a></li>
          <li><a href="<?php echo document::href_ilink('login'); ?>"><?php echo language::translate('title_sign_in', 'Sign In'); ?></a></li>
          <?php } ?>
        </ul>
      </div>

      <div class="information col-xs-6 col-sm-4 col-md-2">
        <h4><?php echo language::translate('title_information', 'Information'); ?></h4>
        <ul class="list-unstyled">
          <?php foreach ($pages as $page) echo '<li><a href="'. htmlspecialchars($page['link']) .'">'. $page['title'] .'</a></li>' . PHP_EOL; ?>
        </ul>
      </div>

        <div class="contact hidden-xs hidden-sm col-md-5">
          <h4><?php echo language::translate('title_about_us', 'About Us'); ?></h4>
          <p>Lorem ipsum dolor sit amet, populo propriae mei no. Vix tale nonumy id, quis eruditi alienum has at, eu quo utinam possit. Omnis blandit rationibus mel ut, at sit homero ornatus, his choro affert accusam an. Eum ad dolore ignota tractatos. Probo nobis vix at, nam no audiam imperdiet, ius facete singulis accommodare id. No quis meliore disputationi has, in exerci ocurreret mel, mea purto congue id.</p>

          <div class="social-bookmarks" style="margin: 1em 0;">
            <a class="twitter" href="<?php echo document::href_link('http://twitter.com/home/', array('status' => document::link(''))); ?>" target="_blank" title="<?php echo sprintf(language::translate('text_share_on_s', 'Share on %s'), 'Twitter'); ?>"><?php echo functions::draw_fonticon('fa-twitter-square fa-2x', 'style="color: #55acee;"'); ?></a>
            <a class="facebook" href="<?php echo document::href_link('http://www.facebook.com/sharer.php', array('u' => document::link(''))); ?>" target="_blank" title="<?php echo sprintf(language::translate('text_share_on_s', 'Share on %s'), 'Facebook'); ?>"><?php echo functions::draw_fonticon('fa-facebook-square fa-2x', 'style="color: #3b5998;"'); ?></a>
            <a class="googleplus" href="<?php echo document::href_link('https://plus.google.com/share', array('url' => document::link(''))); ?>" target="_blank" title="<?php echo sprintf(language::translate('text_share_on_s', 'Share on %s'), 'Google+'); ?>"><?php echo functions::draw_fonticon('fa-google-plus-square fa-2x', 'style="color: #dd4b39;"'); ?></a>
            <a class="pinterest" href="<?php echo document::href_link('http://pinterest.com/pin/create/button/', array('url' => document::link(''))); ?>" target="_blank" title="<?php echo sprintf(language::translate('text_share_on_s', 'Share on %s'), 'Pinterest'); ?>"><?php echo functions::draw_fonticon('fa-pinterest-square fa-2x', 'style="color: #bd081c;"'); ?></a>
          </div>
        </div>

        <div class="contact col-xs-6 col-sm-4 col-md-3">
          <h4><?php echo language::translate('title_contact', 'Contact'); ?></h4>
          <p><?php echo nl2br(settings::get('store_postal_address')); ?></p><br />
          <p><?php echo functions::draw_fonticon('fa-phone'); ?> <a href="tel://<?php echo settings::get('store_phone'); ?>"><?php echo settings::get('store_phone'); ?></a><br />
            <?php echo functions::draw_fonticon('fa-envelope'); ?> <?php list($account, $domain) = explode('@', settings::get('store_email')); echo "<script>document.write('<a href=\"mailto:". $account ."' + '@' + '". $domain ."\">". $account ."' + '@' + '". $domain ."</a>');</script>"; ?></p>
        </div>
    </div>
  </div>

  <!-- LiteCart is licensed under CC BY-ND 4.0. Removing the link back to LiteCart.net without written permission is a violation. -->
  <p class="text-center">Copyright &copy; <?php echo date('Y'); ?> <?php echo settings::get('store_name'); ?> &middot; Powered by <a href="http://www.litecart.net" target="_blank">LiteCart</a><sup>®</sup></p>
</footer>