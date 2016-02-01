/*
Plugin Name: Wordpress Widget Manager
Plugin URI: https://github.com/JasonDarkX2/Wordpress-WidgetManager
Description:Simply a Wordpress Plugin dedicated to help easily manage custom and default Wordpress widgets
Author:Jason Dark X2
version: 0.70
Author URI:http://www.jasondarkx2.com/ 
*/ 
jQuery('document').ready(function(e){
    if(localStorage['notification']!=localStorage['lastnote']){
        jQuery('#msg').html(localStorage['notification']);
        localStorage['lastnote']=localStorage['notification'];
    }else{
        jQuery('#msg').empty();
        localStorage['lastnote']='';
        localStorage['notification']='';
    }
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
    position: { my: 'center', at: 'center' }, 
    buttons: {
        "Upload ": function() {
                var file_data = jQuery('#widgetToUpload').prop('files')[0];
                var dir=jQuery('#wpdir').val();
    var form_data = new FormData();                  
    form_data.append('widgetToUpload', file_data);
    form_data.append('wpdir', dir);
                jQuery.ajax({
                   url: url.addWidgetUrl,
                   dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,     
                   type:'POST',
                   success: function(XMLHttpRequest,data, textStatus){
                       notification=XMLHttpRequest;
                       window.location.reload();
                       localStorage['notification']='';
                       localStorage['notification']='<strong>'+ notification + '</strong>';
                }
                   });       
          jQuery( this ).dialog( "close" );
        },
        Cancel: function() {
          jQuery( this ).dialog( "close" );
        },
    }
});
});
var wmform=e('#settingsop');
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
   localStorage['notification']='';
    localStorage['notification']='<strong>'+ notification + '</strong>';
},
error: function(XMLHttpRequest, textStatus, errorThrown)
{
localStorage['notification']='<strong>'+ notification + '</strong>';
}
   });
ex.preventDefault();

});

jQuery("#cdwd").change(function() {
    if(jQuery('#widgetdir').is(':disabled')){
        jQuery('#widgetdir').prop('disabled',false);
    }else{
        jQuery('#widgetdir').prop('disabled',true);
       jQuery('#widgetdir').val(defaults.defaultDir);
    }
});
//debug JS scripts
jQuery('#debug').click(function(e){
    e.preventDefault();
    if(jQuery('#debugSection').is(':visible')==false){
    jQuery('#debugSection').show();
    jQuery('#debug').html('Disable Debug section');
    }else{
      jQuery('#debugSection').hide();
    jQuery('#debug').html('Enable Debug section');  
    }
});
jQuery('#wlist').click(function(e){
    e.preventDefault();
    if(jQuery('#widgetList').is(':visible')==false){
    jQuery('#widgetList').show();
    jQuery('#customw').hide();
     jQuery('#rWidgetList').hide();
    jQuery('#wlist').html('Hide Widget List');
    jQuery('#rwList').html('Show Registered Widget');
    jQuery('#custlist').html('Show Custom Widget List');  
    }else{
      jQuery('#widgetList').hide();
    jQuery('#wlist').html('Show Widget List');  
    }
});
jQuery('#rwList').click(function(e){
    e.preventDefault();
    if(jQuery('#rWidgetList').is(':visible')==false){
    jQuery('#rWidgetList').show();
    jQuery('#widgetList').hide();
    jQuery('#customw').hide();
    jQuery('#rwList').html('Hide Registered Widget');
    jQuery('#wlist').html('Show Widget List');  
    jQuery('#custlist').html('Show Custom Widget List');  
    }else{
      jQuery('#rWidgetList').hide();
    jQuery('#rwList').html('Show Registered Widget');  
    }
});
jQuery('#custlist').click(function(e){
    e.preventDefault();
    if(jQuery('#customw').is(':visible')==false){
    jQuery('#customw').show();
    jQuery('#widgetList').hide();
     jQuery('#rWidgetList').hide();
    jQuery('#custlist').html('Hide Custom Widget List');
    jQuery('#rwList').html('Show Registered Widget');
    jQuery('#wlist').html('Show Widget List');  
    }else{
      jQuery('#customw').hide();
    jQuery('#custlist').html('Show Custom Widget List');  
    }
});
jQuery('#clearAll').click(function(e){
    e.preventDefault();
    jQuery.ajax({ type: "GET",   
         url: jQuery(this).attr("href"),   
         async: false,
         success : function(text)
         {
             location.reload();
         }
         
});
});

jQuery('#clearCust').click(function(e){
     e.preventDefault();
 jQuery.ajax({ type: "GET",   
         url: jQuery(this).attr("href"),   
         async: false,
         success : function(text)
         {
             location.reload();
         }
         
});
});
//end of bebug section
});
