<?php  include('header.php'); ?>
<!-- <?php  include('nav-bar.php'); ?> -->

<div class="container">
  <form action="<?php echo FRONT_ROOT."Keeper/showFilteredKeepers"?>" method="post" style="background: linear-gradient( #fdc36b, #e08b3b);"> 
  <p class="p-text">Select your pet</p>
  <select class="dog-select" style="width: 15%"   name="pet" id="role" required>
    <?php foreach($petList as $pet){ ?>
      <option value="<?php echo $pet->getId()?>" > <?php echo $pet->getName()?> </option> <!-- echo $pet["id"] -->
      <?php  }  
      ?>
    </select>
    <p class="p-text">Select start of period</p>
    <input type="date" style="width: 15%;" min="<?php getdate() ?>" id="Dates" name="dateStart" placeholder="Select start of period" multiple="true" required />
    <p class="p-text" >Select end of period</p>
    <input type="date" style="width: 15%;" min="<?php getdate() ?>" id="Dates" name="dateEnd" placeholder="Select end of period" multiple="true" required />
    <button type="submmit" class="large-button" style="width: 15%; margin-left: 2rem">Filter</button>
  </form>
</div>

<h1>List of available keepers</h1>
<table class="table">
          <thead>
            <tr>
              <th style="width: 15%;">Username</th>
              <th style="width: 30%;">Name</th>
              <th style="width: 30%;">Compensation</th>
              <th style="width: 30%;">Total</th>
              <th style="width: 15%;">Pets Accepted</th>
              <th style="width: 15%;">Book</th>
            </tr>
          </thead>
          <tbody>
            <?php  foreach($keeperList as $keeper){     
              ?>
              <tr>
                <form action="<?php echo FRONT_ROOT."Reservation/makeReservation"?>"> <!-- cambiar el CONTROLLER -->
                <td class="first-td">  <?php echo $keeper->getUsername();     ?></td>
                <td>  <?php echo $keeper->getName() .' '. $keeper->getSurname();  ?></td>
                <td>  <?php if($keeper->getCompensation()==null){
                            echo "not updated";
                            }else{
                              echo '$' . $keeper->getCompensation() . ' / day';  
                            }
                 ?>
               </td>                
               <td>  <?php echo "$ ". (int) $diff->format("%d%") * $keeper->getCompensation() ;    ?> </td>
               <td>  <?php echo $keeper->getPetType()." dogs or cats";   ?></td>             
               <td>
                 <input type="hidden" name="pet" value="<?php echo $selectedPet; ?>">
                 <input type="hidden" name="owner" value="<?php echo $owner->getId(); ?>">
                 <input type="hidden" name="keeper" value="<?php echo $keeper->getId(); ?>">
                 <input type="hidden" name="dateStart" value="<?php echo $dateStart ?>">
                 <input type="hidden" name="dateEnd" value="<?php echo $dateEnd ?>">
                      
                 <button type="submmit" value="confirm" class="large-button">Book keeper</button>
                </td>
                </form>
                </tr>
                <?php  };  ?>

          </tbody>
        </table>


 <div class="container">
    <br>
    <a  href="<?php echo FRONT_ROOT.'Owner/showHomeView'?>"><button class="medium-button">Home</button></a>
  </div>





  <?php    include('footer.php'); ?>