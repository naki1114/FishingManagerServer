!#/usr/bin/php -q
<?php
  // 서버 연결
  include_once '../ConnectServer.php';

  if ($connect) {
    // 연결 성공
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $nickname = $_POST['nickname'];

      $resetQuery = "UPDATE userInfo SET checkingFishCount = 3 WHERE nickname = '$nickname';";
      $resultQuery = mysqli_query($connect, $resetQuery);

      echo "success";
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