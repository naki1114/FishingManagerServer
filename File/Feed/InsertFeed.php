<?php
  // 서버 연결
  include_once '../ConnectServer.php';

  if ($connect) {
    // 연결 성공
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $nickname = $_POST['nickname'];
      $title = $_POST['title'];
      $content = $_POST['content'];
      $date = $_POST['date'];

      $insertFeedQuery = "INSERT INTO feed(nickname, title, content, viewCount, date) VALUES('$nickname', '$title', '$content', 0, $date);";
      $resultFeed = mysqli_query($connect, $insertFeedQuery);
      $arrayFeed = array();

      echo $nickname;
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