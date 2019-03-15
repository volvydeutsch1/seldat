<?php
include 'header.php';
if(isset($_POST["start"])){
    header("Location:bet.php");
    exit();
}
?>
<h1 class="text-center text-warning pt-5 rounded">Welcome To Black Jack</h1>
<form method="post">
    <div class="container mt-5 text-center">
    	<button class="btn btn-warning" name="start" type="submit">Start Playing</button>
    </div>
</form>
<?php include 'footer.php';?>