<?php
  // 서버 연결
  include_once '../ConnectServer.php';

  if ($connect) {
    // 연결 성공
    // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      
      // ArrayList<Feed>
      $getFeedQuery = "SELECT nickname, num, title, content, picture, viewCount, date FROM feed;";
      $resultFeed = mysqli_query($connect, $getFeedQuery);
      $arrayFeed = array();

      while ($row = mysqli_fetch_array($resultFeed)) {
        array_push($arrayFeed, array("nickname" => $row[0],
                                     "feedNum" => $row[1],
                                     "title" => $row[2],
                                     "content" => $row[3],
                                     "feedImage" => $row[4],
                                     "viewCount" => $row[5],
                                     "date" => $row[6]));
      }

      echo json_encode($arrayFeed, JSON_UNESCAPED_UNICODE);

    // }
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