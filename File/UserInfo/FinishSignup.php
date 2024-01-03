<?php
  // 서버 연결
  include_once '../ConnectServer.php';

  if ($connect) {
    // 연결 성공
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $id = $_POST['id'];
      $password = $_POST['password'];
      $nickname = $_POST['nickname'];

      if ($id) {
        $duplicateCheckQuery = "SELECT * FROM userInfo WHERE id='$id'";
        $result = mysqli_query($connect, $duplicateCheckQuery);
  
        if (mysqli_num_rows($result) > 0) {  
          echo "unusableID";
        }
        else {
          if ($nickname) {
            $duplicateCheckQuery = "SELECT * FROM userInfo WHERE nickname='$nickname'";
            $result = mysqli_query($connect, $duplicateCheckQuery);
      
            if (mysqli_num_rows($result) > 0) {  
              echo "unusableNickname";
            }
            else {
              $saveUserInfoQuery = "INSERT INTO userInfo(id, password, nickname, checkingFishCount, checkingFishTicket, removeAdTicket, type) VALUES('$id', '$password', '$nickname', '3', '0', '0', 'FM');";
              $result = mysqli_query($connect, $saveUserInfoQuery);
              echo "usable";
            }
            mysqli_close($connect);
          }
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