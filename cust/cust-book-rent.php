<?php
$connection = mysqli_connect("localhost", "root", "");
if (!$connection) { die("Could not connect: ".mysqli_connect_error()); }
mysqli_select_db($connection, "ydzc_rtl");
$user_id = $_COOKIE["user"];
$sql1 = "SELECT a.rent_id, a.rent_stat, DATE_FORMAT(a.rent_bordt, '%Y-%m-%d') rent_bordt, DATE_FORMAT(a.rent_erntdt, '%Y-%m-%d') rent_erntdt, DATE_FORMAT(a.rent_arntdt, '%Y-%m-%d') rent_arntdt, a.bkcpy_id, b.bk_title FROM ydzc_cust_rent_v a, ydzc_bk b WHERE a.cust_id=$user_id AND a.bk_isbn=b.bk_isbn";
$result1 = mysqli_query($connection, $sql1);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title> Homepage </title>
  <link href="../bootstrap.min.css" rel="stylesheet">
  <link href="../bootstrap-table.min.css" rel="stylesheet">
  <script src="../jquery-3.6.0.min.js"></script>
  <script src="../bootstrap.min.js"></script>
  <script src="../bootstrap-table.min.js"></script>
  <style type="text/css">td {text-align: center;}</style>
</head>

<body>
  <header>
    <img src="../pictures/header-image.png" width=100% />
  </header>

  <div class="container">
    <div class="row">
      <ul class="nav nav-pills">
        <li><a href="cust-home.php">Home</a></li>
        <li class="active dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="cust-book.php">Book<b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="cust-book.php">Search</a></li>
            <li><a href="cust-book-rent.php">Rental</a></li>
          </ul>
        </li>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="cust-event.php">Event<b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="cust-event.php">Search</a></li>
            <li><a href="cust-event-reg.php">Registered</a></li>
          </ul>
        </li>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="cust-room.php">Study room<b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="cust-room.php">Search</a></li>
            <li><a href="cust-room-resv.php">Reserved</a></li>
          </ul>
        </li>
        <li class="pull-right"><a href="../other/login.html">Logout</a></li>
      </ul>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <table class="table table-striped">
        <tr><td>Rental ID</td><td>Book Title</td><td>Borrow Date</td><td>Expected Return Date</td><td>Actual Return Date</td><td>Rental Status</td><td>Payment</td></tr>
        <?php
        while ($row1=mysqli_fetch_assoc($result1)) {
          echo "<tr>";
          echo "<td style='vertical-align: middle;'>{$row1['rent_id']}</td>";
          echo "<td style='vertical-align: middle;'><form action='cust-book-rent-bkdetail.php' method='post'><button type='submit' class='btn' style='background-color: transparent;' name='bkcpy_id' value='{$row1['bkcpy_id']}'>{$row1['bk_title']}</button></form></td>";
          echo "<td style='vertical-align: middle;'>{$row1['rent_bordt']}</td>";
          echo "<td style='vertical-align: middle;'>{$row1['rent_erntdt']}</td>";
          echo "<td style='vertical-align: middle;'>{$row1['rent_arntdt']}</td>";
          if ($row1['rent_stat']=="B") {
            echo "<td style='vertical-align: middle;'>Borrowed</td>";
          } elseif ($row1['rent_stat']=="L") {
            echo "<td style='vertical-align: middle;'>Late</td>";
          } elseif ($row1['rent_stat']=="R") {
            echo "<td style='vertical-align: middle;'>Returned</td>";
          }
          $sql2 = "SELECT invc_id, invc_rest FROM ydzc_invc WHERE rent_id={$row1['rent_id']}";
          $result2 = mysqli_query($connection, $sql2);
          $row2=mysqli_fetch_assoc($result2);
          if ($row2) {
            echo "<td style='vertical-align: middle;'><form action='cust-book-rent-invcdetail.php' method='post'><button type='submit' class='btn' style='background-color: transparent;' name='invc_id' value='{$row2['invc_id']}'>";
            if ($row2['invc_rest']==0) {
              echo "Finished";
            } else {
              echo "Unfinished";
            }
            echo "</button></form></td>";
          } else {
            echo "<td></td>";
          }
          echo "</tr>";
        }
        ?>
      </table>
    </div>
  </div>

</body>
</html>
