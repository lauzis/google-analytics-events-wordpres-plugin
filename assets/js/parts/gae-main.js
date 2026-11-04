//[gae-variables]

//[gae-functions]


gae_ready(function () {

    //[gae-contact-links]

    document.querySelectorAll('a[href]').forEach(function (self) {
        var url = self.getAttribute("href");
        if (!self.classList.contains("gae-event")) {

            //[gae-track-links-to-specific-urls]

            //[gae-custom-links]

            //[gae-social-links]

            //[gae-file-downloads]

            //[gae-outgoing-links]

        }
    });

    //[gae-custom-element-tracking]

    //[gae-search]

    //[gae-mailchimp]
    //[gae-form-tracking-gravity-success]
    //[gae-form-tracking-field-change]
    //[gae-form-submission-tracking]

    //[gae-time-trigger]

    if (typeof(GAE_DEBUG)!=="undefined"){
        GAE_DEBUG.init();
    }

});
