<?php
/**
 * Created by PhpStorm.
 * User: lauzis
 * Date: 18.5.6
 * Time: 18:35
 */

class Gae_Frontend {

    public static function add_scripts(){

        wp_enqueue_script('gae-ga', gae_GENERATE_URL, array('jquery'));

        if (!is_admin() && gae_is_debug()){
          wp_enqueue_style('gae-css', gae_PLUGIN_URL.'/css/gae-debug.css');
          wp_enqueue_script('gae-debug', gae_PLUGIN_URL.'/js/gae-debug.js', array('jquery'));
        }

    }


  function add_inline_script()
  {
    $ga_id = get_option("gae-script-analytics-id");
    $ga_type = get_option("gae-script-type");
    if (!empty($ga_id) && $ga_type!==0) {
      switch($ga_type){

        case "tag-manager":
          ?>
          <!-- Google Tag Manager -->
          <script>


              (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                      new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
              })(window,document,'script','dataLayer','<?php echo $ga_id; ?>');

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
        alert("but works <?php echo $ga_id ?>  <?php echo $ga_type ?>");
    </script>
    <?php
  }

}