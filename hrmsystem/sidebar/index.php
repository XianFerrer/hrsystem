<!DOCTYPE html>
<html lang="en">
  <?php include './layout/head.php' ?>
  <?php include './layout/sidebar_admin.php' ?>
<body>

<div class="container-fluid p-4 bg-white text-black text-center" class="navbar-brand" >
      <a>
        <img src="./css/bcp_logo.png" alt="Logo" class="logo">
        <h1>Student List of Graduates</h1>
      </a>
</div>

<div class="container mt-5 ">



  <div class="row">
    <div class="col-md-12  p-4 shadow">

    
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">Add Student</button>

    <table class="table table-striped">
    <thead>
      <tr>
        <th>Student ID</th>
        <th>Lastname</th>
        <th>Firstname</th>
        <th>Middlename</th>
        <th>Action</th>
        
      </tr>
    </thead>
    <tbody id="tbl_tbody">
      
    </tbody>
  </table>
    </div>
  </div>




  <!-- INSERT -->

<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Student</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <div class="container mt-5">
    <h2>Insert New Item</h2>
    <form id="insertStudent">
        <div class="form-group">
            <label for="student_id">Student ID</label>
            <input type="text" class="form-control" id="student_id">
        </div>
        <div class="form-group">
            <label for="student_lastname">Lastname</label>
            <input type="text" class="form-control" id="student_lastname" >
        </div>
        <div class="form-group">
            <label for="student_firstname">Firstname</label>
            <input type="text" class="form-control" id="student_firstname" >
        </div>
        <div class="form-group">
            <label for="student_middlename">Middlename</label>
            <input type="text" class="form-control" id="student_middlename" >
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <div id="responseMessage" class="mt-3"></div>
</div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


<!-- EDIT -->

<div class="modal" id="modalEdit">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Student</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <div class="container mt-5">
    <h2>Insert New Item</h2>
    <form id="insertStudent">
        <div class="form-group">
            <label for="student_id">Student ID</label>
            <input type="text" class="form-control" id="edit_student_id">
        </div>
        <div class="form-group">
            <label for="student_lastname">Lastname</label>
            <input type="text" class="form-control" id="edit_student_lastname" >
        </div>
        <div class="form-group">
            <label for="student_firstname">Firstname</label>
            <input type="text" class="form-control" id="edit_student_firstname" >
        </div>
        <div class="form-group">
            <label for="student_middlename">Middlename</label>
            <input type="text" class="form-control" id="edit_student_middlename" >
        </div>
        <button type="button" onclick="saveEdit()" class="btn btn-primary">Submit</button>
    </form>
    <div id="responseMessage" class="mt-3"></div>
</div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


 
</div>


<?php include './layout/footer.php' ?>

 
</body>
</html>