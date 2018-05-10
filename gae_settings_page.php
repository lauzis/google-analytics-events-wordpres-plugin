<?php

$sections = [
  [
    "id"=>"analytics-scirpt",
    "title"=>"Analytics scirpt",
    "description"=>"Anding analytics code to the header, if you have already analytics code in the page leave this value to 'Analytcs code already added' ",
    "fields"=> [
      [
        "id"=>"script_type",
        "title"=>"Embed analytics code",
        "type"=>"select",
        "value"=>"",
        "default_value"=>0,
        "options"=>[
          [
            "value"=>"0",
            "title"=>"Analytcs code already added",
          ],
          [
            "value"=>"tag-manager",
            "title"=>"Tag manager style code (recomended)"
          ],
          [
            "value"=>"analytics",
            "title"=>"Classic Google analytics code"
          ],
        ],
      ]
    ],
  ],
  ["title"=>"Contact Links"],
  ["title"=>"Debug"],
];
?>
<h1><?php _e('Google analytics settings',gae_PUGIN_NAME); ?> - <?php print gae_PUGIN_NAME ." ". gae_CURRENT_VERSION. "<sub>(Build ".gae_CURRENT_BUILD.")</sub>"; ?></h1>


<form method="post" action="options.php">
  <?php settings_fields( 'gae-settings-group' ); ?>
  <?php
  foreach($sections as $section) {
      ?>
      <section>
          <h2><?= $section["title"]; ?></h2>
          <p>
              <?= $section["description"]; ?>
          </p>
          <ul>
            <?php foreach($section["fields"] as $field): ?>
              <?php $title=$field["title"] ?>
              <?php $id=$field["id"] ?>
              <?php $value=$field["value"] ?>
              <?php $default_value=$field["default_value"] ?>
              <?php $options=$field["options"] ?>
              <li><?php require(gae_PLUGIN_PATH."/fields/".$field["type"].".php"); ?></li>
            <?php endforeach; ?>

          </ul>
      </section>
      <?php
  }
  ?>
  <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
  </p>
</forms>
      <table class="form-table">        <tr valign="top">        <th scope="row">New Option Name</th>        <td><input type="text" name="new_option_name" value="<?php echo get_option('new_option_name'); ?>" /></td>        </tr>                 <tr valign="top">        <th scope="row">Some Other Option</th>        <td><input type="text" name="some_other_option" value="<?php echo get_option('some_other_option'); ?>" /></td>        </tr>                <tr valign="top">        <th scope="row">Options, Etc.</th>        <td><input type="text" name="option_etc" value="<?php echo get_option('option_etc'); ?>" /></td>        </tr>    </table>
