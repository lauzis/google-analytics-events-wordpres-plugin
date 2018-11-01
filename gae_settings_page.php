<div class="<?= gae_PLUGIN_DIRECTORY_NAME ?>">
    <?php Gae_Admin::settings_page_visited(); ?>
    <?php Gae_Admin::generate_combined(); ?>
    <?php $sections = Gae_Admin::get_sections(); ?>
    <h1><?php _e('Google analytics settings', gae_PUGIN_NAME); ?>
        - <?php print gae_PUGIN_NAME . " " . gae_CURRENT_VERSION; ?></h1>
    <?php Gae_Admin::print_all_messages(); ?>
    <p>
        To setup goals for you website, you have to collect events on the page. Usually events are added via google tag
        manager, or hardcoded in the page.
        This plugin sets some basic events, that should be collected, also possible to add some custom events, for your
        custome elements.
        Bellow there is several sections that can be enabled or disabled separately.
        More about event and event tracking read <a href="https://wpflow.com/what-is-google-analytics-event-tracking/"
                                                    target="_blank">here</a>.
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

    <form method="post" action="" autocomplete="off">
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
                    break;
                } elseif (in_array($field["value"],$disabled_values) && ($field["type"]=="switch" || $field["type"]=="select")) {
                    $enabled=" section-disabled";
                }

            } ?>
            <section id="<?= $section["id"] ?>" class="<?= gae_PLUGIN_DIRECTORY_NAME ?>-section<?= $enabled ?><?= $last ?>">

                <h2 id="section-<?= $section["id"] ?>" class="section-title"><?= $section["title"]; ?></h2>
                <p class="<?= gae_PLUGIN_DIRECTORY ?>-description">
                    <?= $section["description"]; ?>
                </p>
                <?php if (!empty($section["example"])): ?>
                    <code class="<?= gae_PLUGIN_DIRECTORY ?>-code">
                        <?= htmlentities($section["example"]); ?>
                    </code>
                <?php endif; ?>

                <ul id="section-<?= $section["id"] ?>-content" class="<?= gae_PLUGIN_DIRECTORY_NAME ?>-content">
                    <?php foreach ($section["fields"] as $field): ?>
                        <?php $title = $field["title"] ?>
                        <?php $id = $field["id"] ?>
                        <?php $value = $field["value"] ?>
                        <?php $default_value = $field["default_value"] ?>
                        <?php $placeholder = !empty($field["placeholder"]) ? $field["placeholder"] : "" ?>
                        <?php $options = !empty($field["options"]) ? $field["options"] : [] ?>
                        <?php $description = !empty($field["description"]) ? $field["description"] : "" ?>
                        <?php if ($id === "gea-debug-ip") {
                            $description .= "<br/>You current ip address is: " . $_SERVER["REMOTE_ADDR"];
                        }
                        ?>
                        <li><?php require(gae_INCLUDES_PATH . "/fields/" . $field["type"] . ".php"); ?></li>
                    <?php endforeach; ?>
                </ul>

            </section>
        <?php endforeach; ?>
        <section class="<?= gae_PLUGIN_DIRECTORY_NAME ?>-submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>"/>
        </section>
    </form>

    <script>
        jQuery(document).ready(function(){
            jQuery('.section-title').click(function(){
                console.log("clieck");
                var self =  jQuery(this).parent();
                if (self.hasClass("section-open")){
                    self.removeClass("section-open");
                } else {
                    self.addClass("section-open");
                }
            });

            jQuery('.google-analytics-events-section').last().addClass("section-open");
        });
    </script>
</div>
