if (typeof(GAE_TIME_TRIGGER_TRESHOLD)!=="undefined" && GAE_TIME_TRIGGER_TRESHOLD>0){
    setTimeout(function(){
        send_event("Time treshold",'Reached', 'Still reading',1);
    }, GAE_TIME_TRIGGER_TRESHOLD*1000);
}