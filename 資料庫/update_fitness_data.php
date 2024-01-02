<?php
// 連接到資料庫
$conn = new mysqli("localhost", "root", "", "資料庫作業v.2");

// 檢查連接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 獲取表單數據
$studentId = $_POST["studentId"];
$run = $_POST["run"];
$longJump = $_POST["longJump"];
$sitUps = $_POST["sitUps"];
$bend = $_POST["bend"];
$fitnessStatus = $_POST["fitnessStatus"];

// 根據狀態區分欄位
$initialRunColumn = ($fitnessStatus == 'initial') ? 'Initial_Run' : 'Final_Run';
$initialLongJumpColumn = ($fitnessStatus == 'initial') ? 'Initial_Long_Jump' : 'Final_Long_Jump';
$initialSitUpsColumn = ($fitnessStatus == 'initial') ? 'Initial_Sit_Ups' : 'Final_Sit_Ups';
$initialBendColumn = ($fitnessStatus == 'initial') ? 'Initial_Bend' : 'Final_Bend';

// 使用 UPDATE 語句更新體適能資料
$sql = "UPDATE physical_fitness SET 
        $initialRunColumn = '$run',
        $initialLongJumpColumn = '$longJump',
        $initialSitUpsColumn = '$sitUps',
        $initialBendColumn = '$bend'
        WHERE S_Id = '$studentId'";

// 執行 SQL 語句
if ($conn->query($sql) === TRUE) {
    echo "體適能資料更新成功";
} else {
    echo "Error updating fitness data: " . $conn->error;
}

// 關閉資料庫連線
$conn->close();
?>
