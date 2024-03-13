<?php
  // 서버 연결
  include_once '../ConnectServer.php';

  if ($connect) {
    // 연결 성공
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $id = $_POST['id'];
      $type = $_POST['type'];

      $socialCheckQuery = "SELECT nickname FROM userInfo WHERE id = '$id' AND type = '$type';";
      $result = mysqli_query($connect, $socialCheckQuery);
      $row = mysqli_fetch_array($result);
      $nickname = $row[0];

      if (mysqli_num_rows($result) == 1) {
        echo "find $nickname";
      }
      elseif (mysqli_num_rows($result) == 0) {
        echo "lose";
      }

      mysqli_close($connect);
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