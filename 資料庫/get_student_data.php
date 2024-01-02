<?php
// 連接到資料庫
$conn = new mysqli("localhost", "root", "", "資料庫作業v.2");

// 檢查連接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 獲取從前端發送的學生 ID
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["studentId"])) {
    $studentId = $_POST["studentId"];

    // 查詢學生資料
    $sql = "SELECT * FROM students WHERE S_Id = '$studentId'";
    $result = $conn->query($sql);

    // 檢查結果是否存在
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // 構建包含學生資料的關聯數組
        $studentData = array(
            'weight' => $row['Final_Weight'], // 假設這是你的資料庫中的體重欄位名稱
            'height' => $row['Final_Height'], // 假設這是你的資料庫中的身高欄位名稱
            // 其他欄位類似添加
        );

        // 將學生資料轉換為 JSON 格式並輸出
        echo json_encode($studentData);
    } else {
        echo "找不到學生資料";
    }
} else {
    echo "無效的請求";
}

// 關閉資料庫連線
$conn->close();
?>
