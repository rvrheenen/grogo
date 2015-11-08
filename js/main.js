/*
Main Page
result_element=[productID, productBrand, broductWeight, productPackaging, subcategoryID, supermarketID, price]
CATEGORIES:
GetCart=> [[CartID1,userID1,name1],[C2,UID2,N2]...]
*/

var CATEGORIES, listr, cart=[];
var uid, SAVED_CARTS;
uid="902909309";
CATEGORIES=[["Vegetables",["Potatoes", "Tomatoes","Carrots"]],["Fruits",["Apples","Oranges","Cherries"]],["Beverages",["Beer","Juice","Schnaps"]]];
var numbers=["One","Two","Three","Four","Five","Six","Seven","Eight","Nine","Ten","Eleven"]
//IMPORTS:
//get data from server
function getCategories(){
    return(call_Server('GET','?action=getcat'));
}


function getSearchResults(){
    var searchvalue = document.getElementById("fsearch").value;
    listr = call_Server('GET','?action=searchsubcat&value='+searchvalue);
    alert (listr);
}
// cart- functions
function getCarts(uid){
    return (call_Server('GET','?action=getcarts&value='+uid));
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
    cart=toArray(call_Server('GET','?action=getcartcontent&value='+cartID));
}

function add_to_cart(item){
    cart.push(item);
    var full_entry="";
    var new_entry=import_html("dep/nav_cart_entry.html");
    console.log(new_entry);
    for (i=0;i<cart.length;i++){
        full_entry+=new_entry.replace("[name-placeholder]",cart[i][1]).replace("[price-placeholder]",cart[i][6]);
    }
    new_nav=import_html("dep/nav.html").replace("[cartlist-placeholder]",full_entry);
    document.getElementById("nav").innerHTML=new_nav;
}



//display
function mk_sideline_element(header,entries){
     var next_element=import_html("dep/main_sideline_header.html").replace("[header-placeholder]",header);
     var new_entry=import_html("dep/main_sideline_element.html");
     var full_single="";
     for (i=0;i< entries.length ;i++){
          full_single+=new_entry.replace("[entry-placeholder]",entries[i]);
     }
     return (next_element.replace("[table-placeholder]",full_single));
}

function mk_full_sideline(categories_in){
     var full_sideline="";
     for (j=0;j<categories_in.length;j++){
        full_sideline+=mk_sideline_element(categories_in[j][0],categories_in[j][1]).replace("[number-placeholder]",numbers[j]).replace("[number2-placeholder]",numbers[j]);
     }
     return (full_sideline);
     }
// run
function catarr_creator(){
    var catarr=[];
    var raw_data = JSON.parse(getCategories())["results"];
    for (i=0; i<raw_data.length;i++){
        catarr.push([Object.keys(raw_data[i])[0],raw_data[i][Object.keys(raw_data[i])[0]]]);
    } 
    return (catarr);
} 

function cartarr_creator(){
    var cartarr=[];
    var raw_data = JSON.parse(getCarts(uid))["results"];
    for (i=0; i<raw_data.length;i++){
        cartarr.push([raw_data[i]["cart_id"],raw_data[i]["user_id"],raw_data[i]["cart_description"]]);
    } 
    return (cartarr);
}
//run
CATEGORIES=catarr_creator();
SAVED_CARTS=cartarr_creator();
alert (SAVED_CARTS);
//alert(CATEGORIES);

function load_page(){
    document.getElementById("sideline_left").innerHTML=mk_full_sideline(CATEGORIES);
    add_to_cart([109847, "Green Bananasauce", "500g", "in a black box", 234987982, 00723, "10"]);
    }

window.addEventListener("load",load_page);
//window.addEventListener("submit",saveCart(uid)  );
window.addEventListener("keypress", function (e) {
    //display(typin, "maincontainer");
    var key = e.which || e.keyCode;
    if (key === 13) { // 13 is enter
      getSearchResults();
    }});
    
    
    
