/*
Main Page
result_element=[productID, productBrand, broductWeight, productPackaging, subcategoryID, supermarketID, price]
CATEGORIES:
*/

var CATEGORIES, listr, cart,uid;
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
    return (call_Server('GET','?action=getcarts'+uid));
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

/* function add_to_cart(item){
    cart.push(item);
    for (i=0;i<cart.length;i++)
} */



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
CATEGORIES=getCategories();
console.log(eval("("+CATEGORIES['results']+")"));
function load_page(){
    document.getElementById("sideline_left").innerHTML=mk_full_sideline(CATEGORIES);
    }

window.addEventListener("load",load_page);
//window.addEventListener("submit",saveCart(uid)  );
window.addEventListener("keypress", function (e) {
    //display(typin, "maincontainer");
    var key = e.which || e.keyCode;
    if (key === 13) { // 13 is enter
      getSearchResults();
    }});
    
    
