/*
Main Page

CATEGORIES:
*/

var CATEGORIES, search_results, cart;
//IMPORTS:
var typin;

//get data from server
function getCategories(){
    CATEGORIES = call_Server('GET','?action=getcat');
}

function getSearchResults(){
    var searchvalue = document.getElementById("fsearch").value;
    search_results = call_Server('GET','?action=searchsubcat&value='+searchvalue);
    alert (search_results);
}
//

function add_to_cart(item){
    kart=kart+item;
}

function investigate(){
    
}

//display
function display(content, elementid){
    document.getElementById(elementid).innerHTML=content;
}

window.addEventListener("load",getCategories);
window.addEventListener("keypress", function (e) {
    //display(typin, "maincontainer");
    var key = e.which || e.keyCode;
    if (key === 13) { // 13 is enter
      getSearchResults();
    }
    0});

