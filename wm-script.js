/*
Plugin Name: Wordpress Widget Manager
Plugin URI: https://github.com/JasonDarkX2/Wordpress-WidgetManager
Description:Simply a Wordpress Plugin dedicated to help easily manage custom and default Wordpress widgets
Author:Jason Dark X2
version: 0.70
Author URI:http://www.jasondarkx2.com/ 
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
           //jQuery.post(url.addWidgetUrl,jQuery('#addwidget').serialize(),function(response){
                //alert(response);
                var file_data = jQuery('#widgetToUpload').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('widgetToUpload', file_data);
                jQuery.ajax({
                   url: url.addWidgetUrl,
                   dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,     
                   type:'POST',
                   success: function(php_script_response){
                    //alert(php_script_response); // display response from the PHP script, if any
                    //jQuery('#debug').html(php_script_response);
                }
                   });       
          jQuery( this ).dialog( "close" );
          location.reload();
        },
        Cancel: function() {
          jQuery( this ).dialog( "close" );
        },
    }
});
});
});
