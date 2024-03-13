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
        $getUserInfoQuery = "SELECT nickname, profileImage, checkingFishCount, checkingFishTicket, removeAdTicket FROM userInfo WHERE nickname='$nickname';";
        $resultUserInfo = mysqli_query($connect, $getUserInfoQuery);
        $row = mysqli_fetch_assoc($resultUserInfo);
        $userInfo = array("nickname" => $row['nickname'],
                          "profileImage" => $row['profileImage'],
                          "checkingFishCount" => $row['checkingFishCount'],
                          "checkingFishTicket" => $row['checkingFishTicket'],
                          "removeAdTicket" => $row['removeAdTicket']);

        echo json_encode($userInfo, JSON_UNESCAPED_UNICODE);
  
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