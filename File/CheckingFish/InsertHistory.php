<?php
  // 서버 연결
  include_once '../ConnectServer.php';

  if ($connect) {
    // 연결 성공
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $nickname = $_POST['nickname'];
      $fishName = $_POST['fish'];
      $date = $_POST['date'];

      $collectionCheckQuery = "SELECT * FROM collection WHERE nickname = '$nickname' AND fishName = '$fishName';";
      $resultCheck = mysqli_query($connect, $collectionCheckQuery);

      if (mysqli_num_rows($resultCheck) == 0) {

        $insertCollectionQuery = "INSERT INTO collection(nickname, fishName, date) VALUES('$nickname', '$fishName', '$date');";
        $resultInsertCollection = mysqli_query($connect, $insertCollectionQuery);

      } 

      if ($_FILES) {

        $uploadDir = '../../Image/CheckingFishImage/';
        $uploadedFile = $uploadDir.basename($_FILES['uploadFile']['name']);
        move_uploaded_file($_FILES['uploadFile']['tmp_name'], $uploadedFile);
  
        $fishImage = "Image/CheckingFishImage/".$_FILES['uploadFile']['name'];
  
        $insertHistoryQuery = "INSERT INTO history(nickname, fishName, fishImage, date) VALUES('$nickname', '$fishName', '$fishImage', '$date');";
        $resultHistory = mysqli_query($connect, $insertHistoryQuery);
  
      }
      
      // ArrayList<History>
      $getHistoryQuery = "SELECT * FROM history;";
      $resultHistory = mysqli_query($connect, $getHistoryQuery);
      $arrayHistory = array();

      while ($row = mysqli_fetch_array($resultHistory)) {
        array_push($arrayHistory, array("nickname" => $row[0],
                                        "fishName" => $row[1],
                                        "fishImage" => $row[2],
                                        "date" => $row[3]));
      }

      $arrayHistory = array_reverse($arrayHistory);

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