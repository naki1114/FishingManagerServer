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

      $getProfileImageQuery = "SELECT profileImage FROM userInfo WHERE nickname = '$nickname';";
      $resultQuery = mysqli_query($connect, $getProfileImageQuery);
      $row = mysqli_fetch_array($resultQuery);
      $profileImage = $row[0];

      if ($_FILES) {

        $uploadDir = '../../Image/FeedImage/';
        $uploadedFile = $uploadDir.basename($_FILES['uploadFile']['name']);
        move_uploaded_file($_FILES['uploadFile']['tmp_name'], $uploadedFile);
  
        $picture = "Image/FeedImage/".$_FILES['uploadFile']['name'];
  
        $insertFeedQuery = "INSERT INTO feed(nickname, profileImage, title, content, picture, viewCount, date) VALUES('$nickname', '$profileImage', '$title', '$content', '$picture', 0, '$date');";
        $resultFeed = mysqli_query($connect, $insertFeedQuery);
  
      }
      else {
        
        $insertFeedQuery = "INSERT INTO feed(nickname, profileImage, title, content, viewCount, date) VALUES('$nickname', '$profileImage', '$title', '$content', 0, '$date');";
        $resultFeed = mysqli_query($connect, $insertFeedQuery);
  
      }

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