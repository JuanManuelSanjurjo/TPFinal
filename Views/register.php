<?php require 'header.php'; ?>


<form action="<?php echo FRONT_ROOT."Home/register"?>">
  <div class="container">
    <h1>Register</h1>
    <p>Please fill in this form to create an account.</p>

    <label for="email"><b></b></label>
    <input type="email" placeholder="Enter Email" name="email" id="email" required>
    <br>
    <label for="name"><b></b></label>
    <input type="text" placeholder="Enter your name" name="name" id="Name" required>
    <br>
    <label for="surname"><b></b></label>
    <input type="text" placeholder="Enter your surname" name="surname" id="Surname" required>
    <br>
    <label for="psw"><b></b></label>
    <input type="password" placeholder="Enter Password" name="pass" id="psw" required>
    <br>
    <label for="psw-repeat"><b></b></label>
    <input type="password" placeholder="Repeat Password" name="pass-repeat" id="passRepeat" required>
    <hr>
    <label for="userName"><b></b></label>
    <input type="text" placeholder="Set your username" name="userName" id="user-name" required>
    <br>
    <br>
    <br>
    <p class="p-text"> How do you want to register as?</p>
    <br>
    <input type="radio" name="userType" id="owner" required > <p class="p-text">Owner</p>  
    <input type="radio" name="userType" id="keeper" required> <p class="p-text" >Keeper</p>  
    <br>
    <br>

    

    <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>

    <button type="submit" class="login-button">Register</button>
  </div>
  
  <div class="container signin">
    <p class="p-text">Already have an account? <a href="<?php echo FRONT_ROOT.'Home/index'?>">Sign in</a>.</p>
  </div>
</form>




<?php require 'footer.php'; ?>