<?php
/*
 * Manager page for Wordpress Widget Manager plugin
 * Handles the displaying of widgets and their options
 * For more information check out: http://JasonDarkX2.com/ 
*/
?>
 <h1> Widget Manager</h1>
 <form id="settingsop" method="POST" action="<?php echo  plugins_url('actionScripts/options.php', dirname(__FILE__)); ?>">
     <input type="hidden" name="wpdir" value="<?php echo basename(content_url());?>" />
     <!--<table>
        <tr>
            <td><strong>Quick Options</strong></td>
            <td colspan="1">
                <?php if(get_option('preset-ndw')==FALSE):?>
                <b>|Enable Defaults Widgets Only:</b><input type="radio" name="quickOp" value="enbDefault">
                <b>|Disable Defaults Widgets Only:</b><input type="radio" name="quickOp" value="disDefault">
                <?php endif;?>
                <b>|Disable all custom widgets:</b><input type="radio" name="quickOp" value="disCust">
                <b>|Enable all Widgets:</b> <input type="radio" name="quickOp" value="enbwid">
                 <b>|Disable all Widgets:</b> <input type="radio" name="quickOp" value="diswid">
                 </td>
        </tr>
    </table>!-->
     <p id="msg">
    <?php
    autoDetect();
    ?>
</p>
      <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
    </form>
 