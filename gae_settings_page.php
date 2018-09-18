<div class="<?= gae_PLUGIN_DIRECTORY ?>">
  <?php Gae_Admin::generate_combined(); ?>
  <?php $sections = Gae_Admin::get_sections(); ?>
  <h1><?php _e('Google analytics settings',gae_PUGIN_NAME); ?> - <?php print gae_PUGIN_NAME ." ". gae_CURRENT_VERSION; ?></h1>
  <?php Gae_Admin::print_all_messages(); ?>
  <p>To setup goals for you website, you need to have collect events on the page. This plugin sets some basic events, that should be collected. Bellow there is several sections that can be enabled or disabled seperatly.</p>




  <?php if (Gae_Admin::show_donation_block()) : ?>
  <?php include(gae_INCLUDES_PATH."/donation.php"); ?>
  <?php endif; ?>

  <form method="post" action="" autocomplete="off">
    <?php settings_fields( 'gae-settings-group' ); ?>
    <?php foreach($sections as $section): ?>
        <section id="<?= $section["id"] ?>" class="<?= gae_PLUGIN_DIRECTORY ?>-section">

            <h2 id="section-<?= $section["id"] ?>"><?= $section["title"]; ?></h2>
            <p class="<?= gae_PLUGIN_DIRECTORY ?>-description">
                <?= $section["description"]; ?>

            </p>
            <?php if (!empty($section["example"])): ?>
            
              <code class="<?= gae_PLUGIN_DIRECTORY ?>-code">
                
                  <?= htmlentities($section["example"]); ?>
                
              </code>
            
            <?php endif; ?>

            <ul id="section-<?= $section["id"] ?>-content" class="<?= gae_PLUGIN_DIRECTORY ?>-content">
              <?php foreach($section["fields"] as $field): ?>
                <?php $title=$field["title"] ?>
                <?php $id=$field["id"] ?>
                <?php $value=$field["value"] ?>
                <?php $default_value=$field["default_value"] ?>
                <?php $placeholder= !empty($field["placeholder"]) ? $field["placeholder"] : "" ?>
                <?php $options= !empty($field["options"]) ? $field["options"] : [] ?>
                <?php $description= !empty($field["description"]) ? $field["description"] : "" ?>
                <?php if ($id==="gea-debug-ip"){
                    $description.="<br/>You current ip address is: ".$_SERVER["REMOTE_ADDR"];
                }
                ?>
                <li><?php require(gae_INCLUDES_PATH."/fields/".$field["type"].".php"); ?></li>
              <?php endforeach; ?>
            </ul>

        </section>
    <?php endforeach; ?>
    <section class="submit">
      <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </section>
  </form>
</div>
