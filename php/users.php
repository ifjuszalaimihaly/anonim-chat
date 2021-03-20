<?php
    session_start();
    include_once "config.php";
    include_once "functions.php";
    $current_id = $_SESSION['unique_id'];
    updateUserTimeStamp($_SESSION['unique_id'],$conn);
    $sql = "SELECT * FROM users WHERE unique_id = {$current_id};";
    $query = mysqli_query($conn, $sql);
    $current_user = mysqli_fetch_assoc($query);
    if ($current_user['partner_id'] !== NULL) {
        echo "user_id=".$current_user['partner_id'];
        exit();
    }
    $partnerSql = "SELECT * FROM users WHERE NOT unique_id = {$current_id} AND gender='{$current_user['partner']}' 
                    AND partner='{$current_user['gender']}' 
                    AND partner_id IS NULL
                    ORDER BY user_id DESC LIMIT 1;";
    $partnerQuery = mysqli_query($conn,$partnerSql);
    if(mysqli_num_rows($partnerQuery) === 1){
        $partner = mysqli_fetch_assoc($partnerQuery);
        $updateCurrentPartner = "UPDATE users set partner_id='{$partner['unique_id']}' WHERE unique_id = {$current_id}";
        $updatePartnerToCurrent = "UPDATE users set partner_id='{$current_id}' WHERE unique_id = {$partner['unique_id']}";
        mysqli_query($conn,$updateCurrentPartner);
        mysqli_query($conn,$updatePartnerToCurrent);
        echo "user_id=".$partner['unique_id'];
    } else {
       echo "No users are available to chat";
    }

?>