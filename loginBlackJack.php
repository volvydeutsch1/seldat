<?php
include 'header.php';
include 'classes.php';
if (isset($_POST["submit"])) {
    // form has been submitted

    if (isset($_POST["username"]) && isset($_POST["password"]) && ! empty(($_POST["username"])) && ! empty($_POST["password"])) {

        $_SESSION['username'] = $_POST["username"];
        $password = $_POST["password"];
        if ($obj->checkLoginCredentials($_SESSION['username'], $password)) {
            header("Location:home.php");
            exit();
        }else{
            $error = "<span style=color:red;>invalid username/password</span>";
        }
    }
}
?>
        <div id="login">
            <h3 class="text-center text-warning pt-5">Login</h3><br>
            <div class="container">
                <div id="login-row" class="row justify-content-center align-items-center">
                    <div id="login-column" class="col-md-6">
                        <div id="login-box" class="col-md-12 rounded-circle">
                            <form id="login-form" class="form" action="" method="post">
                                <h3 class="text-center text-success pt-5"></h3>
                                <div class="text-center"><?php if(isset($error)){ echo $error;} ?></div>
                                <div class="form-group px-5 pt-5">
                                    <label for="username" class="text-warning">Username:</label><br>
                                    <input type="text" name="username" id="username" class="form-control">
                                </div>
                                <div class="form-group px-5">
                                    <label for="password" class="text-warning">Password:</label><br>
                                    <input type="password" name="password" id="password" class="form-control"><br>
                                </div>                                
                                <div class="form-group text-center">
                                	<input type="submit" name="submit" class="btn btn-warning btn-md w-25" value="submit">
                                </div>
                                <div id="register-link" class="text-right">
                                    <a href="createLoginBlackJack.php" class="text-warning pr-5 pt-0">Sign up</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

 <?php include 'footer.php';?>