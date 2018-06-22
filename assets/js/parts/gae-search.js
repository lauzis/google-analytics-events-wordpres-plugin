//2.. Search bar - add event for using the search bar
$('#mobile-search, #desktop-search, #tablet-search').submit(function( event ) {
    var self = $(this);
    var searchterm = self.find('input[name=search]').first().val();
    send_event("Search bar","Serch term sent",searchterm.trim());
    self.addClass("gae-events");
    self.addClass("gae-events-search-submit");
});

debug_message("Assigned submit events on search form");