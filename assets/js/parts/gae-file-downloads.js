if (!self.classList.contains("gae-event")){
    if (is_file(url)){
        self.addEventListener("click", function(){
            send_event("File download",'File download clicked', get_link_text(self));
        });
        self.classList.add("gae-event", "gae-event-file-downloads");
    };
}
