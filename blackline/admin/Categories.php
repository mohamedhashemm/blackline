<?php



session_start();
if (isset($_SESSION['novel'])) {

   
include("init.php");
$statment = $connect->prepare("SELECT * FROM categories");

$statment->execute();

$catcount = $statment->rowCount();
$result = $statment->fetchAll();

$page = "All";
if (isset($_GET['page'])) {

    $page = $_GET['page'];
} else {
    $page = "All";
}

if ($page == 'All') {






?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 m-auto text-center">
                <h2 class="text-center">Number Of Row:<span class="badge badge-info"> <?php echo $catcount  ?></span>
                    <a href="?page=createcategory" class='btn btn-success'>Create New Row</a>
                </h2>
                <table class="table table-dark ">
                    <thead>
                        <tr>
                            <th>category_id</th>
                            <th>title</th>
                            <th>descripation</th>
                            <th>status</th>
                            <th>Created_at</th>
                            <th>Operation</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if ($catcount > 0) {

                            foreach ($result as $x) {

                        ?>
                                <tr>

                                    <td> <?php echo $x['category_id'] ?></td>
                                    <td> <?php echo $x['title'] ?></td>
                                    <td> <?php echo $x['discripation'] ?></td>
                                    <td> <?php echo $x['status'] ?></td>
                                    <td> <?php echo $x['created_at'] ?></td>
                                    <td> <?php echo $x['updated_at'] ?></td>
                                    <td>
                                        <a href="?page=show&category_id=<?php echo $x['category_id']  ?>" class="btn btn-success"><i class="fa-regular fa-eye"></i></a>
                                    </td>
                                    <td>
                                        <a href="?page=deletecategory&category_id=<?php echo $x['category_id']  ?>" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></a>
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


} elseif ($page == "show") {
    $category_id = "";
    if (isset($_GET['category_id'])) {
        $category_id = $_GET['category_id'];
    } else {
        $category_id = "";
    }

    $statment = $connect->prepare("SELECT * FROM categories WHERE category_id=?");

    $statment->execute(array($category_id));
    $result = $statment->fetchAll();


    foreach ($result as $x) {




    ?>
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <h2 class="text-center">Show&Edite Categories</h2>
                    <form method="post" action="?page=updatecategory&novel=<?php echo $x['category_id'] ?>">
                        <div class="form-group">
                            <label for="exampleInputEmail1">ID</label>
                            <input type="number" class="form-control" value="<?php echo $x['category_id'] ?> " name="id">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="text" class="form-control" value="<?php echo $x['title'] ?>" name="title">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Discripation</label>
                            <input type="mumber" class="form-control" value="<?php echo $x['discripation'] ?>" name="dis">
                        </div>
                        <div class="form-group">
                            <label>stats</label>
                            <select name="status" class="form-control">
                                <?php
                                if ($x['status'] == 0) {
                                ?>
                                    <option value="0" selected>0</option>
                                    <option value="1">1</option>
                                <?php
                                } else {
                                ?>
                                    <option value="0">0</option>
                                    <option value="1" selected>1</option>

                                <?php
                                }

                                ?>


                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block" name="submit-category">Update</button>
                    </form>
                </div>
            </div>
        </div>



    <?php
    }
} elseif ($page == "updatecategory") {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['submit-category'])) {
            $novel = "";
            if (isset($_GET['novel'])) {
                $novel = $_GET['novel'];
            } else {
                $novel = "";
            }
            $id = $_POST['id'];

            $title = $_POST['title'];
            $discription = $_POST['dis'];
            $status = $_POST['status'];

            $statment = $connect->prepare('UPDATE categories SET 
              category_id=?,
              title=?,
              discripation=?,
              `status`=?
              where category_id=?
              ');

            $statment->execute(array($id, $title, $discription, $status, $novel));


            echo "<h2 class='alert alert-info text-center'>update successfully</h2>";

            header('refresh:3;Categories.php');
        }
    }
} else if ($page == "createcategory") {




    ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-10 m-auto ">
                <h2 class="text-center">Add New Category</h2>
                <form method="post" action="?page=save-new-category">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Id</label>
                        <input type="number" class="form-control" name="id">

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Title</label>
                        <input type="text" class="form-control" name="title">

                    </div>
                    <div class="form-group">
                        <label>Didcripation</label>
                        <input type="text" class="form-control" name="dis">

                    </div>
                    <div class="form-group">
                        <select name="status" class="form-control">
                            <?php
                            if ($x['status'] == 0) {
                            ?>
                                <option value="0" selected>0</option>
                                <option value="1">1</option>
                            <?php
                            } else {
                            ?>
                                <option value="0">0</option>
                                <option value="1" selected>1</option>

                            <?php
                            }

                            ?>


                        </select>

                    </div>
                    <button type="submit" name="submit-update" class="btn btn-primary btn-block">Create New Category</button>
                </form>

            </div>
        </div>
    </div>



<?php
}else if($page=='save-new-category'){
    if($_SERVER['REQUEST_METHOD']=="POST"){
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $category_id=$_POST['id'];
            $statment=$connect->prepare("SELECT * FROM categories WHERE category_id=?");
            $statment->execute(array($category_id));
            $allcount=$statment->rowCount();
            if($allcount>0){
                echo"<h2 class='alert alert-danger text-center'>ID Aready Exists</h2>";

                header('refresh:3;url=?page=save-new-category');
                exit();

            }

        }









        if(isset($_POST['submit-update'])){

            $id=$_POST['id'];
            $title=$_POST['title'];
            $discription=$_POST['dis'];
            $status=$_POST['status'];

            $statment=$connect->prepare("INSERT INTO categories(category_id,title,discripation,`status`) VALUES(?,?,?,?)
            ");
            $statment->execute(array($id,$title,$discription,$status));

            echo"<h2 class='alert alert-info text-center'>Create Successfully</h2>";
            header('refresh:3;url=categories.php');
          

        }

    }

}else if($page=="deletecategory"){
    $category_id="";
    if(isset($_GET['category_id'])){
        $category_id=$_GET['category_id'];

    }else{
        $category_id="";
    }

    $statment=$connect->prepare("DELETE FROM categories WHERE category_id=? ");
    $statment->execute(array($category_id));

    echo"<h2 class='alert alert-danger text-center'>Delete Successfully</h2>";

    header("refresh:3;url=categories.php");



}

?>


<?php
include('includes/temp/footer.php');
} else {

    echo "<h2 style='text-align:center; background:#f00 ; color:#fff'>Login First</h2>";

    header('Refresh:3;url=login.php');
}
?>