if (!self.hasClass("gae-events")){
    if (is_file(url)){
        self.click(function(){
            var text = get_link_text(self);
            send_event("File download",'File download clicked', text);
        });
        self.addClass("gae-events");
        self.addClass("gae-events-file-downloads");
    };
}

