//2.. Search bar - add event for using the search bar
$('#mobile-search, #desktop-search, #tablet-search').submit(function( event ) {
    var self = $(this);
    var searchterm = self.find('input[name=search]').first().val();
    send_event("Search bar","Serch term sent",searchterm.trim());
});
