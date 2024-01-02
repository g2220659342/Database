<?php
session_start();

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

// 查詢所有資料類型的 SQL 語句
$sql_body = "SELECT * FROM body_measurements WHERE S_Id = '$student_id'";
$sql_health = "SELECT * FROM health_status WHERE S_Id = '$student_id'";
$sql_fitness = "SELECT * FROM physical_fitness WHERE S_Id = '$student_id'";
$sql_steps = "SELECT * FROM step_record WHERE S_Id = '$student_id'";
$sql_exercise = "SELECT * FROM daily_work WHERE S_Id = '$student_id'";

// 執行查詢
$result_body = $conn->query($sql_body);
$result_health = $conn->query($sql_health);
$result_fitness = $conn->query($sql_fitness);
$result_steps = $conn->query($sql_steps);
$result_exercise = $conn->query($sql_exercise);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Query Results</title>
</head>
<body>

<!-- 顯示身體資料 -->
<div>
    <h2>身體資料</h2>
    <?php
    if ($result_body->num_rows > 0) {
        while ($row = $result_body->fetch_assoc()) {
            // 根據需求顯示每行資料
            echo "學號: " . $row["S_Id"] . " <br> " . "期初體重: ". $row["Initial_Weight"] . "<br>". "期初身高: ". $row["Initial_Height"] . "<br>"
            . "期初BMI: ". $row["Initial_BMI"] . "<br>". "期末體重: ". $row["Final_Weight"] . "<br>". "期末身高: ". $row["Final_Height"] . "<br>". "期末BMI: "
            . $row["Final_BMI"] . "<br>";
        }
    } else {
        echo "查詢結果為空";
    }
    ?>
</div>

<!-- 顯示健康資料 -->
<div>
    <h2>健康資料</h2>
    <?php
    // 顯示健康資料
    // ...
    if ($result_health->num_rows > 0) {
        while ($row = $result_health->fetch_assoc()) {
            // 根據需求顯示每行資料
            echo "血壓: " . $row["Blood_Pressure_H"] . "/". $row["Blood_Pressure_L"] . " <br> " . "心率: ". $row["Heart_Rate"] . "<br>". "血糖: ". $row["Blood_Sugar"] . "<br>"
            . "類固醇: ". $row["Cholesterol"] . "<br>". "病史: ". $row["Sick_History"] . "<br>";
        }
    } else {
        echo "查詢結果為空";
    }
    ?>
</div>

<!-- 顯示體適能資料 -->
<div>
    <h2>體適能資料</h2>
    <?php
    // 顯示體適能資料
    // ...
    if ($result_fitness->num_rows > 0) {
        while ($row = $result_fitness->fetch_assoc()) {
            // 根據需求顯示每行資料
            echo "期初長跑成績: " . $row["Initial_Run"] . " <br> " . "期初跳遠成績: ". $row["Initial_Long_Jump"] ."公尺". "<br>". "期初仰臥起坐成績: ". $row["Initial_Sit_Ups"]. "下". "<br>"
            . "期初坐姿體前彎成績: ". $row["Initial_Bend"] . "<br>". "期末長跑成績: " . $row["Final_Run"] . " <br> " . "期末跳遠成績: ". $row["Final_Long_Jump"] ."公尺". "<br>". "期末仰臥起坐成績: ". $row["Final_Sit_Ups"]. "下". "<br>"
            . "期末坐姿體前彎成績: ". $row["Final_Bend"] . "<br>";
        }
    } else {
        echo "查詢結果為空";
    }
    ?>
</div>

<!-- 顯示每日步數資料 -->
<div>
    <h2>每日步數資料</h2>
    <?php
    // 顯示每日步數資料
    // ...
    if ($result_steps->num_rows > 0) {
        while ($row = $result_steps->fetch_assoc()) {
            // 根據需求顯示每行資料
            echo "日期: " . $row["Date"] . " <br> " . "步數: ". $row["Steps"] . "<br>";
        }
    } else {
        echo "查詢結果為空";
    }
    ?>
</div>

<!-- 顯示每日健身資料 -->
<div>
    <h2>每日健身資料</h2>
    <?php
    // 顯示每日健身資料
    // ...
    if ($result_exercise->num_rows > 0) {
        while ($row = $result_exercise->fetch_assoc()) {
            // 根據需求顯示每行資料
            echo "日期: " . $row["Date"] . " <br> " . "重量: ". $row["Weight"] ."公斤". "<br>". "組數(12下為一組): ". $row["times"] ."組". "<br>";
        }
    } else {
        echo "查詢結果為空";
    }
    ?>
</div>
<!-- 關閉資料庫連線 -->
<?php $conn->close(); ?>

</body>
</html>
