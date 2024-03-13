<?php
  // 서버 연결
  include_once '../ConnectServer.php';

  if ($connect) {
    // 연결 성공
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $nickname = $_POST['nickname'];
      $type = $_POST['type'];

      $deleteAccountQuery = "DELETE FROM collection WHERE nickname = '$nickname';
                             DELETE FROM history WHERE nickname = '$nickname';
                             DELETE FROM comment WHERE nickname = '$nickname';
                             DELETE FROM feed WHERE nickname = '$nickname';
                             DELETE FROM userInfo WHERE nickname = '$nickname' AND type = '$type';
                             
                             SET @CNT = 0;
                             UPDATE feed SET num = @CNT := @CNT + 1;
                             ALTER TABLE feed AUTO_INCREMENT = 1;";

      $result = mysqli_multi_query($connect, $deleteAccountQuery);

      $checkUserInfoQuery = "SELECT * FROM userInfo WHERE nickname = '$nickname';";
      $resultUserInfo = mysqli_query($connect, $checkUserInfoQuery);
      $countUserInfo = mysqli_num_rows($resultUserInfo);

      $checkFeedQuery = "SELECT * FROM feed WHERE nickname = '$nickname';";
      $resultFeed = mysqli_query($connect, $checkFeedQuery);
      $countFeed = mysqli_num_rows($resultFeed);

      $checkCommentQuery = "SELECT * FROM comment WHERE nickname = '$nickname';";
      $resultComment = mysqli_query($connect, $checkCommentQuery);
      $countComment = mysqli_num_rows($resultComment);

      $checkHistoryQuery = "SELECT * FROM history WHERE nickname = '$nickname';";
      $resultHistory = mysqli_query($connect, $checkHistoryQuery);
      $countHistory = mysqli_num_rows($resultHistory);

      $checkCollectionQuery = "SELECT * FROM collection WHERE nickname = '$nickname';";
      $resultCollection = mysqli_query($connect, $checkCollectionQuery);
      $countCollection = mysqli_num_rows($resultCollection);

      if ($countUserInfo == 0 && $countFeed == 0 && $countComment == 0 && $countHistory == 0 && $countCollection == 0) {  
        echo "successDelete";
      }
      else {
        echo "failureDelete";
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