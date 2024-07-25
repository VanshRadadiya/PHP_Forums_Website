<?php 

$showAlert1 = false;
$showError1 = false;

if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $select_data = "SELECT * FROM `users` WHERE email = '$email'";
  $result = mysqli_query($conn, $select_data);

  if(mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_assoc($result)){
      if(password_verify($password, $row['password'])){
        $showAlert1 = "Login Successfull";
        $_SESSION['user_id'] = $row['users_id'];
        $_SESSION['loggedin'] = true;
        $_SESSION['user_email'] = $email;
        $_SESSION['username'] = $row['username'];
        header("Location:/PHP/forums_website/");
      }else{
        $showError1 = "Password is Wrong";
      }
    }
  }else{
    $showError1 = "Invalid Email";
  }
}

?>

<style>
  #loginModal .form-control{
    background-color: gray;
  }

  #loginModal .form-control{
    border: none;
  }

  #loginModal .form-control:focus{
    background-color: gray;
    box-shadow: 0 0 0 0;
    border-color: transparent;
  }

  #loginModal .modal-header{
    border-bottom: 1px solid gray;
  }

  #loginModal .modal-footer {
    border-top: 1px solid gray;
  }

  #loginModal .modal-content{
    background-color: transparent;
  }
</style>

<!-- Modal -->
<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-secondary">
        <h1 class="modal-title fs-5 fw-bold text-light" id="loginModalLabel">Login to iDiscuss Account</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="" class="text-secondary">
        <div class="modal-body bg-dark ">
          <div class="mb-3 col-12">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email">
          </div>
          <div class="mb-3 col-12">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
          </div>
        </div>
        <div class="modal-footer bg-dark">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="login" class="btn btn-outline-primary">Login</button>
        </div>
      </form>
    </div>
  </div>
</div>