/* 
Jonathan Hamann
Off Beam Studios
19.09.2015

#########################

! For syncronous requests: The script only continues after recieving a response from Server.
How to use the script:

1. Call Centre with a 'GET'-request:
>>> call_Centre_sync('GET','/route?variable1=content1&variable2=content2');
Side-note: Do not use a header.

2. Call Centre with a 'POST'-request:
>>> call_Centre_sync('POST','/route',[['header1name','header1value'],['header2content',...]],'data-content');
Side-note: Use both headers AND data.

3. Get the response:
>>> direct return from function call_Centre_sync

#########################
 */

function call_Server(method, appendix, r_headers, r_data) {
  var xhr = new XMLHttpRequest();
  if (xhr) {
      xhr.open(method, "__testfunc.php"+appendix, false);
      if (r_headers != undefined && r_data != undefined){      //for POST-requests.
            while(i<r_headers.length){
                  xhr.setRequestHeader(r_headers[i][0],r_headers[i][1]);
                  i++;}
            xhr.send(r_data);
      }else{                                                  // for GET-requests.
        xhr.send();
      }
      return (xhr.responseText);
  }
  else {
    alert("No Invocation took place at all");
  }
}