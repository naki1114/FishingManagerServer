<?php
  // 서버 연결
  include_once '../ConnectServer.php';

  if ($connect) {
    // 연결 성공
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $id = $_POST['id'];
      $password = $_POST['password'];

      $loginQuery = "SELECT nickname FROM userInfo WHERE id='$id' AND password='$password';";
      $result = mysqli_query($connect, $loginQuery);

      if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $nickname = $row[0];
        echo "successLogin $nickname";
      }
      else { 
        echo "failureLogin";
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