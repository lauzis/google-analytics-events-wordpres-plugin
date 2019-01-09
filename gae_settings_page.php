<div class="<?= gae_PLUGIN_DIRECTORY_NAME ?>">

    <?php Gae_Admin::settings_page_visited(); ?>
    <?php Gae_Admin::generate_combined(); ?>
    <?php $sections = Gae_Admin::get_sections(); ?>
    <h1><?= Gae_Admin::get_translation('Google analytics settings'); ?>
        - <?php print gae_PUGIN_NAME . " " . gae_CURRENT_VERSION; ?></h1>
    <?php Gae_Admin::print_all_messages(); ?>
    <p>
        <?= Gae_Admin::get_translation('Google analytics events are addtional collected data that "hapens" on your website. Ussually and mostly events ar trigered by some user action - click, scroll, form submition.<br/>
        In Google analytics itself events can be used to to setup goals for you website. Events can be added to webpage elements via google tag
            manager, or hardcoded in the page.<br/>
        This plugin sets some basic events, that should be collected on most websites, and plugin allows to add some custom events, for your
        custome elements.<br/>
        There are several sections below, that can be enabled or disabled separately.<br/>
        More about event and event tracking read <a href="%s"
                                                    target="_blank">%s</a>',['https://wpflow.com/what-is-google-analytics-event-tracking/',"here"]); ?>
    </p>

    <?php if (Gae_Admin::show_donation_block()) : ?>
        <?php include(gae_INCLUDES_PATH . "/donation.php"); ?>
    <?php endif; ?>

    <?php
        $enabled_values = [
            1,
            "tag-manager",
            "analytics",
            "enable-php-log",
            "enable-console-log",
            "enable-show-on-front"
        ];

        $disabled_values = [
            0,
            "added-tag-manager",
            "added-tag-analytics",
            "added-idk",
            "disabled"
        ]

    ?>

    <form method="post" action="" class="<?= gae_PLUGIN_DIRECTORY_NAME ?>" autocomplete="off">
        <?php settings_fields('gae-settings-group'); ?>
        <?php $count_of_sections = count($sections); ?>
        <?php $counter=0; ?>

        <?php foreach ($sections as $section): ?>
            <?php $counter++; ?>
            <?php $enabled=""; ?>

            <?php
                if ($counter===$count_of_sections){
                    $last=" ".gae_PLUGIN_DIRECTORY_NAME."-section-last";
                } else {
                    $last="";
                }
            ?>

            <?php foreach($section["fields"] as $field){
                if (in_array($field["value"],$enabled_values) && ($field["type"]=="switch" || $field["type"]=="select")){
                    $enabled=" section-enabled";
                    $onOff="true";
                    break;
                } elseif (in_array($field["value"],$disabled_values) && ($field["type"]=="switch" || $field["type"]=="select")) {
                    $enabled=" section-disabled";
                    $onOff="false";
                }

            } ?>

            <div id="<?= $section["id"] ?>" class="postbox-container <?= gae_PLUGIN_DIRECTORY_NAME ?>-section<?= $enabled ?><?= $last ?>">

                <div class="meta-box-sortables closed">
                    <div id="<?= $section["id"] ?>-" class="postbox <?= $section["id"] ?> ">

                        <button type="button" class="handlediv section-title" aria-expanded="false">
                            <span class="screen-reader-text">Toggle panel: <?= Gae_Admin::get_translation($section["title"]); ?></span>
                            <span class="toggle-indicator" aria-hidden="true"></span>
                        </button>

                        <h2 id="section-<?= $section["id"] ?>" class="hndle section-title">
                            <span>
                                <?= Gae_Admin::get_translation($section["title"]); ?>
                            </span>
                        </h2>

                        <div class="inside">

                            <p class="<?= gae_PLUGIN_DIRECTORY ?>-description">
                                <?= Gae_Admin::get_translation($section["description"]); ?>
                            </p>

                            <?php if (!empty($section["example"])): ?>
                                <code class="<?= gae_PLUGIN_DIRECTORY ?>-code">
                                    <?= htmlentities(Gae_Admin::get_translation($section["example"])); ?>
                                </code>
                            <?php endif; ?>

                            <ul id="section-<?= $section["id"] ?>-content" class="<?= gae_PLUGIN_DIRECTORY_NAME ?>-content">
                                <?php foreach ($section["fields"] as $field): ?>
                                    <?php $title = Gae_Admin::get_translation($field["title"]) ?>
                                    <?php $id = $field["id"] ?>
                                    <?php $value = $field["value"] ?>
                                    <?php $default_value = $field["default_value"] ?>
                                    <?php $placeholder = !empty($field["placeholder"]) ? Gae_Admin::get_translation($field["placeholder"]) : "" ?>
                                    <?php $options = !empty($field["options"]) ? $field["options"] : [] ?>
                                    <?php $description = !empty($field["description"]) ? Gae_Admin::get_translation($field["description"]) : "" ?>
                                    <?php if ($id === "gea-debug-ip") {
                                        $description .= Gae_Admin::get_translation("<br/>You current ip address is: ") . $_SERVER["REMOTE_ADDR"];
                                    }
                                    ?>
                                    <li><?php require(gae_INCLUDES_PATH . "/fields/" . $field["type"] . ".php"); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                    </div>
                </div>

            </div>
        <?php endforeach; ?>
        <section class="<?= gae_PLUGIN_DIRECTORY_NAME ?>-submit">
            <input type="submit" class="button-primary" value="<?= Gae_Admin::get_translation('Save Changes') ?>"/>
            <?php if (gae_DEVELOPER): ?>
                <a href="<?= Gae_Admin::get_settings_page_url() ?>&generate-pot-file" class="button-secondary"><?= Gae_Admin::get_translation('Generate Translation Template') ?></a>
            <?php endif ?>
        </section>

    </form>

</div>