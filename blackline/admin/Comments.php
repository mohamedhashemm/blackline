<?php
session_start();
if (isset($_SESSION['novel'])) {

include("init.php");
$statment = $connect->prepare("SELECT * FROM comments");

$statment->execute();

$commentcount = $statment->rowCount();
$result = $statment->fetchAll();

?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12 m-auto text-center text-center">
            <h2 class="text-center">Number Of Row:<span class="badge badge-info"> <?php echo $commentcount;  ?></span> </h2>
        <table class="table table-dark ">
    <thead>
        <tr>
            <th>Comment_id</th>
            <th>Comment</th>
            <th>Status</th>
            <th>User_id</th>
            <th>Post_id</th>
            <th>Created_at</th>
            <th>Operation/th>
        </tr>
    </thead>

<tbody>
    <?php
    if ($commentcount > 0) {

        foreach ($result as $x) {

    ?>
            <tr>

                <td> <?php echo $x['comment_id'] ?></td>
                <td> <?php echo $x['comment'] ?></td>
                <td> <?php echo $x['status'] ?></td>
                <td> <?php echo $x['user_id'] ?></td>
                <td> <?php echo $x['post_id'] ?></td>
                <td> <?php echo $x['created_at'] ?></td>
                <td> <?php echo $x['updated_at'] ?></td>
                <td>
                    <a href="#" class="btn btn-success"><i class="fa-regular fa-eye"></i></a>
                </td>
                <td>
                    <a href="#" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></a>
                </td>
            </tr>
    <?php
        }
    }
    ?>
</tbody>
</table>



        </div>
    </div>
</div>


<?php

include("includes/temp/footer.php");

} else {

    echo "<h2 style='text-align:center; background:#f00 ; color:#fff'>Login First</h2>";

    header('Refresh:3;url=login.php');
}

?>