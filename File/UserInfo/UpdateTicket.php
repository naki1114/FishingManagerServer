<?php
  // 서버 연결
  include_once '../ConnectServer.php';

  if ($connect) {
    // 연결 성공
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $nickname = $_POST['nickname'];
      $product = $_POST['product'];

      if ($product == "어종 확인 한 달 이용권") {
        $ticketQuery = "UPDATE userInfo SET checkingFishTicket = 30 WHERE nickname = '$nickname';";
        $result = mysqli_query($connect, $ticketQuery);
      }
      elseif ($product == "어종 확인 일 년 이용권") {
        $ticketQuery = "UPDATE userInfo SET checkingFishTicket = 365 WHERE nickname = '$nickname';";
        $result = mysqli_query($connect, $ticketQuery);
      }
      
      // UserInfo
      $getUserInfoQuery = "SELECT nickname, profileImage, checkingFishCount, checkingFishTicket, removeAdTicket, type FROM userInfo WHERE nickname='$nickname';";
      $resultUserInfo = mysqli_query($connect, $getUserInfoQuery);
      $row = mysqli_fetch_array($resultUserInfo);
      $userInfo = array("nickname" => $row[0],
                        "profileImage" => $row[1],
                        "checkingFishCount" => $row[2],
                        "checkingFishTicket" => $row[3],
                        "removeAdTicket" => $row[4],
                        "type" => $row[5]);

      echo json_encode($userInfo, JSON_UNESCAPED_UNICODE);

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