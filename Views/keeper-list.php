<?php  include('header.php'); ?>

<form action="<?php echo FRONT_ROOT."Home/showKeeperList" ?>" method="get">
      <h1>List of Keepers registered</h1>
        <table class="table">
          <thead>
            <tr>
              <th style="width: 15%;">Username</th>
              <th style="width: 30%;">Name</th>
              <th style="width: 30%;">Compensation</th>
              <th style="width: 15%;">Size Accepted</th>
              <th style="width: 10%;">Availability</th>
            </tr>
          </thead>
          <tbody>
            <?php  foreach($keeperList as $keeper){     
                ?>
              <tr>
                <td class="first-td">  <?php echo $keeper->getUsername();             ?></td>
                <td>  <?php echo $keeper->getName();                 ?></td>
                <td>  <?php echo $keeper->getCompensation();         ?></td>
                <td>  <?php echo $keeper->getPetType();              ?></td>
                <td>  <?php print_r($keeper->getAvailabilityList()); ?></td>
              </tr>
            <?php  };  ?>

          </tbody>
        </table>
      </form> 

   <div class="container">
    <br>
    <a  href="<?php echo FRONT_ROOT.'Home/showHomeView'?>"><button class="medium-button">go back</button></a>
  </div>


<?php    include('footer.php'); ?>