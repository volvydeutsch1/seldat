<?php

class database{
    
    public function createPdo()
    {
        $host = 'localhost:81';
        $user = 'root';
        $password = '';
        $dbname = 'blackJack';
        // Set DSN
        $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;
        // Create a PDO instance
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $pdo;
    }
    
    public function insertIntoTable($username,$password)
    {
        $pdo=$this->createPdo();
        //table must be created with autoincrement functionality
        //ALTER TABLE credentials MODIFY COLUMN id INT auto_increment
        $sql = "INSERT INTO BlackJackGame (id, username, password) VALUES(:id, :username, :password)";
        $stmt = $pdo->prepare($sql);
        $success=$stmt->execute(['id' => NULL, 'username' => $username, 'password' => $password]);
        $pdo=null;
        // INSERT INTO table_name (name, group) VALUES ('my name', 'my group')
        return $success;
    }
    
    public function searchusername($username)
    {
        $pdo=$this->createPdo();
        
        $sql = "SELECT username FROM BlackJackGame WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        if($stmt->rowCount()>0){
            return true;
        }
        $pdo=null;
    }
    
    public function updateSet($username, $balance)
    {
        $pdo=$this->createPdo();
        //table must be created with autoincrement functionality
        //ALTER TABLE credentials MODIFY COLUMN id INT auto_increment
        $sql = "UPDATE BlackJackGame SET balance = balance + :balance WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $success=$stmt->execute(['username' => $username, 'balance' => $balance]);
        $pdo=null;
        // INSERT INTO table_name (name, group) VALUES ('my name', 'my group')
        return $success;
    }
    
    public function updateSetP($username, $password)
    {
        $pdo=$this->createPdo();
        //table must be created with autoincrement functionality
        //ALTER TABLE credentials MODIFY COLUMN id INT auto_increment
        $sql = "UPDATE BlackJackGame SET password = :password WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $success=$stmt->execute(['username' => $username, 'password' => $password]);
        $pdo=null;
        // INSERT INTO table_name (name, group) VALUES ('my name', 'my group')
        return $success;
    }
    
    public function checkLoginCredentials($username, $password)
    {
        $pdo = $this->createPdo();
        
        $stmt = $pdo->query('SELECT * FROM blackJackGame');
        $loginValid = false;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            
            $usernameDb = $row['username'];
            $passwordDb = $row['password'];
            
            if ($username === $usernameDb && $password === $passwordDb) {
                $loginValid = true;
                break;
            }
        }
        
        $pdo = null;
        return $loginValid;
    }
    
    public function balance($username)
    {
        $pdo = $this->createPdo();
        
        $sql = "SELECT balance FROM BlackJackGame WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        $pdo = null;
        $result = $stmt->fetch();
        return $result['balance'];
    }
    
    public function betControl($betAmount,$username,$hands)
    {
        $balance = $this->balance($username);
        try{
            if($balance < $betAmount * $hands){
                throw new Exception("your balance is to low:");
            }else{
                return true;
            }
        }catch(Exception $e){
            $error = $e->getMessage();
            return $error;
        }
    }
    
    public function updataWonLoss($username,$mp,$betAmount)
    {
        $pdo = $this->createPdo();
        $sql = "UPDATE BlackJackGame SET balance = balance $mp :betAmount WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username, 'betAmount' => $betAmount]);
        $pdo = null;
    }
}

class card{
    
    private $face;
    private $suit;
    
    public function __construct($face, $suit)
    {       
        $this->face = $face;
        $this->suit = $suit;
    }
    
    public function displayCard($faceUp = true)
    {       
        return '<img src="PNG/'.$this->face.$this->suit.'.png" width=100>';    
    }
    
    public function cardValue()
    {
        if(is_numeric($this->face)){
            return $this->face;
        }elseif($this->face == 'A'){
            return 11;
        }else{
            return 10;
        }
    }    
}

class game{
    
