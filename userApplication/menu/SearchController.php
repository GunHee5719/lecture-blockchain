<head>
  <meta charset="utf-8">
</head>

<?php
  class SearchController{

    function loadUser($position, $pageNum){
      include("../config.php");

      $mysqli = new mysqli($IP, $NAME, $PASSWORD, $DB);
      $minNum = ($pageNum - 1) * 20;
      $maxNum = $minNum + 20;

      $sql = "SELECT * FROM $position WHERE 1 ORDER BY id DESC LIMIT $minNum, $maxNum";

      $result = $mysqli->query($sql);

      if ($result){
        return $result;
      } else {
        return false;
      }
    }

    function clickUser($position, $pageNum, $userNum){
      include("../config.php");

      $mysqli = new mysqli($IP, $NAME, $PASSWORD, $DB);
      $minNum = $pageNum * 20;
      $maxNum = $minNum + 20;

      $sql = "SELECT * FROM $position WHERE 1 ORDER BY id DESC LIMIT $minNum, $maxNum";

      $result = $mysqli->query($sql);

      $userNum = $userNum % 20;
      $i = 1;

      while ($row = $result->fetch_assoc()){
        if ($i == $userNum){
          return $row;
        } else {
          $i = $i + 1;
        }
      }
    }

    function readingUser($to_id, $from_id, $pageNum){
      include("../config.php");

      $mysqli = new mysqli($IP, $NAME, $PASSWORD, $DB);

      $sql = "INSERT INTO lookup (to_id, to_position, from_id, from_position)";
      $from_position = $_SESSION['userPossition'];
      if ($from_position == 'teacher'){
        $to_position = 'student';
      } else {
        $to_position = 'teacher';
      }

      $sql = $sql." VALUES('$to_id', '$to_position', '$from_id', '$from_position')";

      if ($mysqli->query($sql)){
        echo '<script type="text/javascript">
              alert("Success.");
              location.href="clickedPublicUser.php?pageNum='.$pageNum.'&position='.$to_position.'";
              </script>';
      } else {
        echo '<script type="text/javascript">
              alert("Fail.");
              </script>';
      }
    }

    function registerWaitUser($to_id, $from_id, $type){
      include("../config.php");

      $mysqli = new mysqli($IP, $NAME, $PASSWORD, $DB);
      $from_position = $_SESSION['userPossition'];
      $sql = "SELECT * FROM wait_request WHERE to_id = '$to_id' and from_id = '$from_id' and type = '$type' and from_position = '$from_position'";

      $result = $mysqli->query($sql);
      if ($row = $result->fetch_assoc()){
        echo '<script type="text/javascript">
              alert("Already Request.");
              location.href="../MainPage.php";
              </script>';
      }

      $sql = "INSERT INTO wait_request (to_id, to_position, from_id, from_position, type)";

      $from_position = $_SESSION['userPossition'];
      if ($from_position == 'teacher'){
        $to_position = 'student';
      } else {
        $to_position = 'teacher';
      }

      $sql = $sql." VALUES('$to_id', '$to_position', '$from_id', '$from_position', '$type')";

      if ($mysqli->query($sql)){
        echo '<script type="text/javascript">
              alert("Success.");
              location.href="../MainPage.php";
              </script>';
      } else {
        echo '<script type="text/javascript">
              alert("Fail.");
              </script>';
      }

    }

    function searchLookup($id){
      include("../config.php");

      $mysqli = new mysqli($IP, $NAME, $PASSWORD, $DB);
      $userId = $_SESSION['userId'];
      $sql = "SELECT * FROM lookup WHERE from_id = '$userId' and to_id = '$id'";

      $result = $mysqli->query($sql);
      if ($row = $result->fetch_assoc()){
        return true;
      } else {
        return false;
      }
    }

    function countUser($position){
      include("../config.php");

      $mysqli = new mysqli($IP, $NAME, $PASSWORD, $DB);
      $sql = "SELECT COUNT(*) AS total FROM $position WHERE 1";

      $result = $mysqli->query($sql);
      if ($result){
        $row = $result->fetch_assoc();
        return $row['total'];
      } else {
        return false;
      }
    }
  }
 ?>