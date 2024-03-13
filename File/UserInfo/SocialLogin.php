<?php
  // 서버 연결
  include_once '../ConnectServer.php';

  if ($connect) {
    // 연결 성공
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $id = $_POST['id'];
      $nickname = $_POST['nickname'];
      $profileImage = $_POST['profileImage'];
      $type = $_POST['type'];

      $socialCheckQuery = "SELECT * FROM userInfo WHERE id = '$id' AND nickname = '$nickname' AND type = '$type';";
      $result = mysqli_query($connect, $socialCheckQuery);

      if (mysqli_num_rows($result) == 1) {
        echo "successLogin $nickname";
      }
      elseif (mysqli_num_rows($result) == 0) {
        $saveUserInfoQuery = "INSERT INTO userInfo(id, nickname, profileImage, checkingFishCount, checkingFishTicket, removeAdTicket, type) VALUES('$id', '$nickname', '$profileImage', 3, 0, 0, '$type');";
        mysqli_query($connect, $saveUserInfoQuery);
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