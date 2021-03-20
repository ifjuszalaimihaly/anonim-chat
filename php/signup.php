<?php
    session_start();
    include_once "config.php";
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $partner = mysqli_real_escape_string($conn, $_POST['partner']);
    if(!empty($gender) && !empty($partner)){
        $ran_id = rand(time(), 100000000);
        $status = "Active now";
        $insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, gender, partner, status)
                                VALUES ({$ran_id}, '{$gender}','{$partner}','{$status}')");
        if($insert_query){
            $_SESSION['unique_id'] = $ran_id;
            echo "success";
        }else{
            echo "Something went wrong. Please try again!";
        }
    }else{
        echo "All input fields are required!";
    }
?>