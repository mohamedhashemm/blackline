<?php
session_start();
if (isset($_SESSION['novel'])) {
    include("init.php");
    $statment = $connect->prepare("SELECT * FROM posts");

    $statment->execute();

    $postcount = $statment->rowCount();
    $result = $statment->fetchAll();
    $page = "All";
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = "All";
    }
    if ($page == "All") {



?>

        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12 m-auto text-center ">
                    <h2 class="text-center">Number Of Row:<span class="badge badge-info"> <?php echo $postcount;  ?></span> </h2>
                    <table class="table table-dark ">
                        <thead>
                            <tr>
                                <th>Post_id</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>category_id</th>
                                <th>user_id</th>
                                <th>Created_at</th>
                                <th>Operation</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if ($postcount > 0) {

                                foreach ($result as $x) {

                            ?>
                                    <tr>

                                        <td> <?php echo $x['post_id'] ?></td>
                                        <td> <?php echo $x['title'] ?></td>
                                        <td> <?php echo $x['description'] ?></td>
                                        <td> <?php echo $x['image'] ?></td>
                                        <td> <?php echo $x['status'] ?></td>
                                        <td> <?php echo $x['category_id'] ?></td>
                                        <td> <?php echo $x['user_id'] ?></td>
                                        <td> <?php echo $x['created_at'] ?></td>
                                        <td> <?php echo $x['updated_at'] ?></td>
                                        <td>
                                            <a href="?page=show&post_id= <?php echo $x['post_id'] ?>" class="btn btn-success"><i class="fa-regular fa-eye"></i></a>
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

    } else if ($page == "show") {
        $post_id="";
        if(isset($_GET['post_id'])){
            $post_id=$_GET['post_id'];

        }else{
            $post_id="";
        }

        $statment=$connect->prepare("SELECT * FROM posts WHERE post_id=?");
        $statment->execute(array($post_id));
        $result=$statment->fetchAll();

        foreach($result as $x){


      


      

       


    ?>

        <div class="container mt-4 ">
            <div class="row">
                <div class="col-md-10 m-auto">
                    <h2 class="text-center">Show & Edite Posts</h2>
                    <form method="post" action="?page=updatepost&post_id=<?php echo $x['post_id'] ?>">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Post Id</label>
                            <input type="number" value="<?php echo $x['post_id'] ?>" class="form-control" name="post-id">
                          
                        </div>
                       
                        <div class="form-group">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="text" value="<?php echo $x['title'] ?>" class="form-control" name="title">
                          
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Discripation</label>
                            <input type="text" value="<?php echo $x['description'] ?>" class="form-control" name="dis">
                          
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Image</label>
                            <input type="text" value="<?php echo $x['image'] ?>" class="form-control" name="image">
                          
                        </div>
                        <div class="form-group" >
                          <select name="status"  class="form-control" >
                            <?php
                            if( $x['status'] ==1){

                                ?>
                                <option value="1" selected>Active</option>
                                <option value="0">Block</option>
                                <?php
                            }else{
                                ?>
                                 <option value="1">Active</option>
                                <option value="0" selected>Block</option>
                                <?php
                            }
                            ?>
                          </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Category Id</label>
                            <input type="number" class="form-control" value="<?php echo $x['category_id'] ?>" name="category-id">
                          
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">User Id</label>
                            <input type="number" value="<?php echo $x['user_id'] ?>" class="form-control" name="user-id">
                          
                        </div>
                
                        <button type="submit" name="submit-post" class="btn btn-primary btn-block">Submit</button>
                    </form>

                </div>
            </div>
        </div>




    <?php




}
}else if($page=="updatepost"){
    if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(isset($_POST['submit-post'])){
        $id=$_POST['post-id'];
        $title=$_POST['title'];
        $discripation=$_POST['dis'];
        $image=$_POST['image'];
        $ststus=$_POST['status'];
        $category=$_POST['category-id'];
        $post=$_POST['user-id'];
        $statment=$connect->prepare("UPDATE posts SET 
        post_id=?,
        title=?,
        `description`=?,
        `image`=?,
        `status`=?,
        category_id=?,
        user_id=?
        WHERE post_id= ?
        ");

        $statment->execute(array($id,$title,$discripation,$image,$ststus,$category,$post));

        $result= $statment->fetchAll();

        echo"jhfjf";

    }


    }

}


    ?>


<?php

    include("includes/temp/footer.php");
} else {

    echo "<h2 style='text-align:center; background:#f00 ; color:#fff'>Login First</h2>";

    header('Refresh:3;url=login.php');
}



?>