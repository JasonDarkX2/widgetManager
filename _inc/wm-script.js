/*
 * javascript/jQuery  script for Wordpress Widget Manager plugin
 * Simply handles javascript of plugin
 * For more information check out: http://JasonDarkX2.com/ 
 */
jQuery('document').ready(function(e){
if (localStorage['notification'] != localStorage['lastnote']){
jQuery('#msg').html(localStorage['notification']);
        localStorage['lastnote'] = localStorage['notification'];
} else{
jQuery('#msg').empty();
        localStorage['lastnote'] = '';
        localStorage['notification'] = '';
}
jQuery('.deleteWid').click(function(e){
if (confirm("Are you Sure you want to delete?") == true) {
location.reload();
        localStorage['notification'] = '<strong>' + response + '</strong>';
}
});
   /*  var modal = document.getElementById('deleteModal');
    jQuery('.deleteWid').click(function(e){
        modal.style.display = "block";
       e.preventDefault();
      jQuery('.modal-content p').load(jQuery(this).attr('href'));
    });
    jQuery('.close').click(function(e) {
    modal.style.display = "none";
});
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}*/

        jQuery('#addWidget').click(function(e){
jQuery("#dialog #addWidgetForm").dialog({
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
        "Upload ": function(ex) {
        jQuery('#addWidgetForm').submit();
        },
                Cancel: function() {
                jQuery(this).dialog("close");
                },
        }
});
        });
                jQuery('#addWidget').click(function(e){
     jQuery("#addWidgetForm").dialog('open');
                });
        var wmform = e('#settingsop');
        wmform.submit(function(ex){
        var formdata = wmform.serialize();
                var formurl = wmform.attr('action');
//Post Form with data
                e.ajax({
                type: 'post',
                        url: formurl,
                        data: formdata,
                        success: function(XMLHttpRequest, data, textStatus){
                        notification = XMLHttpRequest;
                                location.reload();
                                localStorage['notification'] = '';
                                localStorage['notification'] = '<strong>' + notification + '</strong>';
                                },
                        error: function(XMLHttpRequest, textStatus, errorThrown)
                                {
                                localStorage['notification'] = '<strong>' + notification + '</strong>';
                                        }
                        });
                        ex.preventDefault();
                        });
                jQuery("#cdwd").change(function() {
        if (jQuery('#widgetdir').is(':disabled')){
        jQuery('#widgetdir').prop('disabled', false);
        } else{
        jQuery('#widgetdir').prop('disabled', true);
                jQuery('#widgetdir').val(defaults.defaultDir);
        }
        });
                jQuery('.switch-field input:radio').click(function(e){
        var name = jQuery(this).attr('name');
                var status = jQuery(this).val();
                var wpdir = jQuery('[name="wpdir"]').val();
                 var obj = {};
                 obj[name]= status;
                 var formData= {wpdir: wpdir,widgetid:name};
                 formData[name]= status;
                 jQuery.ajax({ type: "POST",
                        url:pd.pluginUrl,
                        data: formData,
                        success : function(text)
                        {
                        jQuery("#msg").html(text);
                        }

                });
             });
              jQuery('#customWidgetDir').click(function(e){
jQuery("#dialog #customDirForm").dialog({
title: "Change Custom Widgets Directory",
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
        "Change": function(ex) {
        //jQuery('#customDirForm').submit();
        var formData={wpdir:'nope'};
        jQuery.ajax({
            type : "POST",
            url: jQuery('#customDirForm').attr("action"),
            data:jQuery('#customDirForm').serialize(),
                                    success: function(XMLHttpRequest, data, textStatus){
                        notification = XMLHttpRequest;
                                location.reload();
                                localStorage['notification'] = '';
                                localStorage['notification'] = '<strong>' + notification + '</strong>';
                                },
                        error: function(XMLHttpRequest, textStatus, errorThrown)
                                {
                                localStorage['notification'] = '<strong>' + notification + '</strong>';
                                        }
        });
        },
                Cancel: function() {
                jQuery(this).dialog("close");
                },
        }
});
        });
        jQuery('#customWidgetDir').click(function(e){
     jQuery("#customDirForm").dialog('open');
 });
//debug JS scripts
                jQuery('#debug').click(function(e){
        e.preventDefault();
                if (jQuery('#debugSection').is(':visible') == false){
        jQuery('#debugSection').show();
                jQuery('#debug').html('Hide Debug Options');
        } else{
        jQuery('#debugSection').hide();
                jQuery('#debug').html('Show Debug Options');
        }
        });
                jQuery('#wlist').click(function(e){
        e.preventDefault();
                if (jQuery('#widgetList').is(':visible') == false){
        jQuery('#widgetList').show();
                jQuery('#customw').hide();
                jQuery('#rWidgetList').hide();
                jQuery('#wlist').html('Hide Widget List');
                jQuery('#rwList').html('Show Registered Widget');
                jQuery('#custlist').html('Show Custom Widget List');
        } else{
        jQuery('#widgetList').hide();
                jQuery('#wlist').html('Show Widget List');
        }
        });
                jQuery('#rwList').click(function(e){
        e.preventDefault();
                if (jQuery('#rWidgetList').is(':visible') == false){
        jQuery('#rWidgetList').show();
                jQuery('#widgetList').hide();
                jQuery('#customw').hide();
                jQuery('#rwList').html('Hide Registered Widget');
                jQuery('#wlist').html('Show Widget List');
                jQuery('#custlist').html('Show Custom Widget List');
        } else{
        jQuery('#rWidgetList').hide();
                jQuery('#rwList').html('Show Registered Widget');
        }
        });
                jQuery('#custlist').click(function(e){
        e.preventDefault();
                if (jQuery('#customw').is(':visible') == false){
        jQuery('#customw').show();
                jQuery('#widgetList').hide();
                jQuery('#rWidgetList').hide();
                jQuery('#custlist').html('Hide Custom Widget List');
                jQuery('#rwList').html('Show Registered Widget');
                jQuery('#wlist').html('Show Widget List');
        } else{
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

 