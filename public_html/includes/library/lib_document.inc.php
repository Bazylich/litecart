<?php

  class document {

    public static $template = '';
    public static $layout = 'default';
    public static $snippets = array();
    public static $settings = array();

    public static function construct() {
      header('X-Powered-By: '. PLATFORM_NAME);
    }

    //public static function load_dependencies() {
    //}

    //public static function initiate() {
    //}

    //public static function startup() {
    //}


    public static function before_capture() {

    // Set template
      if (preg_match('#^('. preg_quote(WS_DIR_ADMIN, '#') .')#', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
        self::$template = settings::get('store_template_admin');
      } else {
        self::$template = settings::get('store_template_catalog');
      }

      define('WS_DIR_TEMPLATE', WS_DIR_TEMPLATES . self::$template .'/');

    // Set before-snippets
      self::$snippets['language'] = language::$selected['code'];
      self::$snippets['charset'] = language::$selected['charset'];
      self::$snippets['home_path'] = WS_DIR_HTTP_HOME;
      self::$snippets['template_path'] = WS_DIR_TEMPLATES . self::$template .'/';

      self::$snippets['title'] = array(settings::get('store_name'));

      self::$snippets['head_tags']['favicon'] = '<link rel="shortcut icon" href="'. WS_DIR_HTTP_HOME .'favicon.ico">';

    // Older browsers (mainly Internet IE)
      self::$snippets['head_tags']['X-UA-Compatible'] = '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">';
      self::$snippets['head_tags']['html5shiv'] = '<!--[if lt IE 9]><script src="//cdn.jsdelivr.net/g/html5shiv"></script><![endif]-->';
      self::$snippets['head_tags']['respond'] = '<!--[if lt IE 9]><script src="//cdn.jsdelivr.net/g/respond"></script><![endif]-->';

    // CDN content
      self::$snippets['head_tags']['fontawesome'] = '<link rel="stylesheet" href="//cdn.jsdelivr.net/fontawesome/latest/css/font-awesome.min.css" />';
      //self::$snippets['foot_tags']['jquery'] = '<script src="//cdn.jsdelivr.net/g/jquery@3.1.1"></script>';
      //self::$snippets['foot_tags']['bootstrap'] = '<script src="//cdn.jsdelivr.net/g/bootstrap@3.3.7"></script>';
      //self::$snippets['foot_tags']['jquery+bootstrap'] = '<script src="//cdn.jsdelivr.net/g/jquery@3.1.1,bootstrap@3.3.7"></script>';

    // Local content
      self::$snippets['head_tags']['fontawesome'] = '<link rel="stylesheet" href="'. WS_DIR_EXT .'fontawesome/css/font-awesome.min.css" />';
      self::$snippets['foot_tags']['jquery'] = '<script src="'. WS_DIR_EXT .'jquery/jquery-3.1.1.min.js"></script>';
      self::$snippets['foot_tags']['bootstrap'] = '<script src="'. WS_DIR_EXT .'bootstrap/bootstrap-3.3.7.min.js"></script>';

    // Hreflang
      if (!empty(route::$route['page']) && settings::get('seo_links_language_prefix')) {
        self::$snippets['head_tags']['hreflang'] = '';
        foreach (array_keys(language::$languages) as $language_code) {
          if ($language_code == language::$selected['code']) continue;
          self::$snippets['head_tags']['hreflang'] .= '<link rel="alternate" hreflang="'. $language_code .'" href="'. document::href_ilink(route::$route['page'], array(), true, array(), $language_code) .'" />' . PHP_EOL;
        }
        self::$snippets['head_tags']['hreflang'] = trim(self::$snippets['head_tags']['hreflang']);
      }

    // Get template settings
      self::$settings = unserialize(settings::get('store_template_catalog_settings'));
      
    // LiteCart JavaScript Environment
      $config = array(
        'platform' => array(
          'url' => document::ilink(''),
        ),
        'template' => array(
          'url' => document::link(WS_DIR_TEMPLATE),
          'settings' => self::$settings,
        ),
      );
      self::$snippets['head_tags'][] = "<script>var config = ". json_encode($config, null) .";</script>";
    }

    //public static function after_capture() {
    //}

    public static function prepare_output() {

    // Prepare title
      if (!empty(self::$snippets['title'])) {
        if (!is_array(self::$snippets['title'])) self::$snippets['title'] = array(self::$snippets['title']);
        self::$snippets['title'] = array_filter(self::$snippets['title']);
        self::$snippets['title'] = implode(' | ', array_reverse(self::$snippets['title']));
      }

    // Prepare styles
      if (!empty(self::$snippets['style'])) {
        self::$snippets['style'] = '<style>' . PHP_EOL
                                 . implode(PHP_EOL . PHP_EOL, self::$snippets['style']) . PHP_EOL
                                 . '</style>' . PHP_EOL;
      }

    // Prepare javascript
      if (!empty(self::$snippets['javascript'])) {
        self::$snippets['javascript'] = '<script>' . PHP_EOL
                                      . implode(PHP_EOL . PHP_EOL, self::$snippets['javascript']) . PHP_EOL
                                      . '</script>' . PHP_EOL;
      }

    // Prepare snippets
      foreach (array_keys(self::$snippets) as $snippet) {
        if (is_array(self::$snippets[$snippet])) self::$snippets[$snippet] = implode(PHP_EOL, self::$snippets[$snippet]);
      }
    }

    public static function before_output() {
      
      if (!function_exists('replace_first_occurrence')) {
        function replace_first_occurrence($search, $replace, $subject) {
          if (strlen($search) > 4096) {
            return preg_replace('#'. preg_quote(substr($search, 0, 1024), '#') .'.*?'. preg_quote(substr($search, -1024), '#') .'#s', $replace, $subject, 1);
          } else {
            return preg_replace('#'. preg_quote($search, '#') .'#', $replace, $subject, 1);
          }
        }
      }
      
    // Extract and group in content stylesheets
      if (preg_match('#^.*<html(?:[^>]+)?>(.*)</html>.*$#is', $GLOBALS['output'], $matches)) {
        $content = $matches[1];

        $stylesheets = array();
        if (preg_match_all('#(<link\s(?:[^>]*rel="stylesheet")[^>]*>)\R?#is', $content, $matches, PREG_SET_ORDER)) {
          foreach ($matches as $match) {
            if ($GLOBALS['output'] = replace_first_occurrence($match[0], '', $GLOBALS['output'], 1)) {
              $stylesheets[] = trim($match[1]);
            }
          }
          
        if (!empty($stylesheets)) {
            $stylesheets = implode(PHP_EOL, $stylesheets) . PHP_EOL;
            
            $GLOBALS['output'] = preg_replace('#</head>#', $stylesheets . '</head>', $GLOBALS['output'], 1);
          }
        }
      }

    // Extract and group in content styling
      if (preg_match('#^.*<html(?:[^>]+)?>(.*)</html>.*$#is', $GLOBALS['output'], $matches)) {
        $content = $matches[1];

        $styles = array();
        if (preg_match_all('#<style>(.*?)</style>\R?#is', $content, $matches, PREG_SET_ORDER)) {
          foreach ($matches as $match) {
            if ($GLOBALS['output'] = replace_first_occurrence($match[0], '', $GLOBALS['output'], 1)) {
              $styles[] = trim($match[1]);
            }
          }

          if (!empty($styles)) {
            $styles = '<style>' . PHP_EOL
                   . '<!--/*--><![CDATA[/*><!--*/' . PHP_EOL
                   . implode(PHP_EOL . PHP_EOL, $styles) . PHP_EOL
                   . '/*]]>*/-->' . PHP_EOL
                   . '</style>' . PHP_EOL;

            $GLOBALS['output'] = preg_replace('#</head>#', $styles . '</head>', $GLOBALS['output'], 1);
          }
        }
      }

    // Extract and group javascript resources
      if (preg_match('#^.*<body(?:[^>]+)?>(.*)</body>.*$#is', $GLOBALS['output'], $matches)) {
        $content = $matches[1];

        $js_resources = array();
        if (preg_match_all('#\R?(<script[^>]+></script>)\R?#is', $content, $matches, PREG_SET_ORDER)) {

          foreach ($matches as $match) {
            if ($GLOBALS['output'] = replace_first_occurrence($match[0], '', $GLOBALS['output'], 1)) {
              $js_resources[] = trim($match[1]);
            }
          }
          
          if (!empty($js_resources)) {
            $js_resources = implode(PHP_EOL, $js_resources) . PHP_EOL;

            $GLOBALS['output'] = preg_replace('#</body>#is', $js_resources .'</body>', $GLOBALS['output'], 1);
          }
        }
      }

    // Extract and group inline javascript
      if (preg_match('#^.*<body(?:[^>]+)?>(.*)</body>.*$#is', $GLOBALS['output'], $matches)) {
        $content = $matches[1];

        $javascript = array();
        if (preg_match_all('#<script(?: type="(?:application|text)/javascript")?>(?!</script>)(.*?)</script>\R?#is', $content, $matches, PREG_SET_ORDER)) {

          foreach ($matches as $match) {
            if ($GLOBALS['output'] = replace_first_occurrence($match[0], '', $GLOBALS['output'], 1)) {
              $javascript[] = trim($match[1], "\r\n");
            }
          }

          if (!empty($javascript)) {
            $javascript = '<script>' . PHP_EOL
                        . '<!--/*--><![CDATA[/*><!--*/' . PHP_EOL
                        . '$(document).ready(function(){' . PHP_EOL
                        . implode(PHP_EOL . PHP_EOL, $javascript) . PHP_EOL
                        . '});' . PHP_EOL
                        . '/*]]>*/-->' . PHP_EOL
                        . '</script>' . PHP_EOL;

            $GLOBALS['output'] = preg_replace('#</body>#is', $javascript . '</body>', $GLOBALS['output'], 1);
          }
        }
      }

    // Clean orphan snippets
      $search = array(
        '#\{snippet:[^\}]+\}#',
        '#\R?<!--snippet:[^-->]+-->\R?#',
      );

      $GLOBALS['output'] = preg_replace($search, '', $GLOBALS['output']);
    }

    //public static function shutdown() {
    //}

    ######################################################################

    public static function expires($string=false) {
      if (strtotime($string) > time()) {
        header('Pragma:');
        header('Cache-Control: max-age='. (strtotime($string) - time()));
        header('Expires: '. date('r', strtotime($string)));
        self::$snippets['head_tags']['meta_expire'] = '<meta http-equiv="cache-control" content="public">' .PHP_EOL
                                                    . '<meta http-equiv="expires" content="'. date('r', strtotime($string)) .'">';
      } else {
        header('Cache-Control: no-cache');
        self::$snippets['head_tags']['meta_expire'] = '<meta http-equiv="cache-control" content="no-cache">' . PHP_EOL
                                                    . '<meta http-equiv="expires" content="'. date('r', strtotime($string)) .'">';
      }
    }

    public static function ilink($route=null, $new_params=array(), $inherit_params=null, $skip_params=array(), $language_code=null) {

      if ($route === null) {
        $route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if ($inherit_params === null) $inherit_params = true;
      } else {
        $route = WS_DIR_HTTP_HOME . $route;
      }

      return link::create_link($route, $new_params, $inherit_params, $skip_params, $language_code);
    }

    public static function href_ilink($route=null, $new_params=array(), $inherit_params=null, $skip_params=array(), $language_code=null) {
      return htmlspecialchars(self::ilink($route, $new_params, $inherit_params, $skip_params, $language_code));
    }

    public static function link($document=null, $new_params=array(), $inherit_params=null, $skip_params=array(), $language_code=null) {
      return link::create_link($document, $new_params, $inherit_params, $skip_params, $language_code);
    }

    public static function href_link($document=null, $new_params=array(), $inherit_params=null, $skip_params=array(), $language_code=null) {
      return htmlspecialchars(self::link($document, $new_params, $inherit_params, $skip_params, $language_code));
    }
  }

?>