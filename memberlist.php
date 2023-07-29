<?php 
require_once 'config.php';
if(!isset($_SESSION['admin_id'])) {
    header('location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link rel="stylesheet" href="admin_dash.css">
    <title>Admin Dashboard - Member List</title>
</head>

<body>
<?php
    if(isset($_SESSION['success_mesage'])):
?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php
     echo $_SESSION['success_mesage'];
     unset($_SESSION['success_mesage']);
    ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php
    endif;
?>

<div class="container">
    <div class="col-md-12">
        <div class="row">
            <h2><p><a href="memberlist.php">Members List</a></p></h2>
            <a href="export.php?what=members"  class="btn btn-success" style="font-size: 15px; width:  70px;">Export</a>
            <table class="table table-striped">
                <!-- Member list table content -->
            </table>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-5">
            <h2><p>Register Member:</p></h2>
            <form action="register_member.php" method="POST" enctype="multipart/form-data">
                <!-- Member registration form content -->
            </form>
        </div>
        <div class="col-md-6">
            <h2><p>Register Trainer:</p></h2>
            <form action="register_trainer.php" method="POST">
                <!-- Trainer registration form content -->
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h2><p>Dodavanje trenera clanovima</p></h2>
            <form action="assing_trainer.php" method="POST">
                <!-- Add trainers to members form content -->
            </form>
        </div>
    </div>
</div>

<?php
    $conn->close();
?>

<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="add_member_photo.js"></script>
<style>
    body {
    background-image: url(img/pozadina.admin_dash.jpg);
    height: 180vh;
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
  }
  p {
    color: white;
  }
</style>
</body>
</html>
