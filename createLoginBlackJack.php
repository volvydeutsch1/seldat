<?php

include 'classes.php';
$ererr1=$ererr2=$ererr3="";
if (isset($_POST["submit"])) {    
    if (isset($_POST["username"]) && isset($_POST["password"]) && ! empty(($_POST["username"])) && ! empty($_POST["password"])) {
        $_SESSION['username'] = $_POST["username"];
        $password = $_POST["password"];
        $passwordRe = $_POST["passwordRe"];
        
        if(!preg_match("/[a-zA-Z0-9]{5,10}/",$_SESSION['username'])){
            $ererr1 ="<span style=color:red;>invalid username</span>";
        }elseif($obj->searchusername($_SESSION['username'])){
            $ererr1 ="<span style=color:red;>this username is unavailable</span>";
        }
        if(!preg_match("/(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*]){8,}/",$password)){
            $ererr2 = "<span style=color:red;>invalid password</span>";
        }
        if($passwordRe != $password){
            $ererr3 = "<span style=color:red;>password mismatch</span>";
        }
        if($ererr1 =="" && $ererr2 =="" && $ererr3 ==""){
            if ($obj->insertIntoTable($_SESSION['username'], $password) && $obj->updateSet($_SESSION['username'], 100)) {                
                header("Location:home.php");
                exit();
            }
        }        
    }
}
include 'header.php';
?>
        <div id="login">
            <h3 class="text-center text-warning pt-5">Sign up</h3><br>
            <div class="container">
                <div id="login-row" class="row justify-content-center align-items-center">
                    <div id="login-column" class="col-md-6">
                        <div id="login-box" class="col-md-12 rounded-circle">
                            <form id="login-form" class="form" action="" method="post">
                                <h3 class="text-center text-success pt-4"></h3>
                                <div class="form-group px-5 pt-5">
                                    <label for="username" class="text-warning">Username:</label><span class="text-center text-right col-md-1"><?php echo $ererr1 ?></span><br>
                                    <input type="text" name="username" id="username" class="form-control">
                                    
                                </div>                             
                                <div class="form-group px-5">
                                    <label for="password" class="text-warning">Password:</label><span class="text-center text-right col-md-1"><?php echo $ererr2 ?></span><br>
                                    <input type="password" name="password" id="password" class="form-control">                                   
                                </div>                              
                                <div class="form-group px-5">
                                	<label for="password" class="text-warning">Confirm Password:</label><span class="text-center text-right col-md-1"><?php echo $ererr3 ?></span><br>
                                	<input type="password" name="passwordRe" id="password" class="form-control" required><br>                              	
                                </div>                                                             
                                <div class="form-group text-center">
                                	<input type="submit" name="submit" class="btn btn-warning btn-md w-25" value="submit">
                                </div>
                                <div id="register-link" class="text-right">
                                    <a href="loginBlackJack.php" class="text-warning pr-5">Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
<?php include 'footer.php';?>




