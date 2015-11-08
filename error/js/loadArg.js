/* 
Jonathan Hamann
Off Beam Studios
19.09.2015

#########################
Loads user ID automatically into session variable UID. Argument passing using URL. 
Use htmldoc.html?uid=[user_id] for EVERY link within the app.

How to use the script:
1. User ID loads automatically.
2. For reading additional arguments passed through URL, use
  getVar(varName) like this.
3. For Adding the UID to any URL or each element of an array of URLs, use
  addUidToUrl(url_in) for single URLs
  addUidToArrOfUrls(array_in) for arrays of URLs.
  
Generally:
getVar(varName): returns value of varName as a string.

Example:
  say, [url]="mypage.html/myvar=myvalue&uid=[user_id]" #order is not important

  var myvarInJS = getVal("myvar"); // returns myvalue as a string.
 

#########################
 */


var UID="";
function get_args_from_url(){ 
    var urltext = document.location.href; //load url text
    var argray = urltext.split("?")[1].split("&");//if two "?" in URL, the text after the second "?" will be ignored.
    var i = 0;
    while (i<argray.length){
        argray[i] = argray[i].split("=");
        i++;
    }
    return (argray); //format:[[var1,value1],[var2,value2],...,[var_n,value_n]]
} 

function getVal(varName){
    var args = get_args_from_url();
    var i = 0;
    while (i<args.length){
            if(args[i][0].toLowerCase()==varName.toLowerCase()){
                return(args[i][1].replace("%20"," ")); //fill in blank space, if needed.
            }
            i++;
    }
} 

UID=getVal("uid");

//Adding UID to single urls:
function addUidToUrl(url_in){
    if (url_in.indexOf("?")==-1){
        return (url_in+"?uid="+UID)
    }
    else{
        var afterquestnm = url_in.substring(url_in.indexOf("?")+1,url_in.length);
        var befrquestm = url_in.substring(0,url_in.indexOf("?"));
        return (befrquestm + "?uid="+UID+"&" + afterquestnm);
    }
}
//adding UID to every element of an Array of URLS.
function addUidToArrOfUrls(array_in){
    var i = 0;
    var a = array_in;
    while (i<a.length){
         a[i]=addUidToUrl(a[i]);
         i++; 
    }
    return (a);
}