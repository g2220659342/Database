<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 獲取表單數據
    $student_name = $_POST["student_name"];
    $student_id = $_POST["student_id"];
    $department = $_POST["department"];
    $class = $_POST["class"];
    $password = $_POST["Password"]; // 新增獲取密碼

    // 檢查學號是否為 Varchar(9)
    if (strlen($student_id) !== 9) {
        echo "<script>alert('學號必須為9位字元');</script>";
        echo "<script>window.history.back();</script>";
        exit;
    }
    
    // 連接到資料庫
    $conn = new mysqli("localhost", "root", "", "資料庫作業v.2");

    // 檢查連接
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 檢查是否有相同的學號
    $query = "SELECT * FROM students WHERE S_Id = '$student_id'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // 如果有重複的學號，顯示提示框
        echo "<script>alert('已經存在相同學號的學生');</script>";
        echo "<script>window.history.back();</script>";
        exit;
    }

    // 插入資料的 SQL 語句，添加了密碼
    $sql = "INSERT INTO `students` (`S_Name`, `S_Id`, `DPT`, `Class`, `Password`) VALUES ('$student_name', '$student_id', '$department', '$class', '$password')";

    // 執行 SQL 語句    
    if ($conn->query($sql) === TRUE) {
        // 如果插入成功，顯示提示框後再重定向到登入頁面
        echo "<script>alert('學生註冊成功');</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'login.html'; }, 500);</script>";
        exit;
    } else {
        // 如果發生錯誤，顯示錯誤信息
        echo "<script>alert('註冊失敗');</script>";
        echo "<script>window.history.back();</script>";
        exit;
    }

    // 關閉資料庫連線
    $conn->close();
}
?>
