<div class="<?= gae_PLUGIN_DIRECTORY ?>">
  <?php gae_generate_combined(); ?>
  <?php
  $sections = gae_get_sections();
  ?>
  <h1><?php _e('Google analytics settings',gae_PUGIN_NAME); ?> - <?php print gae_PUGIN_NAME ." ". gae_CURRENT_VERSION. "<sub>(Build ".gae_CURRENT_BUILD.")</sub>"; ?></h1>


  <form method="post" action="" autocomplete="off">
    <?php settings_fields( 'gae-settings-group' ); ?>
    <?php foreach($sections as $section): ?>
        <section id="<?= $section["id"] ?>" class="<?= gae_PLUGIN_DIRECTORY ?>-section">

            <h2 id="section-<?= $section["id"] ?>"><?= $section["title"]; ?></h2>
            <p class="<?= gae_PLUGIN_DIRECTORY ?>-description">
                <?= $section["description"]; ?>

            </p>
            <?php if ($section["example"]): ?>
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
                <?php $placeholder=$field["placeholder"] ?>
                <?php $options=$field["options"] ?>
                <li><?php require(gae_PLUGIN_PATH."/fields/".$field["type"].".php"); ?></li>
              <?php endforeach; ?>
            </ul>

        </section>
    <?php endforeach; ?>
    <p class="submit">
      <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
  </forms>
</div>
