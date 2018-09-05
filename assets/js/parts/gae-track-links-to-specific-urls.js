debug_message("todo track links to specific urls");
var gae_destinations_to_track = "[gae-track-links-to-specific-urls-list]";
console.log(gae_destinations_to_track);

gae_destinations_to_track = gae_destinations_to_track.split(",");
console.log(gae_destinations_to_track);

var gaeD2T = null;
for(gaeD2T  in gae_destinations_to_track){

    console.log(gae_destinations_to_track[gaeD2T]);

}