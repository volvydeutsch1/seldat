<?php
include 'header.php';
include 'classes.php';
if(isset($_POST["submit"]) && $obj->betControl($_POST["betAmount"],$_SESSION['username'],$_POST['hand']) === true){
    $_SESSION["betAmount"]=$_POST["betAmount"];
    $_SESSION["hand"]=$_POST["hand"];
    $_SESSION["deck"]=$_POST["deck"];
    header("Location:startGame.php");
    exit();
}
?>
<div id="login">
    <h1 class="text-center text-warning pt-5">Tripel your accounts</h1><br>
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12 rounded-circle">
                    <form id="login-form" class="form text-center" action="" method="post">
                       <h3 class="text-center text-warning pt-5">Current Balance:<br>$<?php echo $obj->balance($_SESSION['username']);?>.00</h3>
                        <div class="form-group pt-5 pb-2">
                            <label for="username" class="text-warning float-left">Amount to bet:</label><span class="text-danger"><?php if(isset($_POST["submit"])){echo $obj->betControl($_POST["betAmount"],$_SESSION['username'],$_POST['hand']);}?></span><br>
                            <input type="number" min="1" name="betAmount" class="form-control" autofocus required>
                        </div>                       
                        <div class="btn-group btn-group-toggle form-group" data-toggle="buttons">
                            <label class="btn btn-warning active">
                            	<input type="radio" name="hand" value="1" autocomplete="off" checked> 1 Hand
                            </label>
                            <label class="btn btn-warning">
                           		<input type="radio" name="hand" value="2" autocomplete="off"> 2 Hands
                            </label>
                            <label class="btn btn-warning">
                            	<input type="radio" name="hand" value="3" autocomplete="off"> 3 Hands
                            </label>
                        </div>
                        <br>
                        <div class="btn-group btn-group-toggle form-group" data-toggle="buttons">
                            <label class="btn btn-warning active">
                            	<input type="radio" name="deck" value="1" autocomplete="off" checked> 1 deck
                            </label>
                            <label class="btn btn-warning">
                           		<input type="radio" name="deck" value="2" autocomplete="off"> 2 decks
                            </label>
                            <label class="btn btn-warning">
                            	<input type="radio" name="deck" value="3" autocomplete="off"> 3 decks
                            </label>
                        </div>                                                            
                        <div class="form-group text-center pt-3">
                        	<input type="submit" name="submit" class="btn btn-warning btn-md w-25" value="submit">
                        </div>                                
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php';?>