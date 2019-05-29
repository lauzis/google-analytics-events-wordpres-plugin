<?php
/**
 * Created by PhpStorm.
 * User: lauzis
 * Date: 18.5.6
 * Time: 18:35
 */

class Gae_Frontend {

    public static function add_scripts(){

        wp_enqueue_script('gae-ga', gae_GENERATE_FILE_URL, array('jquery'),gae_CURRENT_VERSION."-".get_option('gae-assets-version'));

        if (!is_admin() && Gae_Admin::debug() && Gae_Admin::debug() > 2){
          wp_enqueue_style('gae-css', gae_CSS_URL.'/gae-debug.css',array(), gae_CURRENT_VERSION."-".get_option('gae-assets-version'));
          wp_enqueue_script('gae-debug', gae_JS_URL.'/gae-debug.js', array('jquery'),gae_CURRENT_VERSION."-".get_option('gae-assets-version'),true);
        }
    }


  public static function add_inline_scripts()
  {
    $ga_id = get_option("gae-script-analytics-id");
    $ga_type = get_option("gae-script-type");

    if (Gae_Admin::debug()>0){
      $ga_id_debug = get_option("gae-script-analytics-id-debug");
      if (!empty($ga_id_debug)){
        $ga_id = $ga_id_debug;
      }
    }


    if (!empty($ga_id) && $ga_type!==0) {
      switch($ga_type){

        case "tag-manager":
          ?>
          <!-- Google Tag Manager -->
            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=UA-49473552-2"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());

                gtag('config', '<?= $ga_id ?>');
            </script>

            <!-- End Google Tag Manager -->

          <?php
          break;

        case "analytics":
          ?>
          <script>

              (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
              })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

              ga('create', '<?php echo $ga_id; ?>', 'auto');
              ga('send', 'pageview');

          </script>
          <?php
          break;

        default:

          break;
      }
    }
    ?>
    <script>

        <?php if (Gae_Admin::debug()>0): ?>
            var GAE_DEBUG_LEVEL = '<?= Gae_Admin::debug() ?>';
        <?php endif; ?>

    </script>
    <?php
  }

}