<style>
    .card {
        position: relative;
        transform: translateX(-50%);
        left: 50%;
        height: 370px !important;
    }

    .cat_btn:hover {
        background-color: transparent !important;
        border: 1px solid black;
    }

    .cat_btn {
        padding: 5px 10px !important;
        font-size: 12px;
    }

    .card-text {
        text-align: justify !important;
        font-size: 13px;
    }

    .card img {
        height: 170px !important;
        object-fit: cover !important;
    }
</style>

<?php
$select_categories = "SELECT * FROM `categories`";
$result = mysqli_query($conn, $select_categories);
?>

<div class="container my-5">
    <h2 class="ps-2 text-center mb-3">iDiscuss - Browse Categories</h2>
    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-3">
                <div>
                    <div class="card my-3 bg-dark text-light" style="width: 18rem;">
                        <img src="./img/<?php echo $row['category_name']; ?>.jpg" class="card-img-top" alt="...">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title"><?php echo $row['category_name']; ?></h5>
                            <p class="card-text"><?php echo substr($row['category_description'], 0, 150) . '...'; ?></p>
                            <a href="/PHP/forums_website/threadList.php/?page=1&cat_id=<?php echo $row['category_id']; ?>"
                                class="cat_btn btn bg-dark-subtle mt-auto">View Threads</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>