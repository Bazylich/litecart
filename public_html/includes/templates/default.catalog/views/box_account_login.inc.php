<div id="box-account-login" class="box">
  <div class="heading"><h3><?php echo language::translate('title_login', 'Login'); ?></h3></div>
  <div class="content">
    <?php echo functions::form_draw_form_begin('login_form', 'post', document::ilink('login')); ?>
    <?php echo functions::form_draw_hidden_field('redirect_url', !empty($_GET['redirect_url']) ? $_GET['redirect_url'] : document::ilink('')); ?>
      <table>
        <tr>
          <td><?php echo language::translate('title_email_address', 'E-mail Address'); ?><br />
            <?php echo functions::form_draw_text_field('email', true, 'required="required"'); ?></td>
        </tr>
        <tr>
          <td><?php echo language::translate('title_password', 'Password'); ?><br />
          <?php echo functions::form_draw_password_field('password', '', 'required="required"'); ?></td>
        </tr>
        <tr>
          <td><label><?php echo functions::form_draw_checkbox('remember_me', '1', true); ?> <?php echo language::translate('title_remember_me', 'Remember Me'); ?></label></td>
	    </tr>
        <tr>
          <td><span class="button-set"><?php echo functions::form_draw_button('login', language::translate('title_login', 'Login')); ?><?php echo functions::form_draw_button('lost_password', language::translate('title_lost_password', 'Lost Password')); ?></span></td>
        </tr>
        <tr>
          <td><a href="<?php echo document::href_ilink('create_account'); ?>"><?php echo language::translate('text_new_customers_click_here', 'New customers click here'); ?></a></td>
        </tr>
    </table>
    <?php echo functions::form_draw_form_end(); ?>
  </div>
</div>