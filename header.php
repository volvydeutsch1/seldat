<?php session_start();
if(!isset($_SESSION['username']) && $_SERVER["PHP_SELF"] != "/blackjack/createLoginBlackJack.php" && $_SERVER["PHP_SELF"] != "/blackjack/loginBlackJack.php"){
    header("Location:loginBlackJack.php");
    exit();
}
if(isset($_POST['logOut'])){
    unset($_SESSION['username']);
    header("Location:loginBlackJack.php");
    exit();
}?>
<!DOCTYPE html>
<html>
	<head>
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<!-- for home -->
<!-- 		<link href="bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
		<link href="https://fonts.googleapis.com/css?family=Bree+Serif" rel="stylesheet">
		<style>
		      body {
                  margin: 0;
                  padding: 0;
                  //background-color: #1d4617;
                  background-image:radial-gradient( #009000, #003b00);
                  height: 100vh;
                  font-family: 'Bree Serif', serif;
                  background-image:url('background.jpg');
                background-size:100% 100%;
                }
                nav{
                    background-color:#4d261180;
                    }                 
                #login .container #login-row #login-column #login-box {
                  margin-top: 120px;
                  max-width: 600px;
                  height: 500px;
                  border: 1px solid #18110b;
                  background-color:#4d261180;
                  //background-image:radial-gradient( #009000, #003b00);
                  //color:#865b06 ;
                }
                #login .container #login-row #login-column #login-box #login-form {
                  padding: 20px;
                }
                #login .container #login-row #login-column #login-box #login-form #register-link {
                  margin-top: -85px;
                } 
                input[type="number"]::-webkit-outer-spin-button, input[type="number"]::-webkit-inner-spin-button {
                    -webkit-appearance: none;
                    margin: 0;
                }
                input[type="number"] {
                    -moz-appearance: textfield;
               } .overlay{
                    position: absolute;
                    margin-left: auto;
                    margin-right: auto;
                    left: 0;
                    right: 0;
                    top: 50%;
                    font-size: 50px;
                    text-shadow: 3px 3px 0 #ffff00, -1px -1px 0 #ffff00, 1px -1px 0 #ffff00, -1px 1px 0 #ffff00, 1px 1px 0 #ffff00;
                    
               }
                    
		</style>		
	</head>
	<body>
	<nav class="navbar navbar-dark  navbar-expand-md" role="navigation">
		<div class="container">
			<a class="navbar-brand text-warning" href="home.php">Blackjack</a>
			<?php if(isset($_SESSION['username'])){?>
			<div class="dropdown">
  				<button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['username'];?></button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="balanceTopUp.php">Balance top up</a>
                    <a class="dropdown-item" href="passworedReset.php">passwored reset</a>
                    <form method="post"><button type="submit" class="dropdown-item" name="logOut">Log out</button></form>
                </div>
			</div>
			<?php }?>
		</div>
	</nav>
	

