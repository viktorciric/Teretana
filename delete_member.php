<?php 
require_once 'config.php' ;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $member_id = $_POST['member_id'] ;

    $sql = "DELETE FROM members WHERE member_id = ?" ;
    $run = $conn->prepare($sql) ; 

    $run->bind_param("i", $member_id) ;
    $message = "" ;

    if ($run->execute()) {
        $message = "Član teretane je uspesno obrisan" ;
    } else {
        $message = "Član teretane nije obrisan" ;
    }

    $_SESSION['success_mesage'] = $message;
    header('location: admin_dashboard.php') ;
    exit;
}
?>
