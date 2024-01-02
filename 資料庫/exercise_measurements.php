<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 確認是否有登入的學生
    if (!isset($_SESSION["S_Id"])) {
        // 如果沒有，重定向到登入頁面
        header("Location: login.php");
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

    // 獲取表單數據
    $sportId1 = $_POST["sportId1"];
    $weight1 = $_POST["weight1"];
    $times1 = $_POST["times1"];
    $Date = $_POST['Date']; // 修正此行，讓它正確

    // 插入或更新資料的 SQL 語句
    $sql = "INSERT INTO daily_work (S_Id, Sport_Id, Date, Weight, Times) 
        VALUES ('$student_id', '$sportId1', '$Date', '$weight1', '$times1')
        ON DUPLICATE KEY UPDATE Weight = '$weight1', Times = '$times1'";

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
