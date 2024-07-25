<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iDiscuss - Search Result</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        .pagination{
            --bs-pagination-color: black;
            --bs-pagination-border-color: gray;
        }

        .page-item.active .page-link {
            background-color: gray !important;
            color: #fff;
            border-color: gray;
        }

        .page-item.active .page-link:hover {
            color: #fff !important;
        }

        .page-link:hover {
            color: black !important;
        }
    </style>

</head>

<body>

    <?php include 'components/_header.php'; ?>


    <div class="container">
        <div style="height: 100vh;">
            <div class="row justify-content-center mt-5">
                <div class="col-9">
                    <h3>Search Result For "<em><?php echo $_GET['search'] ?></em>"</h3>
                </div>
            </div>

            <?php

            // $search = '';
            // $page = 1;
            
            if (isset($_GET['search'])) {
                $search = $_GET['search'];
            }

            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }

            $items_per_page = 1;
            $start = ($page - 1) * $items_per_page;
            $sql1 = "SELECT * FROM threads WHERE MATCH (thread_title, thread_desc) AGAINST ('$search')";
            $result1 = mysqli_query($conn, $sql1);
            $pg_record = mysqli_num_rows($result1);
            $total_page = ceil($pg_record / $items_per_page);

            $sql = "SELECT * FROM threads WHERE MATCH (thread_title, thread_desc) AGAINST ('$search') limit $start , $items_per_page";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="row justify-content-center my-3">
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
                </div>
            <?php } ?>


            <?php if (mysqli_num_rows($result) <= 0) { ?>
                <div class="h-100 mx-auto" style="width:1000px" ;>
                    <div class="thread-box p-5" role="alert">
                        <h2 class="alert-heading">No Result Found</h2>
                        <hr>
                        <p class="mb-2 fw-bold">Suggestions :</p>
                        <ul class="ps-3">
                            <li>Make sure that all words spelled correctly.</li>
                            <li>Try different keywords.</li>
                            <li>Try more general keywords.</li>
                        </ul>
                    </div>
                </div>
            <?php } ?>

            <div class="row justify-content-center my-5">
                <div class="col-10">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination search_pagination justify-content-center">
                            <li class="page-item <?php if ($page == 1) {
                                echo "d-none";
                            } ?>">
                                <a class="page-link"
                                    href="search.php?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                                <li class="page-item <?php if ($i == $page) {
                                    echo "active";
                                } ?>">
                                    <a class="page-link"
                                        href="search.php?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"
                                        aria-label="Previous">
                                        <span aria-hidden="true"><?php echo $i; ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                            <li class="page-item <?php if ($page == $total_page) {
                                echo "d-none";
                            } ?>">
                                <a class="page-link"
                                    href="search.php?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>"
                                    aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
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