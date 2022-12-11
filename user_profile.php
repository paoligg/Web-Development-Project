<!DOCTYPE html>
<?php
session_start();
include("includes/header.php");

if(!isset($_SESSION['user_email'])){
	header("location: index.php");
}?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/app.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Find People</title>
</head>

<body>
    <div class="row">
        <?php 
            if(isset($_GET['u_id'])){
                $u_id = $_GET['u_id'];
            }
            if ($u_id < 0 || $u_id == "") {
                echo "<script>window.open('app.php', '_self')</script>";
            } 
            else {

            }
        ?>

        <div class="col-sm-12">
            <?php
            if(isset($_GET['u_id'])){
                global $con;
                $user_id = $_GET['u_id'];
                $select = "select * from users where user_ID='$user_id'";
                $run = mysqli_query($con, $select);
                $row = mysqli_fetch_array($run);
                $name = $row['username'];

            }
            ?>
            <?php
            if (isset($_GET['u_id'])) {
                global $con;
                $user_id = $_GET['u_id'];
                $select = "select * from users where user_ID='$user_id'";
                $run = mysqli_query($con, $select);
                $row = mysqli_fetch_array($run);
                $id = $row['user_ID'];
                $image = $row['profil_picture'];
                $name = $row['username'];
                $f_name = $row['f_name'];
                $l_name = $row['l_name'];
                $describe_user = $row['biography'];
                $register_date = $row['reg_date'];

                echo "
                <div class='row'>
                <div class='col-sm-1'>
                </div>
                <center>
                <div style='background-color: #e6e6e6;' class='col-sm-3'>
                <h2>Information About</h2>
                <img class='img-circle' src='profile_pictures/$image' width='150' height='150'>
                <br><br>
                <ul class='list-group'>
                <li class='list-group-item' title='Username'><strong>$f_name $l_name</strong></li>
                <li class='list-group-item' title='User Status'><strong style='color: grey;'>$describe_user</strong></li>
                <li class='list-group-item' title='User Registration Date'><strong style='color: grey;'>$register_date</strong></li>
                </ul>
                </div>
                ";
                $user=$_SESSION['user_email'];
                $get_user="select * from users where email='$user'";
                $run_user=mysqli_query($con,$get_user);
                $row=mysqli_fetch_array($run_user);
                $userown_id=$row['user_ID'];
                if($user_id == $userown_id){
                    echo "<a href='edit_profile.php?u_id=$userown_id' class='btn btn-success'>Edit Profile</a><br><br><br>";
                }
                echo "</center>";

            }
            ?>
            <div class="col-sm-8">
                <center>
                    <h1><strong><?php echo "$f_name $l_name"; ?></strong>'s Posts</h1>
                </center>
                <?php
                global $con;
                if(isset($_GET['u_id'])){
                    $u_id = $_GET['u_id'];
                }
                $get_posts = "select * from posts where user_id='$u_id' ORDER by 1 DESC LIMIT 5";
                $run_posts = mysqli_query($con, $get_posts);

                while($row_posts=mysqli_fetch_array($run_posts)){
                    $post_id = $row_posts['post_id'];
                    $user_id = $row_posts['user_ID'];
                    $content = $row_posts['post_content'];
                    $upload_image = $row_posts['upload_image'];
                    $post_date = $row_posts['post_date'];

                    $user="select * from users where user_ID='$user_id' AND posts='yes'";
                    $run_user=mysqli_query($con,$user);
                    $row_user=mysqli_fetch_array($run_user);

                    $user_name=$row_user['username'];
                    $f_name=$row_user['f_name'];
                    $l_name=$row_user['l_name'];
                    $user_image=$row_user['profil_picture'];

                    if($content=="No" && strlen($upload_image) >= 1){
                        echo "
                        <div id='own_posts'>
                            <div class='row'>
                                <div class='col-sm-2'>
                                    <p><img src='profile_pictures/$user_image' class='img-circle' width='100px' height='100px'></p>
                                </div>
                                <div class='col-sm-6'>
                                    <h3><a style='text-decoration: none; cursor: pointer; color: #3897f0;' href='user_profile.php?u_id=$user_id'>$f_name $l_name</a></h3>
                                    <h4><small style='color: black;'>Updated a post on <strong>$post_date</strong></small></h4>
                                </div>
                                <div class='col-sm-4'>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <img id='posts-img' src='imagepost/$upload_image' style='height: 350px;'>
                                </div>
                            </div><br>
                            <a href='single.php?post_id=$post_id' style='float: right;'><button class='btn btn-success'>View</button></a>
                            <a href='functions/delete_post.php?post_id=$post_id' style='float: right;'><button class='btn btn-danger'>Delete</button></a>
                        </div><br><br>
                        ";
                    }
                    else if(strlen($content) >= 1 && strlen($upload_image) >= 1){
                        echo "
                            <div id='own_posts'>
                                <div class='row'>
                                    <div class='col-sm-2'>
                                        <p><img src='profile_pictures/$user_image' class='img-circle' width='100px' height='100px'></p>
                                    </div>
                                    <div class='col-sm-6'>
                                        <h3><a style='text-decoration: none; cursor: pointer; color: #3897f0;' href='user_profile.php?u_id=$user_id'>$f_name $l_name</a></h3>
                                        <h4><small style='color: black;'>Updated a post on <strong>$post_date</strong></small></h4>
                                    </div>
                                    <div class='col-sm-4'>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-sm-12'>
                                        <p>$content</p>
                                        <img id='posts-img' src='imagepost/$upload_image' style='height: 350px;'>
                                    </div>
                                </div><br>
                                <a href='single.php?post_id=$post_id' style='float: right;'><button class='btn btn-success'>View</button></a>
                                <a href='functions/delete_post.php?post_id=$post_id' style='float: right;'><button class='btn btn-danger'>Delete</button></a>
                            </div><br><br>
                        ";
                    }   
                }
                ?>
            </div>
        </div>
    </div>

</body>

</html>