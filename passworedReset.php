<?php
include 'header.php';
include 'classes.php';
$ererr2=$ererr3="";
if(isset($_POST['submit'])){
    $password = $_POST["password"];
    $passwordRe = $_POST["passwordRe"];
    if(!preg_match("/(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*]){8,}/",$password)){
        $ererr2 = "<span style=color:red;>invalid password</span>";
    }
    if($passwordRe != $password){
        $ererr3 = "<span style=color:red;>password mismatch</span>";
    }
    if($ererr2 =="" && $ererr3 ==""){
        if ($obj->updateSetP($_SESSION['username'], $password)){
            header("Location:home.php");
            exit();
        }
    }
}
?>
	
<div id="login">
    <h1 class="text-center text-warning pt-5">Reset Passwored</h1><br>
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12 rounded-circle">
                    <form id="login-form" class="form" action="" method="post">
                        <h3 class="text-center text-warning py-5"></h3>
                        <div class="form-group px-5">
                                    <label for="password" class="text-warning">New Password:</label><span class="text-center text-right col-md-1"><?php echo $ererr2 ?></span><br>
                                    <input type="password" name="password" id="password" class="form-control" autofocus required>
                                    
                                </div>                              
                                <div class="form-group px-5">
                                	<label for="password" class="text-warning">Reenter Password:</label><span class="text-center text-right col-md-1"><?php echo $ererr3 ?></span><br>
                                	<input type="password" name="passwordRe" id="password" class="form-control" required>
                                	
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
