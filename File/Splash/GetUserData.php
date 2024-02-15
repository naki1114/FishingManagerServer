<?php
  // 서버 연결
  include_once '../ConnectServer.php';

  if ($connect) {
    // 연결 성공
    // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $nickname = $_GET['nickname'];

      // UserInfo
      $getUserInfoQuery = "SELECT checkingFishCount, checkingFishTicket, removeAdTicket FROM userInfo WHERE nickname='$nickname';";
      $resultUserInfo = mysqli_query($connect, $getUserInfoQuery);
      $row = mysqli_fetch_array($resultUserInfo);
      $userInfo = array("checkingFishCount" => $row[0],
                        "checkingFishTicket" => $row[1],
                        "removeAdTicket" => $row[2]);

      // ArrayList<Collection>
      $getCollectionQuery = "SELECT * FROM collection;";
      $resultCollection = mysqli_query($connect, $getCollectionQuery);
      $arrayCollection = array();

      while ($row = mysqli_fetch_array($resultCollection)) {
        array_push($arrayCollection, array("nickname" => $row[0],
                                           "fishName" => $row[1],
                                           "fishLength" => $row[2],
                                           "date" => $row[3]));
      }

      // ArrayList<History>
      $getHistoryQuery = "SELECT * FROM history;";
      $resultHistory = mysqli_query($connect, $getHistoryQuery);
      $arrayHistory = array();

      while ($row = mysqli_fetch_array($resultHistory)) {
        array_push($arrayHistory, array("nickname" => $row[0],
                                        "fishName" => $row[1],
                                        "fishImage" => $row[2],
                                        "fishLength" => $row[3],
                                        "date" => $row[4]));
      }

      $arrayHistory = array_reverse($arrayHistory);

      // ArrayList<Feed>
      $getFeedQuery = "SELECT nickname, num, title, content, picture, viewCount, date FROM feed;";
      $resultFeed = mysqli_query($connect, $getFeedQuery);
      $arrayFeed = array();

      while ($row = mysqli_fetch_array($resultFeed)) {
        array_push($arrayFeed, array("viewCount" => $row[5],
                                     "feedNum" => $row[1],
                                     "title" => $row[2],
                                     "content" => $row[3],
                                     "feedImage" => $row[4],
                                     "nickname" => $row[0],
                                     "date" => $row[6]));
      }

      rsort($arrayFeed);

      echo json_encode(array("userInfo" => $userInfo,
                             "collection" => $arrayCollection,
                             "history" => $arrayHistory,
                             "feed" => $arrayFeed), JSON_UNESCAPED_UNICODE);
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