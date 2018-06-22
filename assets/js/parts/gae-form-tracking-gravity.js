
        //GRAVITY FORMS SUCCESS EVENTS
        //TODO gravity forms reload
        $(document).on("gform_confirmation_loaded", function (e, form_id) {
            // code to run upon successful form submission

            //getting from history last two pages
            var this_url =pop_history();
            var prev_url =pop_history();

            // from where user arrived?
            var source = prev_url;
            if (source.length==0){
                source = "Source : Direct ";
            } else {
                source =" Source : "+source;
            }

            //sending event some special cases can be here defined
            switch(form_id){

                default:
                    var label ="";
                    label = lang;

                    //starting of the input field id/name
                    //gravity forms has all input fields starting wint input_{id of form}
                    var input_id = "input_"+form_id;
                    var tracked_value ="";

                    for(x in tracked_form_values){
                        if (x.indexOf(input_id)>-1){
                            tracked_value+=" "+tracked_form_values[x];
                        }
                    }

                    tracked_value = tracked_value.trim();

                    if (tracked_value.length>0){
                        label = tracked_value;
                    }

                    send_event(get_title()+' form sent', source, label);

                    break;
            }


            // puting back urls in history
            if (prev_url.length>0){
                push_history(prev_url);
            }
            if (this_url.length>0){
                push_history(prev_url);
            }

        });

        debug_message("TODO: Assigned success events on gravity forms");