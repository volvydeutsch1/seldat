<?php
include 'classes.php';
include 'header.php';

if(!isset($_POST["hit"]) && !isset($_POST["stand"]) && !isset($_POST["split"])){
    $_SESSION['Game'] = new game($_SESSION["hand"]);    
    $_SESSION['Game']->beginCard($_SESSION["hand"]);   
}
if(isset($_POST["split"])){
    $_SESSION["hand"]++;
   
}
if(isset($_POST["hit"])){
    $_SESSION['Game']->getPlayer()->hit();
}
if(isset($_POST["stand"])){
    $_SESSION['Game']->stand();
}

?>
<div class="container">
	<h1 class="text-center text-warning py-5">Deal Amount<br>$<?php echo $_SESSION["betAmount"]?>.00</h1>
	<form method="post">
    <div class="row text-center text-warning">	     	
        <?php echo $_SESSION['Game']->hand($_SESSION["hand"]);?>
    </div>
    </form> 
</div>
<?php include 'footer.php';?>