   private $player;
   private $deck;
   private $dealer;
   private $current = 1;
   
   public function __construct($hand)
   {
       $this->deck = new deak();
       //Self::$current = 1;
       for($i = 1;$i <= $hand;$i++){
           $this->player[$i] = new player();
       }
        $this->dealer = new dealer();
   }
   
   public function hand($hand)
   {    
       global $obj;
       echo "<div class=\"col-12 pt-4 pb-2\">
            <button type=\"button\" class=\"btn btn-warning mb-4\">
              Dealer <span class=\"badge badge-light\"><h5 class=\"m-0\">".$this->dealer->sum()."</h5></span>
            </button><br>".$this->dealer->displayAll()."</div>";
       if(!$this->dealer->ternLimit()){
          echo '<div class="col-md-6"><button class="w-25 btn btn-warning text-center" name="hit" type="submit">Hit</button></div>         
                <div class="col-md-6"><button class="w-25 btn btn-warning text-center" name="stand" type="submit">Stand</button></div>'; 
          
       }
       if(isset($_POST["split"])){
           
               $this->player[$_SESSION["hand"]] = new player();
               $this->player[$_SESSION["hand"]]->playerCards[] = array_shift($this->player[$this->getCurrent()]->playerCards);
               $this->player[$_SESSION["hand"]]->hit();
               $this->player[$this->getCurrent()]->hit();
           
       }
        for($i = 1;$i <= $hand;$i++){  
            
            echo "<div class=\"col-md pt-5\">
            <button type=\"button\" class=\"btn btn-warning mb-2\">
              Hand $i <span class=\"badge badge-light\"><h5 class=\"m-0\">".$this->player[$i]->sum()."</h5></span>
            </button><h5 class=\"text-danger\">";if($this->dealer->ternLimit()){$this->player[$i]->winner();}echo"</h5>".$this->player[$i]->displayAll()."</div>"; 
            
        }
        if($this->getCurrent() != "dealer" && $this->player[$this->getCurrent()]->split() && $obj->betControl($_SESSION["betAmount"],$_SESSION["username"],$_SESSION["hand"]+1)===true){
            echo '<div class="col-md-12"><button class="w-25 btn btn-warning text-center mt-5" name="split" type="submit">Split</button></div>';
        }
    }
    public function beginCard($hand)
    {
        for($i = 1;$i <= $hand;$i++){
            $this->player[$i]->hit();
            $this->player[$i]->hit();
        }
        $this->dealer->hit();
        $this->dealer->hit();
    }
    
    public function stand()
    {
        if($this->current < $_SESSION['hand']  && $this->current != "dealer"){
            $this->current++;
        }else{
            $this->current="dealer";
        }
    }
    
    public function getPlayer()
    {
        if($this->current == "dealer"){
            return $this->dealer;
        }else{
            return $this->player[$this->current];
        }
    }
    
    public function getDeck()
    {
        return $this->deck;
    }
    
    public function getCurrent()
    {
        return $this->current;
    }
    
    public function getDealer()
    {
        return $this->dealer;
    }
}

class player{
    
    public $playerCards;
    
    public function __construct()
    {
        $this->playerCards = array();       
    }
   
    public function hit()
    {
        $this->playerCards[] = array_shift($_SESSION['Game']->getDeck()->array);           
    }
    public function displayAll()
    {
        $cards="";
        for($i = 0;$i < count($this->playerCards);$i++){
            $cards.= $this->playerCards[$i]->displayCard();
        }
        if($this->bust()){
            $cards.= "<div class=' overlay text-danger'>Bust</div>";
        }        
        if($this->blackJack()){
            $cards.= "<div class='overlay text-success'>BlackJack</div>";
        }        
        return $cards;
    }
    public function sum()
    {
        $sum=0;
        $a=0;
        for ($i = 0; $i < count($this->playerCards); $i++) {
            $sum += $this->playerCards[$i]->cardValue();
            
            if($this->playerCards[$i]->cardValue() == 11){
                $a++;
            }
        }       
        while($a > 0 && $sum > 21){
            $sum-=10;
            $a--;
        }        
        return $sum;
    }
    
