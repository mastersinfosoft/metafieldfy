<?php 
$page =  end(explode('/', $_SERVER['REQUEST_URI']));
?>
<div class="list-group">
  <a href="allmetafields.php" class="list-group-item <?php if($page == 'allmetafields.php'){ echo 'active'; } ?>">Add Shop Meta fields</a>
  <a href="addmetafields.php" class="list-group-item <?php if($page == 'addmetafields.php'){ echo 'active'; } ?>">Add Product Meta fields</a>
</div>