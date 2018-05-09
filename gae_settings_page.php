<?php

$sections = [
  [
    "id"=>"analytics-scirpt",
    "title"=>"Analytics scirpt",
    "description"=>"Anding analytics code to the header, if you have already analytics code in the page leave this value to 'Analytcs code already added' ",
    "fields"=> [
      [
        "id"=>"script_type",
        "type"=>"select",
        "options"=>[
          [
            "value"=>"0",
            "title"=>"Analytcs code already added"
          ],
          [
            "value"=>"tag-manager",
            "title"=>"Tag manager style code (recomended)"
          ],
          [
            "value"=>"analytics",
            "title"=>"Clasig code"
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
              <li><?php include(gae_PLUGIN_DIRECTORY."fields/".$field["type"]); ?></li>
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
  