<?php

session_start();
ob_start();
$version = '';

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
}

$staffPerms = $_SESSION['perms'];
$user = $_SESSION['user'];

$houseID = $_POST['hidden'];

include 'verifyPanel.php';
masterconnect();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Admin Panel - Houses</title>
    <link href="dist/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="styles/dashboard.css" rel="stylesheet">
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

  </head>

  <body>

<?php
include 'header/header.php';
?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px">Edit Houses</h1>
		  <p class="page-header">Edit houses menu of the panel, allows you to change values in more depth.</p>
          <div id="alert-area"></div>
            <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>Container Inventory</th>
					<th>Container Gear</th>
                    <th>Container Active</th>
                    <th>Container Owned</th>
                </tr>
              </thead>
              <tbody>

<?php


$sqlget = "SELECT * FROM containers WHERE id='$houseID';";
$search_result = mysqli_query($dbcon, $sqlget) or die('Connection could not be established');

while ($row = mysqli_fetch_array($search_result, MYSQLI_ASSOC)) {
    echo '<tr>';
    echo '<td>' ?>
    <input class="form-control" onBlur="dbSave(this.value, '<?php echo $row['id']; ?>', 'inventory')"; type=text value= '<?php echo $row['inventory']; ?>' >
    <?php
    echo '</td>';
    echo '<td>' ?>
    <input class="form-control" onBlur="dbSave(this.value, '<?php echo $row['id']; ?>', 'gear')"; type=text value= '<?php echo $row['gear']; ?>' >
    <?php
    echo '</td>';
    echo '<td>' ?>
    <input class="form-control" onBlur="dbSave(this.value, '<?php echo $row['id']; ?>', 'active')"; type=text value= "<?php echo $row['active']; ?>" >
    <?php
    echo '</td>';
    echo '<td>' ?>
    <input class="form-control" onBlur="dbSave(this.value, '<?php echo $row['id']; ?>', 'ownedCrate')"; type=text value= "<?php echo $row['owned']; ?>" >
    <?php
    echo '</td>';
    echo '</tr>';
}
  echo '</table></div>';
  ?>

  <script>
  function newAlert (type, message) {
      $("#alert-area").append($("<div class='alert " + type + " fade in' data-alert><p> " + message + " </p></div>"));
      $(".alert").delay(2000).fadeOut("slow", function () { $(this).remove(); });
  }


  function dbSave(value, uid, column){

      newAlert('alert-success', 'Value Updated!');

      $.post('Backend/updateHouses.php',{column:column, editval:value, id:uid},
      function(){
          //alert("Sent values.");
      });
  }
  </script>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="/dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
