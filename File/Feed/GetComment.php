<?php
  // 서버 연결
  include_once '../ConnectServer.php';

  if ($connect) {
    // 연결 성공
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $num = $_POST['feedNum'];
      
      // ArrayList<Comment>
      $getCommentQuery = "SELECT num, nickname, content, date FROM comment WHERE num = '$num';";
      $resultComment = mysqli_query($connect, $getCommentQuery);
      $arrayComment = array();

      while ($row = mysqli_fetch_array($resultComment)) {
        array_push($arrayComment, array("feedNum" => $row[0],
                                     "nickname" => $row[1],
                                     "content" => $row[2],
                                     "date" => $row[3]));
      }

      echo json_encode($arrayComment, JSON_UNESCAPED_UNICODE);

    }
  }
  else {
    // 연결 실패
    echo "접속 실패";
    $error = mysqli_connect_error();
    $errno = mysqli_connect_errno();
    print "$errno : $error\n";
    exit();
  }
?>