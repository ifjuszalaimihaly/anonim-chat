<?php 
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        include_once "functions.php";
        updateUserTimeStamp($_SESSION['unique_id'],$conn);
        $outgoing_id = $_SESSION['unique_id'];
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $output = [];
        $output['message'] = "";
        $output['messages'] = [];
        $partnerSql = "SELECT * FROM users WHERE partner_id={$_SESSION['unique_id']}";
        $query = mysqli_query($conn, $partnerSql);
        if(mysqli_num_rows($query) > 0) {
            $partnerSql = mysqli_fetch_assoc($query);
            $output['partner_status'] = $partnerSql['status'];
            $output['partner_updated_at'] = $partnerSql['updated_at'];
            $output['partner_gender'] = $partnerSql['gender'];
        }
        $sql = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
                WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";
        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
                if($row['outgoing_msg_id'] == $_SESSION['unique_id']) {
                    //$m = [];
                    $output['messages'][$row['msg_id']] = ['message' => $row['msg'], 'direction' => 'out'];

                    //array_push($output['messages'],$m);
                    /*$output['message'].= '<div class="chat outgoing">
                                <div class="details">
                                    <p>' . $row['msg'] . '</p>
                                </div>
                                </div>';*/
                }else{
                    //$m = [];
                    $output['messages'][$row['msg_id']] = ['message' => $row['msg'], 'direction' => 'in'];

                    //array_push($output['messages'],$m);

                    /*$output['message'].= '<div class="chat incoming">
                                <div class="details">
                                    <p>'. $row['msg'] .'</p>
                                </div>
                                </div>';*/
                }
            }
        }else{
            $output['message'] = '<div class="text">No messages are available. Once you send message they will appear here.</div>';
        }
        //array_push($output);
        echo json_encode($output);
    }else{
        header("location: ../index.php");
    }
?>