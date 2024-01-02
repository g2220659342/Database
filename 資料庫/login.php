    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $student_id = $_POST["student_id"];
        $password = $_POST["password"];

        // 連接到資料庫
        $conn = new mysqli("localhost", "root", "", "資料庫作業v.2");

        // 檢查連接
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

    // 檢查是否有相應的學號存在
    $query = "SELECT * FROM students WHERE S_Id = '$student_id'";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        // 學號存在，檢查密碼是否正確
        $query = "SELECT * FROM students WHERE S_Id = '$student_id' AND Password = '$password'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // 登入成功
            echo "<script>alert('登入成功');</script>";
// 獲取使用者資訊
            $user = $result->fetch_assoc();
// 將使用者資訊存儲在 session 中
            session_start();
            $_SESSION["S_Id"] = $user["S_Id"];
            echo "<script>setTimeout(function(){ window.location.href = 'Body.html'; }, 500);</script>";
        } else {
            // 學號存在但密碼錯誤
            echo "<script>alert('密碼錯誤');</script>";
            echo "<script>window.history.back();</script>";
        }
    } else {
        // 學號不存在
        echo "<script>alert('查無此帳號');</script>";
        echo "<script>window.history.back();</script>";
    }
    

        // 關閉資料庫連接
        $conn->close();
    }
    ?>