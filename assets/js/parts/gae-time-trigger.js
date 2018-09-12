if (typeof(GAE_TIME_TRIGGER_TRESHOLD)!=="undefined" && GAE_TIME_TRIGGER_TRESHOLD>0){
    debug_message(GAE_TIME_TRIGGER_TRESHOLD);
    setTimeout(function(){
        send_event("Time treshold",'Reached', 'Still reading',1);
    }, GAE_TIME_TRIGGER_TRESHOLD*1000);
}