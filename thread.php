<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Threads</title>

    <style>
        .comment-box {
            background-color: rgba(211, 211, 211, .5);
            border-radius: 5px;
            border: 1px solid darkolivegreen;
        }
    </style>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <?php include 'components/_header.php'; ?>

    <?php

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        $user_id = $_SESSION['user_id'];
        $username = $_SESSION['username'];
        $useremail = $_SESSION['user_email'];
    } else {
        $user_id = null;
        $username = null;
    }

    $comment_result = false;
    ?>

    <?php
    if (isset($_GET['thread_id'])) {
        $id = $_GET['thread_id'];

        $single_thread = "SELECT * FROM threads WHERE thread_id = '$id' ";
        $result = mysqli_query($conn, $single_thread);

        if ($row = mysqli_fetch_assoc($result)) {
            $thread_title = $row['thread_title'];
            $thread_desc = $row['thread_desc'];
            $threads_user_id = $row['thread_user_id'];
            $sql = "select * from users where users_id = '$threads_user_id'";
            $result3 = mysqli_query($conn, $sql);
            if ($result3 && mysqli_num_rows($result3) > 0) {
                $row3 = mysqli_fetch_assoc($result3);
                $thread_users_names = $row3['email'];
            } else {
                $thread_users_names = "Unknown User";
            }
        } else {
            $thread_title = "Unknown Category";
            $thread_desc = "Description not available";
        }
    } else {
        $thread_title = "No Category Selected";
        $thread_desc = "Please select a category.";
    }
    ?>

    <?php
    if (isset($_POST['comment'])) {
        $comment_desc = $_POST['desc'];
        $comment_desc = str_replace("<","&lt;",$comment_desc);
        $comment_desc = str_replace(">","&gt;",$comment_desc);
        $insert_comment = "INSERT INTO `comments` (`comment_desc`, `comment_thread_id`, `comment_by`) VALUES ('$comment_desc', '$id', '$useremail')";
        mysqli_query($conn, $insert_comment);
    }

    $select_comment = "SELECT * FROM comments WHERE comment_thread_id = '$id'";
    $result2 = mysqli_query($conn, $select_comment);

    ?>

    <div class="container">
        <div class="h-100 mx-auto my-5" style="width:1000px" ;>
            <div class="comment-box p-5" role="alert">
                <h2 class="alert-heading"><b><?php echo $thread_title; ?></b></h2>
                <p style="color:gray;"><?php echo $thread_desc ?></p>
                <hr>
                <ul style="padding-left:22px" ;>
                    <li>No Spam / Advertising / Self-promote in the forums.</li>
                    <li>Do not post copyright-infringing material.</li>
                    <li>Do not post “offensive” posts, links or images.</li>
                    <li>Do not cross post questions.</li>
                    <li>Do not PM users asking for help.</li>
                    <li>Remain respectful of other members at all times.</li>
                </ul>
                <p style="color:gray;">Posted by: <b><em><?php echo $thread_users_names; ?></em></b></p>
            </div>
        </div>

        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
            <div class="row justify-content-center">
                <div class="col-9">
                    <form action="" method="post">
                        <h3 class="mb-3">Post a Comment</h3>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Type your Comment</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="desc" rows="3"></textarea>
                        </div>
                        <button type="submit" name="comment" class="btn btn-success">Add Comment</button>
                    </form>
                </div>
            </div>
        <?php } else { ?>
            <div class="row justify-content-center">
                <div class="col-9">
                    <h3 class="mb-3">Post a Comment</h3>
                    <p style="color:gray;">Please <a href="/PHP/forums_website/">login</a> to post a comment</p>
                </div>
            </div>
        <?php } ?>


        <div class="row justify-content-center mb-5 mt-0">
            <div class="col-9">
                <h3 class="mb-3" style="margin-top:100px;">Browse Comments</h3>
            </div>

            <?php if (mysqli_num_rows($result2) > 0) {
                $comment_result = true;
            } else { ?>
                <div class="h-100 mx-auto" style="width:1000px" ;>
                    <div class="comment-box p-5" role="alert">
                        <h2 class="alert-heading">No Comments Found</h2>
                        <hr>
                        <p style="color:gray" ;>Be the first person to ask questions...</p>
                    </div>
                </div>
            <?php } ?>

            <?php while ($row = mysqli_fetch_assoc($result2)) { ?>
                <div class="col-9 py-3 px-5 rounded my-2 border" style="background-color: rgba(211, 211, 211, .5);">
                    <div class="d-flex align-items-center justify-content-start">
                        <div class="">
                            <img src="https://cdn0.iconfinder.com/data/icons/round-user-avatar/33/user_circle_man_director_manager-1024.png"
                                alt="..." style="height:55px;,width:55px;">
                        </div>
                        <div class="ms-3">
                            <h6 class="m-0"><b><?php echo $row['comment_by'] ?></b> at <?php echo $row['timestamp'] ?></h6>
                            <p class="m-0 text-dark"><?php echo $row['comment_desc'] ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
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