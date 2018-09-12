//[gae-variables]
//[gae-functions]

jQuery(function ($) {

    //pushing in history the current url
    //TODO local storage
    push_history(get_title());

    //[gae-contact-links]

    //Links tracking
    $('a').each(function () {
        var self = $(this);

        if (!self.hasClass("gae-events")) {
            var url = self.attr("href");
            var text = get_link_text(self);

            //[gae-track-links-to-specific-urls]

            //[gae-custom-links]

            //[gae-social-links]

            //[gae-file-downloads]

            //[gae-outgoing-links]

            //[gae-track-links-to-specific-urls]

        }
    });

    //[gae-custom-element-tracking]

    //[gae-search]

    //[gae-mailchimp]
    //[gae-form-tracking-gravity-success]
    //[gae-form-tracking-field-change]
    //[gae-form-submission-tracking]


    //[gae-time-trigger]

});
