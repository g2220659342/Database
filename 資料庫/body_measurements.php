<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 檢查是否有登入的學生
    if (!isset($_SESSION["S_Id"])) {
        // 如果沒有，重定向到登入頁面
        header("Location: login.html");
        exit;
    }

    // 使用 $_SESSION["S_Id"] 取得登入學生的學號
    $student_id = $_SESSION["S_Id"];

    // 獲取表單數據
    $weight = $_POST["weight"];
    $height = $_POST["height"];
    $bmi = $_POST["bmi"];
    $status = $_POST["status"]; // 期初或期末的狀態

    // 連接到資料庫
    $conn = new mysqli("localhost", "root", "", "資料庫作業v.2");

    // 檢查連接
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 根據狀態區分欄位
    $weight_column = ($status == 'initial') ? 'Initial_Weight' : 'Final_Weight';
    $height_column = ($status == 'initial') ? 'Initial_Height' : 'Final_Height';
    $bmi_column = ($status == 'initial') ? 'Initial_BMI' : 'Final_BMI';

    // 使用 INSERT INTO ... ON DUPLICATE KEY UPDATE 語句
    $sql = "INSERT INTO `body_measurements` (`S_Id`, `$weight_column`, `$height_column`, `$bmi_column`)
            VALUES ('$student_id', '$weight', '$height', '$bmi')
            ON DUPLICATE KEY UPDATE
            `$weight_column` = VALUES(`$weight_column`), 
            `$height_column` = VALUES(`$height_column`), 
            `$bmi_column` = VALUES(`$bmi_column`)";

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
