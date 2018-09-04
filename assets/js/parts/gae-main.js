//[gae-variables]
//[gae-functions]

jQuery(function($) {

  //pushing in history the current url
  //TODO local storage
  push_history(get_title());

  //[gae-contact-links]

  //Links tracking
  $('a').each(function(){
      var self = $(this);
      var url=self.attr("href");
      if(!self.hasClass("gae-events")){

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

  //[gae-form-tracking-gravity]

  //[gae-form-tracking-field-change]

  //[gae-time-trigger]

});
