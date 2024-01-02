<?php
// 連接到資料庫
$conn = new mysqli("localhost", "root", "", "資料庫作業v.2");

// 檢查連接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 獲取從前端發送的表單數據
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentId = $_POST["studentId"];
    $weight = $_POST["weight"];
    $height = $_POST["height"];
    $bmi = $_POST["bmi"];
    $status = $_POST["status"]; // 期初或期末的狀態

    // 根據狀態區分欄位
    $weight_column = ($status == 'initial') ? 'Initial_Weight' : 'Final_Weight';
    $height_column = ($status == 'initial') ? 'Initial_Height' : 'Final_Height';
    $bmi_column = ($status == 'initial') ? 'Initial_BMI' : 'Final_BMI';

    // 使用 INSERT INTO ... ON DUPLICATE KEY UPDATE 語句
    $sql = "INSERT INTO `body_measurements` (`S_Id`, `$weight_column`, `$height_column`, `$bmi_column`)
            VALUES ('$studentId', '$weight', '$height', '$bmi')
            ON DUPLICATE KEY UPDATE
            `$weight_column` = VALUES(`$weight_column`), 
            `$height_column` = VALUES(`$height_column`), 
            `$bmi_column` = VALUES(`$bmi_column`)";

    // 執行 SQL 語句
    if ($conn->query($sql) === TRUE) {
        echo "更新成功";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "無效的請求";
}

// 關閉資料庫連線
$conn->close();
?>
