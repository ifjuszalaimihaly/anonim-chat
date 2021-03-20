<?php 
  session_start();
  include_once "php/config.php";
  if(!isset($_SESSION['unique_id'])){
    header("location: index.php");
  }
?>
<?php include_once "header.php"; ?>
<body>
<div class="wrapper">
    <section class="chat-area">
        <header>
            <?php
            $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
            if(mysqli_num_rows($sql) > 0){
                $row = mysqli_fetch_assoc($sql);
            }else{
                header("location: users.php");
            }
            ?>

                <p>We found a <?php echo $row['gender']; ?> for you</p>
                <a href="php/logout.php?logout_id=<?php echo $_SESSION['unique_id']; ?>" class="logout">Logout</a>

        </header>
        <div class="chat-box">

        </div>
        <form action="#" class="typing-area">
            <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
            <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
            <button><i class="fab fa-telegram-plane"></i></button>
</div>
</section>
</div>

<script src="javascript/chat.js"></script>

</body>
</html>
