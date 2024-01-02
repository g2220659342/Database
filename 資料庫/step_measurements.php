<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 獲取表單數據
    $stepDate = $_POST["stepDate"];
    $stepCount = $_POST["stepCount"];

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

    // 檢查資料庫中是否已經存在相關的學生步數資料
    $query = "SELECT * FROM step_record WHERE S_Id = '$student_id' AND Date = '$stepDate'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // 學生步數資料已存在，執行更新的 SQL 語句
        $sql = "UPDATE step_record SET Steps = '$stepCount' WHERE S_Id = '$student_id' AND Date = '$stepDate'";
    } else {
        // 學生步數資料不存在，執行插入的 SQL 語句
        $sql = "INSERT INTO step_record (S_Id, Date, Steps) VALUES ('$student_id', '$stepDate', '$stepCount')";
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
