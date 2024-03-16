<?php
  // 서버 연결
  include_once '../ConnectServer.php';

  if ($connect) {
    // 연결 성공
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $nickname = ['nickname'];
      $product = ['product'];

      if ($product == "FM 세트 한 달 이용권") {
        $ticketQuery = "UPDATE userInfo SET checkingFishTicket = 30, removeAdTicket = 30 WHERE nickname = '$nickname';";
        $result = mysqli_query($connect, $ticketQuery);
        echo "success";
      }
      elseif ($product == "FM 세트 일 년 이용권") {
        $ticketQuery = "UPDATE userInfo SET checkingFishTicket = 365, removeAdTicket = 365 WHERE nickname = '$nickname';";
        $result = mysqli_query($connect, $ticketQuery);
        echo "success";
      }
      elseif ($product == "어종 확인 한 달 이용권") {
        $ticketQuery = "UPDATE userInfo SET checkingFishTicket = 30 WHERE nickname = '$nickname';";
        $result = mysqli_query($connect, $ticketQuery);
        echo "success";
      }
      elseif ($product == "어종 확인 일 년 이용권") {
        $ticketQuery = "UPDATE userInfo SET checkingFishTicket = 365 WHERE nickname = '$nickname';";
        $result = mysqli_query($connect, $ticketQuery);
        echo "success";
      }
      elseif ($product == "광고 제거 한 달 이용권") {
        $ticketQuery = "UPDATE userInfo SET removeAdTicket = 30 WHERE nickname = '$nickname';";
        $result = mysqli_query($connect, $ticketQuery);
        echo "success";
      }
      elseif ($product == "광고 제거 일 년 이용권") {
        $ticketQuery = "UPDATE userInfo SET removeAdTicket = 365 WHERE nickname = '$nickname';";
        $result = mysqli_query($connect, $ticketQuery);
        echo "success";
      }
      else {
        echo "fail";
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