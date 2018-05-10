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
        "default_value"=>"0",
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
      ],
      [
        "id"=>"script_analytics_id",
        "title"=>"Google analytics id",
        "type"=>"text",
        "value"=>"",
        "placeholder"=>"UA-XXX-X",
        "default_value"=>"",
      ]
    ],
  ],
  [
    "id"=>"time-trigger",
    "title"=>"Time trigger (bounce rate)",
    "description"=>"By default in google analytics if page is visited and then browser closed,
    or user navigates to different/other website, the visit would count as a bounced.
    Cause there was no event, after the visit. So in some cases its usuful to send time triggered
    event that user would not count as a bounced. For examle if user is on site 30sek,
    probabbly he is reading content, so this user should not count as bounced even if he went away afterwards.",
    "fields"=> [
      [
        "id"=>"time_trigger_on",
        "title"=>"Enable time trigger",
        "type"=>"select",
        "value"=>"",
        "placeholder"=>"",
        "default_value"=>"1",
        "options"=>[
          [
            "value"=>"1",
            "title"=>"Enable"
          ],
          [
            "value"=>"0",
            "title"=>"Disable"
          ],
        ]
      ],
      [
        "id"=>"time_trigger_treshold",
        "title"=>"Time trigger treshold (seconds)",
        "type"=>"text",
        "value"=>"",
        "placeholder"=>"30",
        "default_value"=>"30",
      ]

    ]
  ],
  [
    "id"=>"contact-links",
    "title"=>"Contact Links",
    "description"=>"Enable this if you want to see how often contact links are clicked on your website. This will track links containing email, phone number.",
    "fields"=> [
      [
        "id"=>"contact_links_on",
        "title"=>"Enable contact link tracking",
        "type"=>"select",
        "value"=>"",
        "placeholder"=>"",
        "default_value"=>"1",
        "options"=>[
          [
            "value"=>"1",
            "title"=>"Enable"
          ],
          [
            "value"=>"0",
            "title"=>"Disable"
          ],
        ]
      ],
    ],
  ],
  [
    "id"=>"form-tracking",
    "title"=>"Forms tracking",
    "description"=>"Enable this if you want to see when someone tries to submit some form. If you have some forms in your website, this will help you track if users actually are using your forms.
    Sometimes it helps also to find some bugs with forms, you see that users ar trying to send form, but you dont have any antires. Maybe there is some problem with forms.",
    "fields"=> [
      [
        "id"=>"form_tracking_submition_on",
        "title"=>"Enable form submition tracking",
        "type"=>"select",
        "value"=>"",
        "placeholder"=>"",
        "default_value"=>"1",
        "options"=>[
          [
            "value"=>"1",
            "title"=>"Enable"
          ],
          [
            "value"=>"0",
            "title"=>"Disable"
          ],
        ]
      ],
      [
        "id"=>"form_tracking_starts_to_fill_fields_on",
        "title"=>"Enable form fields tracking",
        "type"=>"select",
        "value"=>"",
        "placeholder"=>"",
        "default_value"=>"0",
        "options"=>[
          [
            "value"=>"1",
            "title"=>"Enable"
          ],
          [
            "value"=>"0",
            "title"=>"Disable"
          ],
        ]
      ],
    ],
  ],
  [
    "id"=>"file-downloads",
    "title"=>"File downloads",
    "description"=>"Enable this if you want to see how often files that are linked in content are opened/downloaded.",
    "fields"=> [
      //todo allow user to specify the extensions
      [
        "id"=>"file_donwloads_on",
        "title"=>"Enable file click tracking",
        "type"=>"select",
        "value"=>"",
        "placeholder"=>"",
        "default_value"=>"1",
        "options"=>[
          [
            "value"=>"1",
            "title"=>"Enable"
          ],
          [
            "value"=>"0",
            "title"=>"Disable"
          ],
        ]
      ],
    ],
  ],
  ["title"=>"Cta buttons"],
  [
    "id"=>"outgoing-links",
    "title"=>"Outgoing Links",
    "description"=>"Enable this if you want to see how often outgoing links are clicked.
    This will track when users are leaving your site via autgoing links in content. This sometimes also helps to track some links that could be by mistake.",
    "fields"=> [
      [
        "id"=>"outgoing_links_on",
        "title"=>"Enable outgoing link tracking",
        "type"=>"select",
        "value"=>"",
        "placeholder"=>"",
        "default_value"=>"1",
        "options"=>[
          [
            "value"=>"1",
            "title"=>"Enable"
          ],
          [
            "value"=>"0",
            "title"=>"Disable"
          ],
        ]
      ],
    ],
  ],
  ["title"=>"Debug"],
];
?>
<h1><?php _e('Google analytics settings',gae_PUGIN_NAME); ?> - <?php print gae_PUGIN_NAME ." ". gae_CURRENT_VERSION. "<sub>(Build ".gae_CURRENT_BUILD.")</sub>"; ?></h1>


<form method="post" action="options.php" autocomplete="off">
  <?php settings_fields( 'gae-settings-group' ); ?>
  <?php foreach($sections as $section): ?>
      <section id="<?= $section["id"] ?>">

          <h2 id="section-<?= $section["id"] ?>"><?= $section["title"]; ?></h2>
          <p>
              <?= $section["description"]; ?>
          </p>
          <ul id="section-<?= $section["id"] ?>-content">
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
      <table class="form-table">        <tr valign="top">        <th scope="row">New Option Name</th>        <td><input type="text" name="new_option_name" value="<?php echo get_option('new_option_name'); ?>" /></td>        </tr>                 <tr valign="top">        <th scope="row">Some Other Option</th>        <td><input type="text" name="some_other_option" value="<?php echo get_option('some_other_option'); ?>" /></td>        </tr>                <tr valign="top">        <th scope="row">Options, Etc.</th>        <td><input type="text" name="option_etc" value="<?php echo get_option('option_etc'); ?>" /></td>        </tr>    </table>
