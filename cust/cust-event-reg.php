<?php
$connection = mysqli_connect("localhost", "root", "");
if (!$connection) { die("Could not connect: ".mysqli_connect_error()); }
mysqli_select_db($connection, "ydzc_rtl");
$user_id = $_COOKIE["user"];
$sql = "SELECT a.evt_id, a.evt_name, DATE_FORMAT(a.evt_startdt, '%Y-%m-%d') evt_startdt, DATE_FORMAT(a.evt_stopdt, '%Y-%m-%d') evt_stopdt, top_name, b.reg_id FROM ydzc_cust_evt_v a, ydzc_reg b WHERE b.cust_id=$user_id AND a.evt_id=b.evt_id";
$result = mysqli_query($connection, $sql);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title> Search Result </title>
  <link href="../bootstrap.min.css" rel="stylesheet">
  <link href="../bootstrap-table.min.css" rel="stylesheet">
  <script src="../jquery-3.6.0.min.js"></script>
  <script src="../bootstrap.min.js"></script>
  <script src="../bootstrap-table.min.js"></script>
  <script src="../bootstrap-dropdown.js"></script>
  <script src="../application.js"></script>
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
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="cust-book.php">Book<b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="cust-book.php">Search</a></li>
            <li><a href="cust-book-rent.php">Rental</a></li>
          </ul>
        </li>
        <li class="active dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="cust-event.php">Event<b class="caret"></b></a>
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
        <tr><td>Exhibition ID</td><td>Exhibition Name</td><td>Start Date</td><td>End Date</td><td>Status</td><td>Topic</td><td>Registration ID</td></tr>
        <?php
        $cur_dt = date('Y-m-d h:i:s', time());
        while ($row=mysqli_fetch_assoc($result)) {
          $evt_id = $row["evt_id"];
          $top_name = "<td style='vertical-align: middle;'>{$row['top_name']}";
          $reg_id = "<td style='vertical-align: middle;'>{$row['reg_id']}</td>";
          echo "<tr>";
          echo "<td style='vertical-align: middle;'>{$row['evt_id']}</td>";
          echo "<td style='vertical-align: middle;'>{$row['evt_name']}</td>";
          echo "<td style='vertical-align: middle;'>{$row['evt_startdt']}</td>";
          echo "<td style='vertical-align: middle;'>{$row['evt_stopdt']}</td>";
          if (strtotime($row['evt_stopdt'])<strtotime($cur_dt)) {
            echo "<td style='vertical-align: middle;'>Closed</td>";
          } else {
            echo "<td style='vertical-align: middle;'>Available</td>";
          }
          while ($row=mysqli_fetch_assoc($result)) {
            if ($row["evt_id"] == $evt_id) {
              $top_name .= "<br>{$row["top_name"]}";
            } else {
              break;
            }
          }
          $top_name .= "</td>";
          echo $top_name;
          echo $reg_id;
          echo "</tr>";
        }
        ?>
      </table>
    </div>
  </div>

</body>
</html>
