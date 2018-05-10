//[gae-variables]
//[gae-functions]

jQuery(function($) {

  //pushing in history the current url
  //TODO local storage
  push_history(get_title());

  //Links tracking
  $('a').each(function(){
      var self = $(this);
      var url=self.attr("href");
      if(!self.hasClass("gae-events")){
        //[gae-custom-links]

        //[gae-social-links]

        //[gae-file-downloads]

        //[gae-outgoing-links]

      }
  });


  //[gae-form-tracking-gravity]

  //[gae-form-tracking]

  //[gae-custom_element_tracking]


});
