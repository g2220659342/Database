<?php
// 連接到資料庫
$conn = new mysqli("localhost", "root", "", "資料庫作業v.2");

// 檢查連接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 獲取選定學生的日期列表
$studentId = $_POST["studentId"];
$sql = "SELECT DISTINCT Date FROM step_record WHERE S_Id = '$studentId'";
$result = $conn->query($sql);

$dateOptions = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dateOptions .= "<option value='" . $row["Date"] . "'>" . $row["Date"] . "</option>";
    }
}

echo $dateOptions;

// 關閉資料庫連線
$conn->close();
?>
