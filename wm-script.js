/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery('document').ready(function(e){
    var notification="nope";
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
   notification=XMLHttpRequest;
   location.reload();
    localStorage['notification']='<strong>'+ notification + '</strong>';
},
error: function(XMLHttpRequest, textStatus, errorThrown)
{
  alert(errorThrown);  
}
   });
ex.preventDefault();

});
var cmform=e('#customswid');
   cmform.submit(function(ex){
      var formdata=cmform.serialize(); 
      var formurl=cmform.attr('action');
//Post Form with data
e.ajax({
type: 'post',
url: formurl,
data: formdata,
success: function(XMLHttpRequest,data, textStatus){
   notification=XMLHttpRequest;
   location.reload();
    localStorage['notification']='<strong>'+ notification + '</strong>';
},
error: function(XMLHttpRequest, textStatus, errorThrown)
{
  alert(errorThrown);  
}
   });
ex.preventDefault();

});
jQuery('#msg').html(localStorage['notification']);
});