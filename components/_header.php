<?php

// session_start();
include 'components/_dbConnection.php';

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $loggedin = true;
} else {
    $loggedin = false;
}

// if (isset($_GET['showAlert1'])) {
//     $showAlert1 = $_GET['showAlert1'];
// } else {
//     $showAlert1 = false;
// }

// unset($_GET['showAlert1']);


?>

<style>
    .navbar-toggler {
        border: 2px solid gray;
    }

    .nav-item .nav-link {
        color: gray !important;
    }

    .alert {
        position: absolute;
        top: 40px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 999;
        width: 500px;
    }
</style>

<nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="/PHP/forums_website/">iDiscuss</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/PHP/forums_website/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/PHP/forums_website/about.php">About</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Categories
                    </a>
                    <ul class="dropdown-menu">
                        <?php 
                        $sql = "SELECT * FROM `categories` limit 5";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) { ?>    
                        <li><a class="dropdown-item" href="/PHP/forums_website/threadlist.php?cat_id=<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></a></li>
                        <?php } ?>
                      
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/PHP/forums_website/contact.php">Contact</a>
                </li>
            </ul>

            <?php if($loggedin) {?>
            <form class="d-flex" role="search" method="get" action="search.php">
                <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-success" type="submit">Search</button>
            </form>
            <?php } else {?>
                <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-success" type="submit">Search</button>
            </form>
            <?php } ?>

            <?php if($loggedin) { ?>
                <div class="mx-2 my-2 my-lg-0 d-flex align-items-center">
                    <div class="text-secondary rounded me-1 border-secondary border text-capitalize" style="padding:6px 7px;">Welcome <b><?php echo $_SESSION['username']; ?></b></div>
                    <a href="/PHP/forums_website/components/_logout.php"><button class="btn btn-outline-success me-1" type="submit">Logout</button></a>
                </div>
            <?php } else { ?>
                <div class="mx-2 my-2 my-lg-0">
                    <button class="btn btn-outline-success me-1" type="submit" data-bs-toggle="modal"
                        data-bs-target="#loginModal">Login</button>
                    <button class="btn btn-outline-success" type="submit" data-bs-toggle="modal"
                        data-bs-target="#signupModal">Signup</button>
                </div>
            <?php } ?>
        </div>
    </div>
</nav>

<?php include '_loginModal.php'; ?>
<?php include '_signupModal.php'; ?>

<div class="container alert">
    <?php if ($showAlert) { ?>
        <div class="alert alert-success alert-dismissible fade show mb-0 position-relative" role="alert">
            <strong>Success!</strong> <?php echo $showAlert; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>

    <?php if ($showError) { ?>
        <div class="alert alert-warning alert-dismissible fade show mb-0 position-relative" role="alert">
            <strong>Error!</strong> <?php echo $showError; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>

    <?php if ($showAlert1) { ?>
        <div class="alert alert-success alert-dismissible fade show mb-0 position-relative" role="alert">
            <strong>Success!</strong> <?php echo $showAlert1; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>

    <?php if ($showError1) { ?>
        <div class="alert alert-warning alert-dismissible fade show mb-0 position-relative" role="alert">
            <strong>Error!</strong> <?php echo $showError1; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>

</div>