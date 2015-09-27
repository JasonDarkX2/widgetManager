/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery('document').ready(function(e){
    
   var wmform=e('#widmanager');
   wmform.submit(function(ex){
      var formdata=wmform.serialize(); 
      var formurl=wmform.attr('action');
//Post Form with data
e.ajax({
type: 'post',
url: formurl,
data: formdata,
success: function(XMLHttpRequest,data, textStatus){

    alert("YEESS!");
    alert(XMLHttpRequest);
    alert(data);
},
error: function(XMLHttpRequest, textStatus, errorThrown)
{
      alert("NOOO!"); 
  alert(errorThrown);  
}
   });
ex.preventDefault();

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