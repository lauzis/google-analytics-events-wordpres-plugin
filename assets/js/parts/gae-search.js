$( "form" ).each(function(){

    var self = $(this);
    if (!self.hasClass("gae-event")){

        if (self.find('input[name="s"]').length>0){
            self.submit(function(event){

                //lets try to find title
                var self = $(this);
                category = "Search";
                action = "Search Submitted";
                label = self.find('input[name="s"]').first().val();
                value = null;

                send_event(category, action, label, value)

            });
            self.addClass("gae-event");
            self.addClass("gae-event-search");

            self.find('input[name="s"]').change(function(){

                var search_field = $(this);
                // if (!search_field.hasClass("gae-used")){

                    category = "Search";
                    action = "Search Used";
                    label = search_field.val();
                    value = null;
                    send_event(category, action, label, value)
                //}
                //search_field.addClass("gae-used");
            });

            self.find('input[name="s"]').first().addClass("gae-event");
            self.find('input[name="s"]').first().addClass("gae-event-search");
        }
    }
});