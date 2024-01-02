<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 獲取表單數據
    $bloodPressureH = $_POST["bloodPressureH"];
    $bloodPressureL = $_POST["bloodPressureL"];
    $heartRate = $_POST["heartRate"];
    $bloodSugar = $_POST["bloodSugar"];
    $cholesterol = $_POST["cholesterol"];
    $sickHistory = $_POST["sickHistory"];

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

    // 檢查資料庫中是否已經存在相關的學生健康資料
    $query = "SELECT * FROM health_status WHERE S_Id = '$student_id'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // 學生健康資料已存在，執行更新的 SQL 語句
        $sql = "UPDATE health_status SET 
                Blood_Pressure_H = '$bloodPressureH', 
                Blood_Pressure_L = '$bloodPressureL', 
                Heart_Rate = '$heartRate', 
                Blood_Sugar = '$bloodSugar', 
                Cholesterol = '$cholesterol', 
                Sick_History = '$sickHistory' 
                WHERE S_Id = '$student_id'";
    } else {
        // 學生健康資料不存在，執行插入的 SQL 語句
        $sql = "INSERT INTO health_status (S_Id, Blood_Pressure_H, Blood_Pressure_L, Heart_Rate, Blood_Sugar, Cholesterol, Sick_History) 
                VALUES ('$student_id', '$bloodPressureH', '$bloodPressureL', '$heartRate', '$bloodSugar', '$cholesterol', '$sickHistory')";
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
