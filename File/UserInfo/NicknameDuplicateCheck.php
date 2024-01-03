<?php
  // 서버 연결
  include_once '../ConnectServer.php';

  if ($connect) {
    // 연결 성공
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $nickname = $_POST['nickname'];
    
      if ($nickname) {
        $duplicateCheckQuery = "SELECT * FROM userInfo WHERE nickname='$nickname'";
        $result = mysqli_query($connect, $duplicateCheckQuery);
  
        if (mysqli_num_rows($result) > 0) {  
          echo "unusableNickname";
        }
        else {
          echo "usableNickname";
        }
        mysqli_close($connect);
      }
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