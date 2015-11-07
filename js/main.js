/*
Main Page
result_element=[productID, productBrand, broductWeight, productPackaging, subcategoryID, supermarketID, price]
CATEGORIES:
*/

var CATEGORIES, search_results, cart,uid;
uid="902909309";
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
// cart- functions
function getCarts(){
    return (call_Server('GET','?action=getcarts'));
}

function saveCart(uid){
    var name = prompt("Enter Cart name: ","");
    var as_string;
    for (i=0;i<cart.length;i++){
      as_string=as_string+","+cart[i];
    }
    return (call_Server('GET','?action=savecarts&name='+name+'&value='+as_string+'&user='+uid));
}

function getCartContent(cartID){
    cart=toArray(call_Server('GET','?action=getcartcontent&value='));
}



function add_to_cart(item){
    cart.push(item);
}

function investigate(){
    
}

//display
function display(content, elementid){
    document.getElementById(elementid).innerHTML=content;
}

window.addEventListener("load",getCategories);
//window.addEventListener("submit",saveCart(uid)  );
window.addEventListener("keypress", function (e) {
    //display(typin, "maincontainer");
    var key = e.which || e.keyCode;
    if (key === 13) { // 13 is enter
      getSearchResults();
    }
    0});

