<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Threads</title>

    <style>
        .thread-box {
            background-color: rgba(211, 211, 211, .5);
            border-radius: 5px;
            border: 1px solid darkolivegreen;
        }

        .qna_title:hover {
            color: brown !important;
        }

        .pagination{
            --bs-pagination-color: black !important;
            --bs-pagination-border-color: gray !important;
        }

        .page-item.active .page-link {
            background-color: gray !important;
            color: #fff !important;
            border-color: gray !important;
        }

        .page-item.active .page-link:hover {
            color: #fff !important;
        }

        .page-link:hover {
            color: black !important;
        }

    </style>


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <?php include 'components/_header.php'; ?>

    <?php
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $username = isset($_SESSION['username']) ? $_SESSION['username'] :
        $thread_result = false;
    ?>

    <?php
   
    if (isset($_GET['cat_id'])) {
        $id = $_GET['cat_id'];


        $single_category = "SELECT * FROM categories WHERE category_id = '$id' ";
        $result = mysqli_query($conn, $single_category);

        if ($row = mysqli_fetch_assoc($result)) {
            $category_name = $row['category_name'];
            $category_desc = $row['category_description'];
        } else {
            $category_name = "Unknown Category";
            $category_desc = "Description not available";
        }

    } else {
        $category_name = "No Category Selected";
        $category_desc = "Please select a category.";
    }
    ?>

    <?php
    if (isset($_POST['qna'])) {
        $thread_title = $_POST['title'];
        $thread_desc = $_POST['desc'];

        $thread_title = str_replace("<", "&lt;", $thread_title);
        $thread_title = str_replace(">", "&gt;", $thread_title);

        $thread_desc = str_replace("<", "&lt;", $thread_desc);
        $thread_desc = str_replace(">", "&gt;", $thread_desc);

        $thread_cat_id = $id;
        $thread_user_id = $user_id;
        $insert_thread = "INSERT INTO threads (thread_title,thread_desc,thread_cat_id,thread_user_id) VALUES ('$thread_title','$thread_desc','$thread_cat_id','$thread_user_id')";
        $result_thread = mysqli_query($conn, $insert_thread);
    }



    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    $items_per_page = 5;
    $start = ($page - 1) * $items_per_page;
    $sql1 = "select * from threads where thread_cat_id = '$id'";
    $result1 = mysqli_query($conn, $sql1);
    $pg_record = mysqli_num_rows($result1);
    $total_page = ceil($pg_record / $items_per_page);

    // if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    //     $select_thread = "select * from threads where thread_cat_id = '$id' and thread_user_id = '$user_id'";
    // }else{
    $select_thread = "select * from threads where thread_cat_id = '$id' limit $start , $items_per_page";
    // }
    $result2 = mysqli_query($conn, $select_thread);
    ?>

    <div class="container">
        <div class="h-100 mx-auto my-5" style="width:1000px" ;>
            <div class="thread-box p-5" role="alert">
                <h2 class="alert-heading">Welcome to <b><?php echo $category_name; ?></b> Forums</h2>
                <p style="color:gray" ;><?php echo $category_desc ?></p>
                <hr>
                <ul style="padding-left:22px" ;>
                    <li>No Spam / Advertising / Self-promote in the forums.</li>
                    <li>Do not post copyright-infringing material.</li>
                    <li>Do not post “offensive” posts, links or images.</li>
                    <li>Do not cross post questions.</li>
                    <li>Do not PM users asking for help.</li>
                    <li>Remain respectful of other members at all times.</li>
                </ul>
            </div>
        </div>

        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>

            <div class="row justify-content-center">
                <div class="col-9">
                    <form action="" method="post">
                        <h1 class="mb-3">Start a Discussion</h1>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Problem Title</label>
                            <input type="text" class="form-control" name="title" id="exampleFormControlInput1"
                                placeholder="put your question..." aria-describedby="titleHelp">
                            <div id="titleHelp" class="form-text">Keep your answer short and crisp as possible.</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Ellaborate Your Concern</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="desc" rows="3"></textarea>
                        </div>
                        <button type="submit" name="qna" class="btn btn-success">Add QNA</button>
                    </form>
                </div>
            </div>

        <?php } else { ?>

            <div class="row justify-content-center">
                <div class="col-9">
                    <h3 class="mb-3">Start a Discussion</h3>
                    <p style="color:gray;">Please <a href="/PHP/forums_website/">login</a> to start a Discussion</p>
                </div>
            </div>
        <?php } ?>


        <div class="row justify-content-center mb-3 mt-5">
            <div class="col-9">
                <h1 class="mb-3 mt-0" style="margin-top:100px;">Browse QNAs ???</h1>
            </div>

            <?php if (mysqli_num_rows($result2) > 0) {
                $thread_result = true;
            } else { ?>
                <div class="h-100 mx-auto" style="width:1000px" ;>
                    <div class="thread-box p-5" role="alert">
                        <h2 class="alert-heading">No QNAs Found</h2>
                        <hr>
                        <p style="color:gray" ;>Be the first person to ask questions...</p>
                    </div>
                </div>
            <?php } ?>

            <?php while ($row = mysqli_fetch_assoc($result2)) { ?>
                <div class="col-9 py-3 px-5 rounded my-2 border" style="background-color: rgba(211, 211, 211, .5);">
                    <div class="d-flex align-items-center">
                        <div class="col-1">
                            <img src="https://cdn0.iconfinder.com/data/icons/round-user-avatar/33/user_circle_man_director_manager-1024.png"
                                alt="..." style="height:55px;,width:55px;">
                        </div>
                        <div class="ms-3 col-11">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a href="/PHP/forums_website/thread.php/?thread_id=<?php echo $row['thread_id'] ?>"
                                        class="text-dark text-decoration-none qna_title">
                                        <h5 class="m-0"><?php echo $row['thread_title'] ?></h5>
                                    </a>
                                    <p class="m-0 text-dark"><?php echo $row['thread_desc'] ?></p>
                                </div>

                                <div class="text-end">
                                    <?php
                                    $thread_users_id = $row['thread_user_id'];
                                    $sql3 = "SELECT * FROM `users` WHERE `users_id` = $thread_users_id";
                                    $result3 = mysqli_query($conn, $sql3);
                                    if ($result3 && mysqli_num_rows($result3) > 0) {
                                        $row3 = mysqli_fetch_assoc($result3);
                                        $thread_users_name = $row3['email'];
                                    } else {
                                        $thread_users_name = "Unknown User";
                                    }
                                    ?>

                                    <p class="m-0 text-dark">Asked by: <b><?php echo $thread_users_name; ?></b></p>
                                    <p class="m-0 text-dark">At: <?php echo $row['timestamp']; ?></p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="row justify-content-center my-5">
            <div class="col-10">
                <nav aria-label="Page navigation example">
                    <ul class="pagination search_pagination justify-content-center <?php if($total_page==1) echo "d-none"?>">
                        <li class="page-item <?php if ($page == 1 && mysqli_num_rows($result2)<=$items_per_page) {
                            echo "d-none";
                        } ?>">
                            <a class="page-link" href="/PHP/forums_website/threadList.php?page=<?php echo $page - 1; ?>&cat_id=<?php echo $id; ?>"
                                aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                            <li class="page-item <?php if ($i == $page) {
                                echo "active";
                            } ?>">
                                <a class="page-link"
                                    href="/PHP/forums_website/threadList.php?page=<?php echo $i; ?>&cat_id=<?php echo $id; ?>"
                                    aria-label="Previous">
                                    <span aria-hidden="true"><?php echo $i; ?></span>
                                </a>
                            </li>
                        <?php } ?>
                        <li class="page-item <?php if ($page == $total_page) {
                            echo "d-none";
                        } ?>">
                            <a class="page-link" href="/PHP/forums_website/threadList.php?page=<?php echo $page + 1; ?>&cat_id=<?php echo $id; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>


    <?php include 'components/_footer.php'; ?>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap Js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>

</html>