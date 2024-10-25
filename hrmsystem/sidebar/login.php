<!DOCTYPE html>
<html lang="en">
  <?php include './layout/head_login.php' ?>
<body>
<div class="container-fluid p-5 text-white text-center" >
  <!--<h1 class="text-shadow">School Management System</h1>-->
</div>
  
<div class="container mt-3 p-4 shadow rounded-4 w-25 bg-white text-black">
    <div class="container d-flex justify-content-center align-items-center full-height">
        <img src="./css/bcp_logo.png" alt="Logo" class="logo">
    </div>
    <div class="container text-black text-center">
        <h2>Sign in</h2>      
    </div>
  


  <form id="loginForm" class="py-2">
    <div class="mb-3 mt-3">
      <label for="email">Email:</label>
      <input type="email" class="form-control"  placeholder="Enter email" id="txt_username" name="email">
    </div>
    <div class="mb-3">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control"  placeholder="Enter password" id="txt_password" name="pswd">
    </div>

    <span class="text-danger fw-bold pt-0 d-none" id="span_error">Error Username and Password</span>

 
    <button type="submit" class="btn btn-primary w-100">Login</button>
  </form>




</div>

<?php include './layout/footer_login.php' ?>

</body>
</html>