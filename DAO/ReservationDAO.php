<?php
namespace DAO;

//use Models\Keeper as Keeper;
//use Models\Owner as Owner;
//use Models\User as User;
//use Models\Pet as Pet;
use Models\Reservation as Reservation;
use DAO\Connection as Connection;
use DAO\OwnerDAO as OwnerDAO;
use DAO\KeeperDao as KeeperDao;
use DAO\PetDao as PetDao;


use Exception;

class ReservationDAO{
   
    private $connection;
    private $tableName = "reservation";

    public function makeReservation(Reservation $reservation)
    {
        try{
            $query = "INSERT INTO ".$this->tableName." (reservationNumber, owner, keeper, compensation, dateStart, dateEnd, pet, confirmation, payment) VALUES (:reservationNumber, :owner, :keeper, :compensation, :dateStart, :dateEnd, :pet, :confirmation, :payment)";

            $parameters["reservationNumber"]= $reservation->getReservationNumber();
            $parameters["owner"]            = $reservation->getOwner()->getId();
            $parameters["keeper"]           = $reservation->getKeeper()->getId();
            $parameters["dateStart"]        = $reservation->getDateStart();
            $parameters["dateEnd"]          = $reservation->getDateEnd();
            $parameters["compensation"]     = $reservation->getCompensation();  // no pone
            $parameters["pet"]              = $reservation->getPet()->getId();
            $parameters["confirmation"]     = $reservation->getConfirmation();
            $parameters["payment"]     = $reservation->getPayment();
            
            
            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query,$parameters);
        }catch(Exception $ex){
            throw $ex;
        } 

    }

    public function getAll()
    {
        try{
            
            $reservationList = array();
            $query= "SELECT reservationNumber, owner, keeper, compensation, dateStart, dateEnd, pet, confirmation, payment FROM ".$this->tableName;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query);

            foreach($result as $row)
            {
                $reservation = new Reservation();
                $reservation->setPayment($row["payment"]);
                $reservation->setReservationNumber($row["reservationNumber"]);
                $reservation->setConfirmation($row["confirmation"]);

                // set owner id
                $ownerDAO = new OwnerDAO();
                $owner=$ownerDAO->getById($row["owner"]);
                $reservation->setOwner($owner);
                // set keeper id
                $keeperDAO= new KeeperDao();
                $keeper = $keeperDAO->getById($row["keeper"]); ///Hacerla en el keeper
                $reservation->setKeeper($keeper);
                
                $reservation->setCompensation($row["compensation"]);
                $reservation->setDateStart($row["dateStart"]);
                $reservation->setDateEnd($row["dateEnd"]);
                // set pet id
                $petDao = new PetDao();
                $pet = $petDao->getById($row["pet"]);
                $reservation->setPet($pet);


                array_push($reservationList,$reservation);
            }

            return $reservationList;
        }catch(Exception $ex){
            throw $ex;
        }

    }


    public function Remove($id)
    {
        try{
        $query= "DELETE FROM ".$this->tableName." WHERE (id = :id)";

        $parameters["id"] = $id;

        $this->connection = Connection::GetInstance();

        $this->connection->ExecuteNonQuery($query,$parameters);
        }catch(Exception $ex){
            throw $ex;
        }
    }

    public function getReservationByKeeper($keeperID){
        
       try{

        $query= "SELECT reservationNumber, owner, keeper, compensation, dateStart, dateEnd, pet, confirmation, payment FROM ".$this->tableName." WHERE (keeper = :keeperID)";

        $this->connection = Connection::GetInstance();

        $result = $this->connection->Execute($query);

        foreach($result as $row)
         {
             $reservation = new Reservation();
             $reservation->setReservationNumber($row["reservationNumber"]);
             $reservation->setPayment($row["payment"]);
             $reservation->setConfirmation($row["confirmation"]);

             // set owner id
             $ownerDAO = new OwnerDAO();
             $owner=$ownerDAO->getById($row["owner"]);
             $reservation->setOwner($owner);
             // set keeper id
             $keeperDAO= new KeeperDao();
             $keeper = $keeperDAO->getById($row["keeper"]); ///Hacerla en el keeper
             $reservation->setKeeper($keeper);
             
             $reservation->setCompensation($row["compensation"]);
             $reservation->setDateStart($row["dateStart"]);
             $reservation->setDateEnd($row["dateEnd"]);
             // set pet id
             $petDao = new PetDao();
             $pet = $petDao->getById($row["pet"]);
             $reservation->setPet($pet);

             
         }
            
        return $reservation;
                
       }catch(Exception $ex){
            throw $ex;
       }

       
    }

    
    public function getAllReservationsById($keeperID){
        
        try{
            
            $reservationList = array();
            $query= "SELECT reservationNumber, owner, keeper, compensation, dateStart, dateEnd, pet, confirmation, payment FROM ". $this->tableName ." WHERE (keeper =" . $keeperID .");";
                       
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);
            
            foreach($result as $row)
            {
                $reservation = new Reservation();
                $reservation->setReservationNumber($row["reservationNumber"]);
                $reservation->setPayment($row["payment"]);
                $reservation->setConfirmation($row["confirmation"]);

                // set owner id
                $ownerDAO = new OwnerDAO();
                $owner=$ownerDAO->getById($row["owner"]);
                $reservation->setOwner($owner);
                // set keeper id
                $keeperDAO= new KeeperDao();
                $keeper = $keeperDAO->getById($row["keeper"]); ///Hacerla en el keeper
                $reservation->setKeeper($keeper);
                
                $reservation->setCompensation($row["compensation"]);
                $reservation->setDateStart($row["dateStart"]);
                $reservation->setDateEnd($row["dateEnd"]);
                // set pet id
                $petDao = new PetDao();
                $pet = $petDao->getById($row["pet"]);
                $reservation->setPet($pet);

                
                array_push($reservationList,$reservation);
            }
                        
            return $reservationList;
        }catch(Exception $ex){
            throw $ex;
        }
        
        
    }


    
    public function getAllOwnerReservationsById($ownerId){
        
        try{
            
            $reservationList = array();
            $query= "SELECT reservationNumber, owner, keeper, compensation, dateStart, dateEnd, pet, confirmation, payment FROM ". $this->tableName ." WHERE (owner =" . $ownerId .");";
                       
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);
            
            foreach($result as $row)
            {
                $reservation = new Reservation();
                $reservation->setReservationNumber($row["reservationNumber"]);
                $reservation->setPayment($row["payment"]);
                $reservation->setConfirmation($row["confirmation"]);

                // set owner id
                $ownerDAO = new OwnerDAO();
                $owner=$ownerDAO->getById($row["owner"]);
                $reservation->setOwner($owner);
                // set keeper id
                $keeperDAO= new KeeperDao();
                $keeper = $keeperDAO->getById($row["keeper"]); ///Hacerla en el keeper
                $reservation->setKeeper($keeper);
                
                $reservation->setCompensation($row["compensation"]);
                $reservation->setDateStart($row["dateStart"]);
                $reservation->setDateEnd($row["dateEnd"]);
                // set pet id
                $petDao = new PetDao();
                $pet = $petDao->getById($row["pet"]);
                $reservation->setPet($pet);

                
                array_push($reservationList,$reservation);
            }
                        
            return $reservationList;
        }catch(Exception $ex){
            throw $ex;
        }
        
        
    }
    
    public function setConfirmation ($reservationId, $confirmation){
        try{  
            $query= "UPDATE ".$this->tableName." SET confirmation = :confirmation WHERE (reservationNumber = ". $reservationId .")";
                  
            $parameters["confirmation"] = $confirmation;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
    
            // TRATAR DE MAndarlo a controladora
            $keeperDAO = new KeeperDao();
            $user = $_SESSION["loggedUser"];
            $_SESSION["loggedUser"] = $keeperDAO->getById($user->getId());
                 
            }
            catch(Exception $ex){
                throw $ex;
            }
    }

    public function getReservationById($reservationNumber){
        
        try{
        
         $query= "SELECT reservationNumber, owner, keeper, compensation, dateStart, dateEnd, pet, confirmation, payment FROM ".$this->tableName." WHERE (reservationNumber = ".$reservationNumber.")";
 
         $this->connection = Connection::GetInstance();
 
         $result = $this->connection->Execute($query);
 
         foreach($result as $row)
         {
             $reservation = new Reservation();
             $reservation->setReservationNumber($row["reservationNumber"]);
             $reservation->setPayment($row["payment"]);
             // set owner id
             $ownerDAO = new OwnerDAO();
             $owner=$ownerDAO->getById($row["owner"]);
             $reservation->setOwner($owner);
             // set keeper id
             $keeperDAO= new KeeperDao();
             $keeper = $keeperDAO->getById($row["keeper"]); ///Hacerla en el keeper
             $reservation->setKeeper($keeper);
             
             $reservation->setCompensation($row["compensation"]);
             $reservation->setDateStart($row["dateStart"]);
             $reservation->setDateEnd($row["dateEnd"]);
             // set pet id
             $petDao = new PetDao();
             $pet = $petDao->getById($row["pet"]);
             $reservation->setPet($pet);

             $reservation->setConfirmation($row["confirmation"]);
             
         }
                     
         return $reservation;
         
     }catch(Exception $ex){
         throw $ex;
     }
 
        
     }


     
    public function updatePayment($payment, $reservationNumber){

        try{  
    
            $query= "UPDATE ".$this->tableName." SET payment = :payment WHERE (reservationNumber = ". $reservationNumber .")";
                  
            $parameters["payment"]= $payment;
                
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters);
    
            }
        catch(Exception $ex){
            throw $ex;
        }


    }

    public function getReservationPetId($pet){
        
        try{
            
            $reservationList = array();
            $query= "SELECT reservationNumber, owner, keeper, compensation, dateStart, dateEnd, pet, confirmation, payment FROM ". $this->tableName ." WHERE (pet =" . $pet .");";
                       
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);
            
            foreach($result as $row)
            {
                $reservation = new Reservation();
                $reservation->setReservationNumber($row["reservationNumber"]);
                $reservation->setPayment($row["payment"]);
                $reservation->setConfirmation($row["confirmation"]);

                // set owner id
                $ownerDAO = new OwnerDAO();
                $owner=$ownerDAO->getById($row["owner"]);
                $reservation->setOwner($owner);
                // set keeper id
                $keeperDAO= new KeeperDao();
                $keeper = $keeperDAO->getById($row["keeper"]); ///Hacerla en el keeper
                $reservation->setKeeper($keeper);
                
                $reservation->setCompensation($row["compensation"]);
                $reservation->setDateStart($row["dateStart"]);
                $reservation->setDateEnd($row["dateEnd"]);
                // set pet id
                $petDao = new PetDao();
                $pet = $petDao->getById($row["pet"]);
                $reservation->setPet($pet);

                
                array_push($reservationList,$reservation);
            }
                        
            return $reservationList;
        }catch(Exception $ex){
            throw $ex;
        }
        
        
    }

    
}

?>