<?php
$pages = array(
    'index' => _('Workspace'),
    'config' => _('Configuration'),
    'devicetest' => _('Debugging')
);
?>
<div class="navbar navbar-fixed-top"> 
  <div class="navbar-inner"> 
    <div class="container"> 
      <div class="nav-collapse"> 
        <ul class="nav"> 
            <?php foreach($pages as $code => $name): ?>
                <li><a href="?page=<?php echo $code ?>"<?php echo (isset($template) && $template == $code ? ' class="active"' : '') ?>><?php echo $name ?></a></li>
            <?php endforeach ?>
        </ul> 
        <div id="clock"></div>
     </div> 
   </div> 
  </div> 
</div> 
