<?php
include 'header.php';
include 'classes.php';
if(isset($_POST['submit'])){
    if($obj->updateSet($_SESSION['username'], $_POST['balance'])){
        header("Location:home.php");
        exit();
    }
}
?>
	
<div id="login">
    <h1 class="text-center text-warning pt-5">Balance Top Up</h1><br>
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12 rounded-circle">
                    <form id="login-form" class="form" action="" method="post">
                       <h3 class="text-center text-warning py-5">Current Balance:<br>$<?php echo $obj->balance($_SESSION['username']);?>.00</h3>
                        <div class="form-group px-5 py-5 ">
                            <label for="username" class="text-warning">Let's double your money:</label><br>
                            <input type="number" min="0" name="balance" class="form-control" autofocus required>
                        </div>                                                                
                        <div class="form-group text-center pt-5">
                        	<input type="submit" name="submit" class="btn btn-warning btn-md w-25" value="submit">
                        </div>                                
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php';?>