<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 獲取表單數據
    $fitnessStatus = $_POST["fitnessStatus"];
    $runTime = $_POST["runTime"];
    $longJump = $_POST["longJump"];
    $sitUps = $_POST["sitUps"];
    $bend = $_POST["bend"];

    // 確認是否有登入的學生
    if (!isset($_SESSION["S_Id"])) {
        // 如果沒有，重定向到登入頁面
        header("Location: login.html");
        exit;
    }

    // 使用 $_SESSION["S_Id"] 取得登入學生的學號
    $student_id = $_SESSION["S_Id"];

    // 連接到資料庫
    $conn = new mysqli("localhost", "root", "", "資料庫作業v.2");

    // 檢查連接
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 根據狀態區分欄位
    $runTime_column = ($fitnessStatus == 'initial') ? 'Initial_Run' : 'Final_Run';
    $longJump_column = ($fitnessStatus == 'initial') ? 'Initial_Long_Jump' : 'Final_Long_Jump';
    $sitUps_column = ($fitnessStatus == 'initial') ? 'Initial_Sit_Ups' : 'Final_Sit_Ups';
    $bend_column = ($fitnessStatus == 'initial') ? 'Initial_Bend' : 'Final_Bend';

    // 檢查資料庫中是否已經存在相關的學生體適能資料
    $query = "SELECT * FROM physical_fitness WHERE S_Id = '$student_id'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // 學生體適能資料已存在，執行更新的 SQL 語句
        $sql = "UPDATE physical_fitness SET 
                $runTime_column = '$runTime', 
                $longJump_column = '$longJump', 
                $sitUps_column = '$sitUps', 
                $bend_column = '$bend' 
                WHERE S_Id = '$student_id'";
    } else {
        // 學生體適能資料不存在，執行插入的 SQL 語句
        $sql = "INSERT INTO physical_fitness (S_Id, $runTime_column, $longJump_column, $sitUps_column, $bend_column) 
                VALUES ('$student_id', '$runTime', '$longJump', '$sitUps', '$bend')";
    }

    // 執行 SQL 語句
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('更新成功');</script>";
        echo "<script>window.history.back();</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // 關閉資料庫連線
    $conn->close();
}
?>
