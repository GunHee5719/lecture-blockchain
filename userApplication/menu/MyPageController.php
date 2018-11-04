<head>
  <meta charset="utf-8">
</head>

<?php
  class MyPageController{
    function loadUser($position,$id, $pageNum){
      include("../config.php");

      $mysqli = new mysqli($IP, $NAME, $PASSWORD, $DB);
      $minNum = ($pageNum - 1) * 20;
      $maxNum = $minNum + 20;

      // 학생일 경우 선생 table과, 선생일 경우 학생 table과 join 된다.
      if($position == 'teacher'){
        $sql = "SELECT * FROM student JOIN complete_request ON id=student_id WHERE teacher_id='$id' ORDER BY id DESC LIMIT $minNum, $maxNum";
      }
      else{
        $sql = "SELECT * FROM teacher JOIN complete_request ON id=teacher_id WHERE student_id='$id' ORDER BY id DESC LIMIT $minNum, $maxNum";
      }

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
