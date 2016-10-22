<!-- The Modal -->
<div id="deleteModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
      <h1>Delete Widget?</h1>
    <span class="close">x</span>
 <?php 
 $url = plugins_url( '/controllers/widgetAdder_controller.php',  dirname(__FILE__));
 var_dump($url);
  $credentials=request_filesystem_credentials($url); ?>
    <p></p>
  </div>
</div>