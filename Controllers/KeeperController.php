<?php

namespace Controllers;

use DAO\KeeperDAO;
use DAO\AvailabilityDAO as AvailabilityDAO;
use DAO\ReservationDAO;
use Models\Keeper;
use Models\TimeInterval as TimeInterval;

class KeeperController{
    private $KeeperDao;
    private $ReservationDAO;

    function __construct(){
        $this->KeeperDao = new KeeperDAO();
        $this->ReservationDAO = new ReservationDAO();
    }

    public function keeperExist($email){
        $keeper = $this->KeeperDao->getByEmail($email);        
        return $keeper;
    }

    public function showKeeperList(){
        $keeperList = $this->KeeperDao->getAll();
        $owner = $_SESSION["loggedUser"];
        $petList = $owner->getPetList();
        require_once(VIEWS_PATH."validate-session.php");
        require_once(VIEWS_PATH."keeper-list.php");
    }
    
    public function showFilteredKeepers($pet,$dateStart,$dateEnd){        // filtro tambien por RESERVATION
        $date1=date_create($dateStart);
        $date2=date_create($dateEnd);
        $today = date_create();
        $diff = $today;
        
        $selectedPet = $pet; 

        $keeperList = $this->KeeperDao->getAll(); 
        $owner = $_SESSION["loggedUser"];
        $petList = $owner->getPetList();
        $reservation=$this->ReservationDAO->getReservationPetId($pet);
        $flag = true;
        foreach($reservation as $row){
            if(($dateStart >=  $row->getDateStart() && $dateStart <= $row->getDateEnd()) || ($dateEnd >=  $row->getDateStart() && $dateEnd <= $row->getDateEnd()) ||  ($dateStart <= $row->getDateStart() && $dateEnd >= $row->getDateEnd())){
                HomeController::showMessage("There is an overlap with the dates you booked a reservation. The pet already has a reservation for that period");
                $this->showKeeperList();
                $flag=false;
            }
        }
        if($flag==true){
            if($date1->format("Y-m-d") > $date2->format("Y-m-d") ){
                HomeController::showMessage("End date cant be less than start date.");   
                $this->showKeeperList();
            }elseif($date1->format("Y-m-d") < $today->format("Y-m-d") ){
                HomeController::showMessage("Cant set dates in the past.");
                $this->showKeeperList();
            }else{
                $diff=date_diff($date1,$date2);
                $keeperList = $this->KeeperDao->getFilteredList($pet,$dateStart,$dateEnd); // hacer filtro en DAO O CONTROLLER
                 require_once(VIEWS_PATH."validate-session.php");
                 require_once(VIEWS_PATH."filter-Keepers.php");
            }
        }
    }


    public function showTypeOfPet(){
        if(isset($_SESSION["loggedUser"])){
            require_once(VIEWS_PATH."type-pets.php");
        }else{
            $home = new HomeController(); // aca o en el contructor?
            $home->Index();
        }
    }

    public function setPetType($size){
       $keeper = $_SESSION["loggedUser"];
       $keeperId = $keeper->getId();
       $this->KeeperDao->setPetType($size, $keeperId);
       $_SESSION["loggedUser"] = $this->KeeperDao->getById($keeperId);

       if(isset($_SESSION["loggedUser"])){
            $this->showHomeView("Preferences set");
       }else{
            $home = new HomeController(); // aca o en el contructor?
            $home->Index();
       }
    }

    public function setCompensation($compensation){
        $keeper = $_SESSION["loggedUser"];
        $keeperId = $keeper->getId();
        $this->KeeperDao->setCompensation($compensation, $keeperId);
        $_SESSION["loggedUser"] = $this->KeeperDao->getById($keeperId);

        $this->showHomeView("Compensation set");
    }

    public function addAvilability ($dateStart,$dateEnd){  // va a otra tabla de DISPONIBILIDADES
        $date = $this->checkDate($dateStart,$dateEnd);
        $exist=$this->dateAlreadyExist($date);
        
        if($date && !$exist){
            $this->KeeperDao->addAvilability($date);
            $keeper = $_SESSION["loggedUser"];
            $_SESSION["loggedUser"] = $this->KeeperDao->getById($keeper->getId());
            $this->showHomeView("Dates uploaded succesfully");   
        }
    }

    public function checkDate ($dateStart,$dateEnd){
        $date1=date_create($dateStart)->format("Y-m-d");
        $date2=date_create($dateEnd)->format("Y-m-d");
        $today = date_create()->format("Y-m-d");

        if($date1 > $date2 ){
            $this->showHomeView("End date cant be less than start date");   
        }elseif($date1 < $today  || $date2 < $today){
            $this->showHomeView("Cant set dates in the past");  
        }else{
            $user = $_SESSION["loggedUser"];
            $date = new TimeInterval();
            $date->setStart($date1);
            $date->setEnd($date2);
            $date->setIdKeeper($user->getId());

            return $date;
        }
        return false;
    }
 /*
    public function dateIsInInterval(TimeInterval $interval , $date){
        
        if($date >= $interval->getStart() && $date <= $interval->getEnd() ){
            return true;
        }
        return false;
    }   
*/
    public function dateAlreadyExist (TimeInterval $date){

        $keeper=$_SESSION["loggedUser"];
        $exist=false;
        $List=$keeper->getAvailabilityList();
        
        foreach($List as $inter){
            $dateStart= $inter->getStart();
            $dateEnd=  $inter->getEnd();
            if($date->getStart()==$dateStart && $date->getEnd()==$dateEnd){
                $this->showHomeView("interval of time already exist");
                $exist=true;
            }
        }
        return $exist;
    }

    public function showHomeView($message = ""){
        if($message){
            HomeController::showMessage($message);
        }
        require_once(VIEWS_PATH."validate-session.php");
        require_once(VIEWS_PATH."home-keeper.php");
    }

    public function showAvailabilities(){
        $user = $_SESSION["loggedUser"];
        $availabilityList = $user->getAvailabilityList();
        require_once(VIEWS_PATH."validate-session.php");
        require_once(VIEWS_PATH."availability-list.php");
    }

    public function removeAvailability($availabilityId){
        $AvailabilityDAO = new AvailabilityDAO();
        if($AvailabilityDAO->remove($availabilityId)){
            $message = "Avalability cancelled";
        }else{
            $message = "An error accurred removing this availability";
        }
        $keeper = $_SESSION["loggedUser"];
        $_SESSION["loggedUser"] = $this->KeeperDao->getById($keeper->getId());

        $this->showHomeView($message);

    }   


    public function register($email, $name, $surname, $pass, $userName, $userType){

        $user = new Keeper();   

        $user->setMail($email);
        $user->setPassword($pass);
        $user->setUserName($userName);
        $user->setName($name);
        $user->setSurname($surname);
        $user->setUserType($userType);
        $user->setPetType("small");
        
                
        $_SESSION["loggedUser"]= $user; 
        
        $this->KeeperDao->register($user);

    }

    





}

?>