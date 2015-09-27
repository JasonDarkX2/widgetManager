/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery('document').ready(function($){
   var wmform=$('#widmanager');
   wmform.submit(function(){
      var formdata=wmform.serialize(); 
      var formurl=wmform.attr('action');
//Post Form with data
alert(formurl);
alert(formdata);
$.ajax({
type: 'post',
url: formurl,
data: formdata,
success: function(XMLHttpRequest,data, textStatus){
    alert(textStatus);
},
error: function(XMLHttpRequest, textStatus, errorThrown)
{
      alert(textStatus); 
  alert(errorThrown);  
}
   });
});
});

 //*jQuery.post(pd.pluginUrl,$("#widmanager").serialize(),function(response){});
//*xmlhttp.send();

/*jQuery( document ).ready(function() {
    console.log( "ready!" );
});
jQuery(document).ready(function($) {
			alert('YUP');
	});*/