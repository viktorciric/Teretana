<?php

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];

    $sql = "INSERT INTO trainers (first_name, last_name, email, phone_number) 
            VALUES (?, ?, ?, ?)";

    $run = $conn->prepare($sql);
    $run->bind_param("ssss", $first_name, $last_name, $email, $phone_number);
    $run->execute();

    $_SESSION['success_mesage'] = "Trener je uspesno dodat" ;
    header('location: admin_dashboard.php ') ;
    exit();
}
?>
