/*
Plugin Name: Wordpress Widget Manager
Plugin URI: https://github.com/JasonDarkX2/Wordpress-WidgetManager
Description:Simply a Wordpress Plugin dedicated to help easily manage custom and default Wordpress widgets
Author:Jason Dark X2
version: 0.70
Author URI:http://www.jasondarkx2.com/ 
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
jQuery('.deleteWid').click(function(e){
    e.preventDefault();
 if (confirm("Are you Sure you want to delete?") == true) {
jQuery.ajax({ type: "GET",   
         url: jQuery(this).attr("href"),   
         async: false,
         success : function(text)
         {
             response = text;
         }
});
   location.reload();
   localStorage['notification']='<strong>'+ response + '</strong>';
 }
});
jQuery('#addWidget').click(function(e){
  jQuery( "#dialog" ).dialog({
        title: "Add/Import new Custom Widgets",
        modal: true,
    draggable: true,
    resizable: false,
    width: 800,
    height: 240,
    show: 'blind',
    hide: 'blind',
    dialogClass: 'ui-dialog',
    buttons: {
        "Upload ": function() {
          jQuery( this ).dialog( "close" );
        },
        Cancel: function() {
          jQuery( this ).dialog( "close" );
        },
    }
});
});
});