    public function bust()
    {
        if($this->sum() > 21  && $_SESSION['Game']->getPlayer() == $this){
            $_SESSION['Game']->stand();
        }
        if($this->sum() > 21){
            return true;
        }
    }
    
    public function blackJack()
    {
        if($this->sum() == 21  && $_SESSION['Game']->getPlayer() == $this && count($this->playerCards) == 2){
            $_SESSION['Game']->stand();           
        }
        if($this->sum() == 21 && count($this->playerCards) == 2){
            return true;
        }
    }
    
    public function winner()
    {
        global $obj;
        
        if($this->bust()){    
            
            echo "player lost";    
            $obj->updataWonLoss($_SESSION['username'],'-',$_SESSION["betAmount"]);
            
        }elseif($this->blackJack() && !$_SESSION['Game']->getDealer()->blackJack()){
            
            echo "player won";
            $obj->updataWonLoss($_SESSION['username'],'+',$_SESSION["betAmount"]);
            
        }elseif($this->sum() < $_SESSION['Game']->getDealer()->sum() && !$_SESSION['Game']->getDealer()->bust()){
            
             echo "dealer won";
             $obj->updataWonLoss($_SESSION['username'],'-',$_SESSION["betAmount"]);
             
        }elseif($_SESSION['Game']->getDealer()->bust() || $this->sum() > $_SESSION['Game']->getDealer()->sum()){
            
            echo "player won";
            $obj->updataWonLoss($_SESSION['username'],'+',$_SESSION["betAmount"]);
            
        }else{
            
            echo "push";
        }
    }
    public function split(){
        if($this->playerCards[0]->cardValue() == $this->playerCards[1]->cardValue()){
            return true;
        }
    }
    public function ifSplit(){
        
    }
}

class dealer extends player{
    
    public function displayAll()
    {
        if($_SESSION['Game']->getCurrent() != "dealer"){
            $cards='<img src="PNG/red_back.png" width=100>';
            for($i = 1;$i < count($this->playerCards);$i++){
                $cards.= $this->playerCards[$i]->displayCard();
            }
            if($this->bust()){
                $cards.= "Bust";
            }
            return $cards;
        }else{
            return parent::displayAll();
        }
    }
    
    public function sum()
    {
        if($_SESSION['Game']->getCurrent() != "dealer"){
            $sum=0;
            $a=0;
            for ($i = 1; $i < count($this->playerCards); $i++) {
                $sum += $this->playerCards[$i]->cardValue();
                
                if($this->playerCards[$i]->cardValue() == 11){
                    $a++;
                }
            }
            while($a > 0 && $sum > 21){
                $sum-=10;
                $a--;
            }
            return $sum;
        }else{
            return parent::sum();
        }
    }
    
    public function ternLimit()
    {
        if($this->sum() >= 17 || $this->sum() == 21 && count($this->playerCards) == 2){
            return true;            
        }
    }
}

class deak{
    
    public $array;
    
    public function __construct()
    {
        $this->array = array();
        for ($j = 0; $j < $_SESSION["deck"]; $j++) {                               
            $a='C';
            for($i = 0;$i < 9;$i++){
                
                $this->array[] = new card($i+2,'C');
                $this->array[] = new card($i+2,'D');
                $this->array[] = new card($i+2,'H');
                $this->array[] = new card($i+2,'S');
            }
            for($i = 0;$i < 4;$i++){
                if($i==1){
                    $a='D';
                }elseif($i==2){
                    $a='H';
                }else{$a='S';
                }
                $this->array[] = new card('A',$a);
                $this->array[] = new card('K',$a);
                $this->array[] = new card('Q',$a);
                $this->array[] = new card('J',$a);
            }
        }
            shuffle($this->array);                    
    }    
}
$obj = new database();
?>
