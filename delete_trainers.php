<?php 
require_once 'config.php' ;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $member_id = $_POST['trainer_id'] ;

    $sql = "DELETE FROM trainers WHERE trainer_id = ?" ;
    $run = $conn->prepare($sql) ; 

    $run->bind_param("i", $member_id) ;
    $message = "" ;

    if ($run->execute()) {
        $message = "Trener je uspesno obrisan" ;
    } else {
        $message = "Trener nije obrisan" ;
    }

    $_SESSION['success_mesage'] = $message;
    header('location: admin_dashboard.php') ;
    exit;
}
?>
