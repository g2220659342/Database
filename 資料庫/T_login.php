<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $T_Id = $_POST["T_Id"];
        $T_Password = $_POST["T_Password"];

        // 連接到資料庫
        $conn = new mysqli("localhost", "root", "", "資料庫作業v.2");

        // 檢查連接
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

    // 檢查是否有相應的教師存在
    $query = "SELECT * FROM teacher WHERE T_Id = '$T_Id'";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        // 登入成功
        echo "<script>alert('登入成功');</script>";
        // 獲取使用者資訊
        $user = $result->fetch_assoc();
        // 將使用者資訊存儲在 session 中
        session_start();
        echo "<script>alert('{$user["T_Name"]}教師您好');</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'teacher_query.html'; }, 500);</script>";
   
        } else {
            // 教師存在但密碼錯誤
            echo "<script>alert('密碼錯誤');</script>";
            echo "<script>window.history.back();</script>";
        }
    } else {
        // 教師不存在
        echo "<script>alert('查無此帳號');</script>";
        echo "<script>window.history.back();</script>";
    }
    

        // 關閉資料庫連接
        $conn->close();
    ?>