<?php  include('header.php'); ?>
 <?php  include('nav-bar.php'); ?>

  <div class="">
      <h1> WELCOME OWNER </a></h1>
  </div>


<!-- PARA USUARIO OWNER -->
  <div class="container">
      <form action="<?php echo FRONT_ROOT."Owner/showMyPetList"?>" method="post">    <!-- cambiar el CONTROLLER -->
          <button type="submmit" class="large-button">My pets</button>
      </form>
  </div>

  <div class="container">
      <form action="<?php echo FRONT_ROOT."Reservation/getAllOwnerReservationsById"?>" method="post"> <!-- cambiar el CONTROLLER -->
          <button type="submmit" class="large-button">Show my reservations</button>
      </form>
  </div>

  <div class="container">
  <form action="<?php echo FRONT_ROOT."Chat/showChatList"?>" method="post"> 
          <button type="submmit" class="large-button">Chats</button>  
      </form>
  </div>
 

  <div class="container">
      <form action="<?php echo FRONT_ROOT."Owner/showAddPet"?>" method="post"> <!-- cambiar el CONTROLLER -->
          <button type="submmit" class="large-button">Add Pet</button>
      </form>
  </div>

  <div class="container">
      <form action="<?php echo FRONT_ROOT."Keeper/showKeeperList"?>" method="post"> <!-- cambiar el CONTROLLER -->
          <button type="submmit" class="large-button">Make Reservation</button>
      </form>
  </div>
  
  <!-- LOG OUT / go back -->

  <div class="container">
    <p class="p-text">Log Out</p>
      <form action="<?php echo FRONT_ROOT."Home/logout"?>" method="post"> 
          <button type="submmit" class="large-button">Log Out</button>
      </form>
  </div>


<?php    include('footer.php'); ?>

