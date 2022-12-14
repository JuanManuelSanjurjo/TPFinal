<?php  include('header.php'); ?>
<?php  include('nav-bar.php'); ?>

  <div class="">
      <h1> WELCOME KEEPER </h1>
  </div>

  <!-- PARA USUARIO KEEPER   HAY QUE DIVIDIRLO -->  
  <div class="container">
    <p class="p-text">Indicate Availability</p>
      <form action="<?php echo FRONT_ROOT."Keeper/addAvilability"?>" method="post"> 
          <p class="p-text" style="position:relative; right:5%">Select start of period</p><p class="p-text" style="position:relative; left:5%">Select end of period</p>
          <br>
          <input type="date" style="width: 25%;" min="<?php getdate() ?>" id="Dates" name="dateStart" placeholder="Select start of period" multiple="true" />
          <input type="date" style="width: 25%;" min="<?php getdate() ?>" id="Dates" name="dateEnd" placeholder="Select end of period" multiple="true" />
          <button type="submmit" class="large-button">Update Availability</button>
      </form>
  </div>

  <div class="container">
    <p class="p-text">Show availabilities</p>
      <form action="<?php echo FRONT_ROOT."Keeper/showAvailabilities"?>" method="post"> 
      <button type="submmit" class="large-button">Show</button>  
    </form>
  </div>


  <div class="container" >
    <p class="p-text">Reservations</p>
      <form style="margin-right: 0px" action="<?php echo FRONT_ROOT."Reservation/showHistoricReservations"?>" method="post"> 
          <button type="submmit" class="large-button">History</button>  
      </form>
      <form action="<?php echo FRONT_ROOT."Reservation/showReservationToMake"?>" method="post"> 
          <button type="submmit" class="large-button">Pending</button>  
      </form>
      <form action="<?php echo FRONT_ROOT."Chat/showChatList"?>" method="post"> 
          <button type="submmit" class="large-button">Chats</button>  
      </form>
  </div>


  <div class="container">
    <p class="p-text">Set your compensation per day</p>
      <form action="<?php echo FRONT_ROOT."Keeper/setCompensation"?>" method="post"> 
      <input type="number" placeholder="Set your Fee" min="1" name="compensation" id="Compensation" required>

      <button type="submmit" class="medium-button">Set Fee</button>  
    </form>
  </div>

  <div class="container">
    <p class="p-text">Set pets you are willing to take care</p>
      <form action="<?php echo FRONT_ROOT."Keeper/showTypeOfPet"?>" method="post"> 
          <button type="submmit" class="large-button">Set Preferences</button>
      </form>
  </div>


  <!-- LOG OUT LOG OUT LOG OUT -->
  <div class="container">
    <p class="p-text">Log Out</p>
      <form action="<?php echo FRONT_ROOT."Home/logout"?>" method="post"> 
          <button type="submmit" class="large-button">Log Out</button>
      </form>
  </div>


<?php    include('footer.php'); ?>

