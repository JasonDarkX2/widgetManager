/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function setOptions(int,t,id,poll_id) {
     xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState===4 && xmlhttp.status===200) {
      document.getElementById(id).innerHTML=xmlhttp.responseText;
    }
  };
  query="vote="+int+"&topic="+t;
  xmlhttp.open("POST",pd.pluginUrl +"?"+query,true);
xmlhttp.send();
}
jQuery( document ).ready(function() {
    console.log( "ready!" );
});
jQuery(document).ready(function($) {
			alert('YUP');
	});