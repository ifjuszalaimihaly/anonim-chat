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
    <section class="users">
      <header>
        <div class="content">
            Please wait while we found a partner for you
            <a href="php/logout.php?logout_id=<?php echo $_SESSION['unique_id']; ?>" class="logout">Logout</a>
        </div>
      </header>
    </section>
  </div>

  <script src="javascript/users.js"></script>

</body>
</html>
