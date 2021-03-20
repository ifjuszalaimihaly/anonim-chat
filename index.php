<?php 
  session_start();
  if(isset($_SESSION['unique_id'])){
    header("location: users.php");
  }
?>

<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <section class="form signup">
      <header>Realtime Chat App</header>
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text"></div>
            <div class="field input">
                <label>My Gender</label>
                <select name="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class="field input">
                <label>Partner Gender</label>
                <select name="partner" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
        <div class="field button">
          <input type="submit" name="submit" value="Continue to Chat">
        </div>
      </form>
    </section>
  </div>

  <script src="javascript/signup.js"></script>

</body>
</html>
