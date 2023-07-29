<?php
    require_once 'config.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT admin_id, password FROM admins WHERE username = ?";

        $run = $conn->prepare($sql);
        $run->bind_param("s", $username);
        $run->execute();

        $results = $run->get_result();

        
        if ($results->num_rows == 1) {
            $admin = $results->fetch_assoc();

            if (password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['admin_id'];

              
                $conn->close();
                header('location: admin_dashboard.php');
                exit;
            } else {
                $_SESSION['error'] = "<p>Netacan Password!</p>";

                $conn->close();
                header('location: index.php');
                exit;
            }
        } else {
            $_SESSION['error'] = "<p>Netacan Username!</p>";

            $conn->close();
            header('location: index.php');
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Admin login</title>
</head>
<body>
    <?php 
        if(isset($_SESSION['error'])) {
            echo $_SESSION['error']. "<br>" ;
            unset($_SESSION['error']) ;
        }
    ?>
    <div class="container">
        <form action="" method="POST">
            <h5>Username:</h5> <input type="text" name="username" id="username">
            <h5>Password:</h5> <input type="password" name="password" id="password">
            <input type="checkbox" name="cheak" value="cheak1" id="showPassword"> <-Show Passsword
            <input type="submit" value="Login">
        </form>
    </div>

    <script>
        let passwordInput = document.getElementById("password");
        let showPassword = document.getElementById("showPassword");

        showPassword.addEventListener("change", function() {
        if (showPassword.checked) {
             passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
        });
    </script>
</body>
</html>
