/* 
Jonathan Hamann
Off Beam Studios
19.09.2015

converts a Json input to an n-dimensional array.

 */

function toArray(json_input){
        var as_string = json_input.substring(a.indexOf("["),a.lastIndexOf("]")+1);
        var as_arr=eval("("+ as_string +")");
        return (as_arr);
    }