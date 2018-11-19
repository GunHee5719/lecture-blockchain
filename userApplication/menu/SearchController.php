<head>
  <meta charset="utf-8">
</head>

<?php
  class SearchController{

    function loadUser($position, $pageNum){
      include("../config.php");

      $mysqli = new mysqli($IP, $NAME, $PASSWORD, $DB);
      $minNum = $pageNum * 20;
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
      $i = 0;

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

      $mysqli->query($sql);

      include('CoinController.php');

      $coinController = new CoinController;

      $coinController->register($from_id, $from_position, "reading", 0);

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
              alert("Already wait Request.");
              location.href="../MainPage.php";
              </script>';

        return;
      }

      if ($_SESSION['userPossition'] == 'teacher'){
        $sql = "SELECT * FROM complete_request WHERE student_id = '$to_id' and teacher_id = '$from_id' and type = '$type' and from_position = '$from_position'";
      } else {
        $sql = "SELECT * FROM complete_request WHERE teacher_id = '$to_id' and student_id = '$from_id' and type = '$type' and from_position = '$from_position'";
      }

      $result = $mysqli->query($sql);
      if ($result){
        echo '<script type="text/javascript">
              alert("Already complete Request.");
              location.href="../MainPage.php";
              </script>';
        return;
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

    function registerReview($teacher_id, $student_id, $type, $grade, $content){
      include("../config.php");

      $mysqli = new mysqli($IP, $NAME, $PASSWORD, $DB);

      $sql = "SELECT time FROM complete_request WHERE teacher_id = '$teacher_id' and student_id = '$student_id' and type = '$type'";

      $result = $mysqli->query($sql);
      $row = $result->fetch_assoc();
      $complete_time = $row['time'];

      $sql = "INSERT INTO review (student_id, teacher_id, type, complete_time, review_time, grade, content)";
      $review_time = date("Y-m-d H:i:s");
      $sql = $sql." VALUES('$student_id', '$teacher_id', '$type', '$complete_time', '$review_time', $grade, '$content')";

      $result = $mysqli->query($sql);
      if ($result){
        echo '<script type="text/javascript">
              alert("Success.");
              location.href="MyPage_matched.php";
              </script>';
      } else {
        return false;
      }
    }

    function searchReview($teacher_id, $student_id, $type){
      include("../config.php");

      $mysqli = new mysqli($IP, $NAME, $PASSWORD, $DB);
      $sql = "SELECT * FROM review WHERE teacher_id = '$teacher_id' and student_id = '$student_id' and type = '$type'";

      $result = $mysqli->query($sql);
      if ($row = $result->fetch_assoc()){
        return $row;
      } else {
        return false;
      }
    }

    function searchReviewList($teacher_id){
      include("../config.php");

      $mysqli = new mysqli($IP, $NAME, $PASSWORD, $DB);
      $sql = "SELECT * FROM review WHERE teacher_id = '$teacher_id'";

      $result = $mysqli->query($sql);
      if ($result){
        return $result;
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
