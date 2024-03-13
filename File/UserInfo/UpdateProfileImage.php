<?php
  // 서버 연결
  include_once '../ConnectServer.php';

  if ($connect) {
    // 연결 성공
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $nickname = $_POST['nickname'];

      if ($_FILES) {

        $uploadDir = '../../Image/ProfileImage/';
        $uploadedFile = $uploadDir.basename($_FILES['uploadFile']['name']);
        move_uploaded_file($_FILES['uploadFile']['tmp_name'], $uploadedFile);
  
        $profileImage = "Image/ProfileImage/".$_FILES['uploadFile']['name'];
  
        $updateProfileImageQuery = "UPDATE userInfo SET profileImage = '$profileImage' WHERE nickname = '$nickname';";
        $resultUpdate = mysqli_query($connect, $updateProfileImageQuery);
        $updateProfileImageQuery = "UPDATE feed SET profileImage = '$profileImage' WHERE nickname = '$nickname';";
        $resultUpdate = mysqli_query($connect, $updateProfileImageQuery);
        $updateProfileImageQuery = "UPDATE history SET profileImage = '$profileImage' WHERE nickname = '$nickname';";
        $resultUpdate = mysqli_query($connect, $updateProfileImageQuery);

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

        // ArrayList<Collection>
        $getCollectionQuery = "SELECT * FROM collection;";
        $resultCollection = mysqli_query($connect, $getCollectionQuery);
        $arrayCollection = array();

        while ($row = mysqli_fetch_array($resultCollection)) {
          array_push($arrayCollection, array("nickname" => $row[0],
                                            "fishName" => $row[1],
                                            "date" => $row[2]));
        }

        // ArrayList<History>
        $getHistoryQuery = "SELECT * FROM history;";
        $resultHistory = mysqli_query($connect, $getHistoryQuery);
        $arrayHistory = array();

        while ($row = mysqli_fetch_array($resultHistory)) {
          array_push($arrayHistory, array("nickname" => $row[0],
                                          "profileImage" => $row[1],
                                          "fishName" => $row[2],
                                          "fishImage" => $row[3],
                                          "date" => $row[4]));
        }

        $arrayHistory = array_reverse($arrayHistory);

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

        rsort($arrayFeed);

        echo json_encode(array("userInfo" => $userInfo,
                              "collection" => $arrayCollection,
                              "history" => $arrayHistory,
                              "feed" => $arrayFeed), JSON_UNESCAPED_UNICODE);

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