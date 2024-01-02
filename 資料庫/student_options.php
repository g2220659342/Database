<?php
// 连接到数据库
$conn = new mysqli("localhost", "root", "", "資料庫作業v.2");

// 检查连接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 查詢所有學生ID和姓名
$sql = "SELECT S_Id, S_Name FROM students";
$result = $conn->query($sql);

$options = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='" . $row["S_Id"] . "'>" . $row["S_Name"] . "</option>";
    }
}

// 關閉資料庫連接
$conn->close();

echo $options;
?>