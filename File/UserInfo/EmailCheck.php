<?php
  // 서버 연결
  include_once '../ConnectServer.php';

  if ($connect) {
    // 연결 성공
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $id = $_POST['id'];
      $layout = $_POST['layout'];

      if ($layout == "signup") {

        if ($id) {
          $duplicateCheckQuery = "SELECT * FROM userInfo WHERE id='$id'";
          $result = mysqli_query($connect, $duplicateCheckQuery);
    
          if (mysqli_num_rows($result) > 0) {  
            echo "unusableID";
          }
          else {
            echo "usableID";
          }
          mysqli_close($connect);
        }

      }
      else {
        
        if ($id) {
          $emailCheckQuery = "SELECT * FROM userInfo WHERE id='$id'";
          $result = mysqli_query($connect, $emailCheckQuery);
    
          if (mysqli_num_rows($result) == 1) {  
            echo "usableID";
          }
          else {
            echo "unusableID";
          }
          mysqli_close($connect);
        }

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