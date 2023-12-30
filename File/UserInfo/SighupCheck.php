<?php
  // 서버 연결
  include_once '../ConnectServer.php';

  if ($connect) {
    // 연결 성공
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