<?php

$showError = false;
$showAlert = false;

if (isset($_POST['signup'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $cpassword = $_POST['cpassword'];
  $email = $_POST['email'];

  $select_email = "select * from users where email = '$email'";
  $email_exists = mysqli_query($conn, $select_email);

  if (mysqli_num_rows($email_exists) > 0) {
    $showError = "Email Already Exists";
  } else {
    if ($password == $cpassword) {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $insert = "insert into users (username, email,password) values ('$username', '$email','$hash')";
      $result = mysqli_query($conn, $insert);
      if ($result) {
        $showAlert = "User Added Successfully";
      } else {
        $showError = "Failed to Register";
      }
    } else {
      $showError = "Password is not match";
    }
  }

}
?>

<style>
  #signupModal .form-control {
    background-color: gray;
  }

  #signupModal .form-control {
    border: none;
  }

  #signupModal .form-control:focus {
    background-color: gray;
    box-shadow: 0 0 0 0;
    border-color: transparent;
  }

  #signupModal .modal-header {
    border-bottom: 1px solid gray;
  }

  #signupModal .modal-footer {
    border-top: 1px solid gray;
  }

  #signupModal .modal-content {
    background-color: transparent;
  }
</style>

<!-- Modal -->
<div class="modal fade" id="signupModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="signupModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h1 class="modal-title fs-5 fw-bold text-light" id="signupModalLabel">Signup to iDiscuss Account</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="" class="">
        <div class="modal-body bg-dark text-secondary">
          <div class="mb-3 col-12">
            <label for="username" class="form-label">Username</label>
            <input type="text" maxlength="11" class="form-control" id="username" name="username">
          </div>
          <div class="mb-3 col-12">
            <label for="email" class="form-label">Email</label>
            <input type="email" maxlength="23" class="form-control" id="email" name="email">
          </div>
          <div class="mb-3 col-12">
            <label for="password" class="form-label">Password</label>
            <input type="password" maxlength="23" class="form-control" id="password" name="password">
          </div>
          <div class="mb-3 col-12">
            <label for="cpassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="cpassword" name="cpassword"
              aria-describedby="CpasswordHelp">
            <div id="CpasswordHelp" class="form-text">Make sure to type the same password.</div>
          </div>

        </div>
        <div class="modal-footer bg-dark">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="signup" class="btn btn-outline-primary">Sign Up</button>
        </div>
      </form>
    </div>
  </div>
</div>