<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="menu.css">
</head>
<body>

<div id="top_menu">
  <nav class="navbar navbar-darkgray">
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" href="../MainPage.php" style="color:#ffffff;font-size:25px;">LectureChain</a>
      </div>
      <ul class="nav">
        <li><a href="SearchTeacher.php" style="color:#ffffff;font-size:16px;">Search Teacher</a></li>
        <li><a href="SearchStudent.php" style="color:#ffffff;font-size:16px;">Search Student</a></li>
        <li><a href="Requests.php" style="color:#ffffff;font-size:16px;">Requests</a></li>
        <li><a href="MyPage.php" style="color:#ffffff;font-size:16px;">My Page</a></li>
      </ul>
      <ul class="nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" custom-toggle="dropdown-over" style="color:#ffffff;font-size:16px;">
            member
          </a>
          <div class="dropdown-menu" style="min-width:150px;" align="center">
            <div align="center" style="padding-top:5px;padding-bottom:10px;">
              <?php
                session_start();
               ?>
               <table class="table-borderless">
                <tr>
                  <th>Name</th>
                  <td><textfield><?php echo $_SESSION['userName']; ?></textfield></td>
                </tr>
                <tr>
                  <th>Position&nbsp;&nbsp;</th>
                  <td><textfield><?php echo $_SESSION['userPossition']; ?></textfield></td>
                </tr>
                <tr>
                  <th>Coin</th>
                  <td><textfield id='myCoin'></textfield></td>
                </tr>
               </table>
            </div>
            <div align="center">
                <input type="button" value="Log-out" class="btn-warning" onclick="location.href='logout.php'">
            </div>
          </div>
        </li>
      </ul>
    </div>
  </nav>
</div>


<div id="content" align="center">
  <div class="sub-title" align="left" style="padding-bottom:30px;">
    <h3 style="font-weight:bold;">MyPage</h4>
  </div>

  <ul class="nav nav-tabs">
    <li ><a href="MyPage.php" style="color:#3a3f44;">Information</a></li>
    <li ><a href="MyPage_edit.php" style="color:#3a3f44;">Edit</a></li>
    <li ><a href="MyPage_matched.php" style="color:#3a3f44;">Matched List</a></li>
    <li ><a href="MyPage_coin.php" style="color:#3a3f44;">Coin Using</a></li>
    <li class="active"><a href="MyPage_usage.php" style="color:#3a3f44;">Usage History</a></li>
  </ul>


  <div id="request_table" align="center">
    <table class="search-table table table-hover">
      <thead>
        <tr>
          <th scope="col">index</th>
          <th scope="col">Item</th>
          <th scope="col">Coin</th>
          <th scope="col">Time</th>
        </tr>
      </thead>
      <tbody>
        <?php
          if (isset($_GET['pageNum'])){
            $pageNum = $_GET['pageNum'];
          } else {
            $pageNum = 0;
          }

          include("CoinController.php");
          $coinController = new CoinController;

          $position = $_SESSION['userPossition'];
          $id = $_SESSION['userId'];

          $result = $coinController->load($id, $position, $pageNum);
          $pageNum = $pageNum * 20;

          while ($row = $result->fetch_assoc()){
            echo "<tr>";
              echo "<td scope='row'>".($pageNum + 1)."</td>";
              echo "<td scope='row'>".$row['item']."</td>";
              echo "<td scope='row'>".$row['coin']."</td>";
              echo "<td scope='row'>".$row['time']."</td>";
            echo "</tr>";

            $pageNum = $pageNum + 1;
          }
         ?>
      </tbody>
    </table>

    <div class="text-center">
      <ul class="pagination">
        <?php
          $count = $coinController->count($id, $position);
          $count = $count / 21;
          $a = 0;
          while ($a <= $count){
            echo '<li><a href="?pageNum='.$a.'" style="color:black;">'.($a + 1).'</a></li>';
            $a = $a + 1;
          }
         ?>
      </ul>
    </div>
</div>

<script src='https://cdn.jsdelivr.net/gh/ethereum/web3.js/dist/web3.min.js'></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.js"></script>
<script type="text/javascript" src="../TokenWeb3.js"></script>
<script type="text/javascript">
$(window).on("load",function(){
  getUserToken();
});
</script>
</body>
</html>
