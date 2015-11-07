/* 
Jonathan Hamann
Off Beam Studios
14.09.2015

import_html(filename) returns the content of the file. 

!!IMPORTANT: Edit: Outdated, replaced by window event listener
master_importer needs to be called in body onload="master_importer()". Otherwise the id is not known to the browser. 
Alternatively call the master_importer() function at the end of the page in a seperate script.

 */

function import_html(filename) {
    var ic = new XMLHttpRequest();
    ic.open('GET', filename, false);
    ic.send();
    return (ic.responseText);
}
function add_uid_to_links(){
     document.getElementById("homeLink").href = "Home.html?uid="+UID;
     document.getElementById("chatLink").href = "Chat.html?uid="+UID;
     document.getElementById("profileLink").href = "Profile.html?uid="+UID;
     document.getElementById("questLink").href = "Quest.html?uid="+UID;
     document.getElementById("logoutLink").href = "Logout.html?uid="+UID;
     document.getElementById("settingsLink").href = "Settings.html?uid="+UID;
}

function show_topline(){
   document.getElementById("topline").innerHTML=import_html("global_header.html"); // Needs a div called "topline" right after body tags.
   add_uid_to_links();
}

window.addEventListener("load", show_topline);

//document.body.onload = show_topline();