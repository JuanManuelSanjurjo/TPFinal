<?php
namespace Models;



class Owner extends User{
    private $petList=[];    /// OBJETOS PET (GATO O PERRO)

    public function getPetList()
    {
        return $this->petList;
    }

    public function setPetList($petList)
    {

        $this->petList = $petList;
        return $this;
    }
}

?>