<?php
namespace Controllers;

use Models\Keeper as Keeper;
use Models\Owner as Owner;
use DAO\OwnerDAO as OwnerDAO;
use DAO\KeeperDAO as KeeperDao;


class HomeController{
    private $OwnerDAO;  
    private $KeeperDao;  

    function __construct(){ 
        $this->OwnerDAO = new OwnerDAO();
        $this->KeeperDao = new KeeperDao();
        
    }

    public function register($email, $name, $surname, $pass, $repeatPass, $userName, $userType){

        $user = $this->userExist($email);

        if(!$this->confirmPassword($pass, $repeatPass)){ 
            $this->showRegisterView("Passwords dont match, try again"); 
        }else if($user){ 
            session_destroy(); 
            $this->showRegisterView("There isalready a user registered with this email");
        }
        else{
            if(!$this->checkMail($email)){ 
                session_destroy(); 
                $this->showRegisterView("Provide a valid email adress format"); 
            }else if(!$this->checkPassword($pass)){ 
                session_destroy(); 
                $this->showRegisterView("Your password must include a minimum of 8 characters, one uppercase, one lowercase and one number to be valid"); 
            }else{
                if($userType == "keeper"){
                    $keeperController = new KeeperController();
                    $keeperController->register($email, $name, $surname, $pass, $userName, $userType);
                    $this->logout("User registered succesfully");
                }else{
                    $OwnerController = new OwnerController();
                    $OwnerController->register($email, $name, $surname, $pass, $userName, $userType);
                    $this->logout("User registered succesfully");
                }
                
            }
        }  
    }

    public function checkMail($email){
        $regexEmail = "/^([a-z\\d\\._-]{1,30})@([a-z\\d_-]{2,15})\\.([a-z]{2,8})(\\.[a-z]{2,8})?$/";
        if(preg_match($regexEmail,$email)){
            return true;
        }
        return false;
    }
    public function checkPassword($password){
        $regexPassword = "/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=\\S+$).{8,15}$/";
        if(preg_match($regexPassword,$password)){
            return true;
        }
        return false;
    }

    public function confirmPassword($pass,$repeat){
        if($pass === $repeat){
            return true;
        }
        return false;
    }

    public function Index($message = "")
    {
        if($message){
            HomeController::showMessage($message);
        }
        require_once(VIEWS_PATH."login.php");
    }        

    public function userExist($email){
        $keeperController = new KeeperController();
        $ownerController = new OwnerController();

        $keeper = $keeperController->keeperExist($email);
        $owner = $ownerController->ownerExist($email);

        if($keeper != null){
            return $keeper;
        }else if($owner != null){
            return $owner;
        }else{
            return null;
        }
    }

    public function login($email,$pass){

        $user = $this->userExist($email);
        if($user!=null && $user->getPassword() == $pass){
            $_SESSION["loggedUser"]= $user; 
            
            if($user instanceof Keeper){
                $keeperC = new KeeperController();
                $keeperC->showHomeView();
            }else if($user instanceof Owner){
                $OwnerC = new OwnerController();
                $OwnerC->showHomeView();
            }
        }else{
            session_destroy(); 
            $this->Index("Credentials dont match, try again");
        }
    }


    public function logout($message = "Logged out, thank you for using Pet Hero"){
        session_destroy();
        $this->Index($message);
    }
   
    public function showRegisterView($message = ""){
        if($message){
            HomeController::showMessage($message);
        }
        require_once(VIEWS_PATH."register.php");
    }

    public static function showMessage($message){
        echo "<div class='message'>  <p>";
            echo $message;
            "</p>";       
        echo   "</div>";
    }

}   
    
?>