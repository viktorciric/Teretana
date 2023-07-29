<?php 
   require_once 'config.php' ;

    if(!isset($_SESSION['admin_id'])) {
       header('location: index.php');
        exit() ;
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
    <title>Admin Dashboard</title>
</head>


<body>

<?php
    if(isset($_SESSION['success_mesage'])): ?>

<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php
     echo $_SESSION['success_mesage'] ;
     unset($_SESSION['success_mesage']) ;
     ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<div class="container">
    <div class="col-md-12">
        <div class="row">
            <h2><p>Members List</p></h2>
           

            <a href="export.php?what=members"  class="btn btn-success" style="font-size: 15px; width:  70px;">Export</a>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Gmail</th>
                        <th>Phone Number</th>
                        <th>Photo</th>
                        <th>Training Plan</th>
                        <th>Price</th>
                        <th>Trainer</th>
                        <th></th>
                        <th>Access Card</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                       $sql = "SELECT members.*, training_plans.name AS training_plan_name, training_plans.price AS training_plan_price, trainers.first_name AS trainer_first_name, trainers.last_name AS trainer_last_name, trainers.photo_path AS trainer_photo_path
                       FROM members
                       LEFT JOIN training_plans ON members.training_plan_id = training_plans.plan_id
                       LEFT JOIN trainers ON members.trainer_id = trainers.trainer_id";
               
                

                        $run = $conn->query($sql);

                        $results = $run->fetch_all(MYSQLI_ASSOC);
                        $select_members = $results ;
                       

                        
                        foreach($results as $result) :
                    ?>
                    <tr>
                        <td><?php echo $result['first_name'];?></td>  
                        <td><?php echo $result['last_name'];?></td>
                        <td><?php echo $result['email'];?></td>
                        <td><?php echo $result['phone_number'];?></td>
                        <td><img style="width: 60px;" src="<?php echo $result['photo_path'];?>"></td>
                        <td><?php echo $result['training_plan_name']; ?></td>
                        <td><?php echo $result['training_plan_price']; ?></td>
                        <td><?php 
                        if($result['trainer_first_name']) {
                            echo $result['trainer_first_name'] . " " . $result['trainer_last_name'] ; 
                        }else {
                            echo "trener nije dodeljen" ;
                        }
                        ?></td>
                        <td></td>
                        <td><a target="_blank" href="<?php echo $result['access_card_pdf_path'];?>">Access Card</a></td>
                        <td>
                            <?php
                            $created_at = strtotime($result['created_at']);
                            $new_date = date("F jS, Y", $created_at);
                            echo $new_date;
                            ?>
                        </td>
                        <td>
                            <form action="delete_member.php" method="POST">
                                <input type="hidden" name="member_id" value="<?php echo $result['member_id']; ?>">
                                <button type="submit">DELETE</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
                   
        </div>

        <div class="col-md-12">
            <h2><p>Trainer List</p></h2>
            

            <a href="export.php?what=trainers"  class="btn btn-success" style="font-size: 15px; width:  70px;">Export</a>
                
            <table class="table table-striped">
    <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gmail</th>
            <th>Phone Number</th>
            <th>Created At</th>
            <th>Action</th>
           
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM trainers";
        $run = $conn->query($sql);

        $results = $run->fetch_all(MYSQLI_ASSOC);
        $select_trainers = $results ;

        foreach ($results as $result) :
        ?>
        <tr>
            <td><?php echo $result['first_name']; ?></td>
            <td><?php echo $result['last_name']; ?></td>
            <td><?php echo $result['email']; ?></td>
            <td><?php echo $result['phone_number']; ?></td>
            <td><?php echo date("F jS Y", strtotime($result['created_at'])); ?></td>
            <td><form action="delete_trainers.php" method="POST">
                                <input type="hidden" name="trainer_id" value="<?php echo $result['trainer_id']; ?>">
                                <button type="submit">DELETE</button>
            </form></td>
            
           
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-5">
            <h2><p>Register Member:</p></h2>
            <form action="register_member.php" method="POST" enctype="multipart/form-data">
                <p>First Name: </p> <input class="form-control" type="text" name="first_name"><br>
                <p>Last Name: </p> <input class="form-control" type="text" name="last_name"><br>
                <p>Gmail: </p> <input class="form-control" type="email" name="email"><br>
                <p>Phone Number:</p> <input class="form-control" type="text" name="phone_number"><br>
                <p>Training Plan: </p>
                <select class="form-control" name="training_plan_id">
                    <option value="" disabled selected>Training Plan</option>
                    <?php
                    $sql = "SELECT * FROM training_plans";
                    $run = $conn->query($sql);
                    $results = $run->fetch_all(MYSQLI_ASSOC) ;
                    
                    foreach($results as $result) {
                        echo "<option value='" . $result['plan_id'] . "'>" . $result['name'] . "</option>";
                    }
                    ?>
                </select>

                <br>

                <p>Member Photo:</p>

                <input type="hidden" name="photo_path" id="photopathinput">

                <div id="dropzoneUpload" class="dropzone"></div>

                <input class="btn btn-primary mt-3" type="submit" value="Register Member">
            </form>
        </div>
        <div class="col-md-6">
            <h2><p>Register Trainer:</p></h2>
            <form action="register_trainer.php" method="POST">
                <p>First Name:</p> <input class="form-control" type="text" name="first_name"><br>
                <p>Last Name: </p> <input  class="form-control" type="text" name="last_name"><br>
                <p>Gmail:</p> <input class="form-control" type="email" name="email" ><br>
                <p>Phone Number:</p> <input class="form-control" type="text" name="phone_number"><br>

                <br>

                <input class="btn btn-primary" type="submit" value="Register Trainer">

            </form>
        </div>      
    </div>

    <div class="row">
        <div class="col-md-6">
            <h2><p>Dodavanje trenera clanovima</p></h2>
            <form action="assing_trainer.php" method="POST">
                <label for="" class="form-label"><h5><p>Select Member</p></h5></label>
                <select name="member" class="form-select">
             <?php
                 foreach($select_members as $member) : ?>
                <option value="<?php echo $member['member_id'] ?>">
                 <?php echo $member['first_name']." ". $member['last_name'];?>
                 </option> 
                 <?php endforeach;?>
                </select>

                <br> 

                <label for=""><h5><p>Select Trainer</p></h5></label> 
                <select name="trainer" class="form-select">
                    <?php
                        foreach($select_trainers as $trainer) : ?>
                        <option value="<?php echo $member['trainer_id'] ?>">
                     <?php echo $trainer['first_name']." ". $trainer['last_name'];?>
                        </option>
                    <?php endforeach;?>
                </select>

                <br>

                <button type="submit" class="btn btn-primary">Potvrdi</button>
            </form>
        </div> 
    </div>
</div>

<?php $conn->close();?>

<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

<script src="add_member_photo.js"></script>

<style>
    body {
    background-image: url(img/pozadina.admin_dash.jpg);
    min-height: 200vh;
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