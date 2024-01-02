<?php
// 連接到資料庫
$conn = new mysqli("localhost", "root", "", "資料庫作業v.2");

// 檢查連接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 獲取表單數據
$studentId = $_POST["studentId"];
$bloodPressureH = $_POST["bloodPressureH"];
$bloodPressureL = $_POST["bloodPressureL"];
$heartRate = $_POST["heartRate"];
$bloodSugar = $_POST["bloodSugar"];
$cholesterol = $_POST["cholesterol"];
$sickHistory = $_POST["sickHistory"];

// 使用 UPDATE 語句更新健康資料
$sql = "UPDATE health_status SET 
        Blood_Pressure_H = '$bloodPressureH',
        Blood_Pressure_L = '$bloodPressureL',
        Heart_Rate = '$heartRate',
        Blood_Sugar = '$bloodSugar',
        Cholesterol = '$cholesterol',
        Sick_History = '$sickHistory'
        WHERE S_Id = '$studentId'";

// 執行 SQL 語句
if ($conn->query($sql) === TRUE) {
    echo "健康資料更新成功";
} else {
    echo "Error updating health data: " . $conn->error;
}

// 關閉資料庫連線
$conn->close();
?>
