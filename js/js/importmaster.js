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

function show_topline(){
   document.getElementById("nav").innerHTML=import_html("dep/nav.html"); // Needs a div called "topline" right after body tags.
}

window.addEventListener("load", show_topline);

//document.body.onload = show_topline();