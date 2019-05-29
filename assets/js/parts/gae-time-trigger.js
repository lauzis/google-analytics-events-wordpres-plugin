if (typeof(GAE_TIME_TRIGGER_THRESHOLD)!=="undefined" && GAE_TIME_TRIGGER_THRESHOLD>0){
    setTimeout(function(){
        send_event("Time threshold",'Reached', 'Still reading',1);
    }, GAE_TIME_TRIGGER_THRESHOLD*1000);
}