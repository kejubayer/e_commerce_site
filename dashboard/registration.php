<?php
$message=false;
if(!empty ($_FILES['photo']['tmp_name'])){
    $name= $_FILES['photo']['name'];
    $filename_parts =explode ('.' , $name);
    $extention = end ($filename_parts);
    $newfilename =uniqid('pp',true).time().'.'.$extention;
    move_uploaded_file($_FILES['photo']['tmp_name'],'upload/profile-photo/'.$newfilename );
    $message = 'file uploaded : ';
    $message.='<img src="upload/profile-photo/'.$newfilename.'" alt="photo" width ="200"/>';
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Registration</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <?php if ($message):?>
            <div class="alert alert-success">
                <?php echo $message?>
                <?php endif ; ?>
            </div>

        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <form class="form-signin" action="" method="post" enctype="multipart/form-data">
                <h1 class="h3 mb-3 font-weight-normal">Admin Register</h1>
                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                <label for="file_type" class="sr-only">Password</label>
                <input type="file" id="file_type" name='photo' class="form-control" >
                <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
            </form>
        </div>
    </div>
</div>
<?php require_once '../partials/_footer.php'; ?>






