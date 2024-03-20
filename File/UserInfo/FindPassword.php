<?php
  // 서버 연결
  include_once '../ConnectServer.php';

  if ($connect) {
    // 연결 성공
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $id = $_POST['id'];
      $password = $_POST['password'];

      if ($id) {

        $updatePasswordQuery = "UPDATE userInfo SET password = '$password' WHERE id = '$id';";
        $result = mysqli_query($connect, $updatePasswordQuery);

        echo "successful";

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