<?php
  // 서버 연결
  include_once '../ConnectServer.php';

  if ($connect) {
    // 연결 성공
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      // ArrayList<Feed>
      $getFeedQuery = "SELECT nickname, profileImage, num, title, content, picture, viewCount, date FROM feed;";
      $resultFeed = mysqli_query($connect, $getFeedQuery);
      $arrayFeed = array();

      while ($row = mysqli_fetch_array($resultFeed)) {
        array_push($arrayFeed, array("viewCount" => $row[6],
                                     "feedNum" => $row[2],
                                     "title" => $row[3],
                                     "content" => $row[4],
                                     "feedImage" => $row[5],
                                     "nickname" => $row[0],
                                     "date" => $row[7],
                                     "profileImage" => $row[1]));
      }

      $arrayFeed = array_reverse($arrayFeed);

      echo json_encode($arrayFeed, JSON_UNESCAPED_UNICODE);

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