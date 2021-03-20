<?php
function updateUserTimeStamp($user_id,$conn){
    date_default_timezone_set('Europe/Budapest');
    $timestamp = date("Y-m-d H:i:s");
    $updateQuery = "UPDATE users set updated_at='{$timestamp}' WHERE unique_id = {$user_id}";
    error_log($updateQuery);
    mysqli_query($conn,$updateQuery);
}
?>