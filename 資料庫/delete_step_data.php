<?php
// 連接到資料庫
$conn = new mysqli("localhost", "root", "", "資料庫作業v.2");

// 檢查連接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 獲取表單數據
$studentId = $_POST["studentId"];
$date = $_POST["date"];

// 使用 DELETE 語句刪除步數資料
$sql = "DELETE FROM step_record WHERE S_Id = '$studentId' AND Date = '$date'";

// 執行 SQL 語句
if ($conn->query($sql) === TRUE) {
    echo "步數資料刪除成功";
} else {
    echo "Error deleting step data: " . $conn->error;
}

// 關閉資料庫連線
$conn->close();
?>
