<?php
// 连接到数据库
$conn = new mysqli("localhost", "root", "", "資料庫作業v.2");

if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 查詢學生資料
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["studentId"])) {
    $studentId = $_POST["studentId"];
}

// 查詢學生基本資料
$sqlStudent = "SELECT * FROM students WHERE S_Id = '$studentId'";
$resultStudent = $conn->query($sqlStudent);

// 查詢學生體重身高資料
$sqlBodyMeasurements = "SELECT * FROM body_measurements WHERE S_Id = '$studentId'";
$resultBodyMeasurements = $conn->query($sqlBodyMeasurements);

// 查詢學生健康狀態資料
$sqlHealthStatus = "SELECT * FROM health_status WHERE S_Id = '$studentId'";
$resultHealthStatus = $conn->query($sqlHealthStatus);

// 查詢學生體能資料
$sqlPhysicalFitness = "SELECT * FROM physical_fitness WHERE S_Id = '$studentId'";
$resultPhysicalFitness = $conn->query($sqlPhysicalFitness);

// 輸出步數記錄選項
$stepRecordOptions = ""; // 用於保存步數記錄選項的字串
$sqlStepRecord = "SELECT * FROM step_record WHERE S_Id = '$studentId'";
$resultStepRecord = $conn->query($sqlStepRecord);

// 存儲日期和相應步數的關聯數組
$stepRecordArray = array();

// 檢查步數記錄是否存在
if ($resultStepRecord->num_rows > 0) {
    while ($rowStepRecord = $resultStepRecord->fetch_assoc()) {
        $stepRecordArray[$rowStepRecord["Date"]] = $rowStepRecord["Steps"];
    }
}
    // 按日期排序
    ksort($stepRecordArray);

// 輸出日期選項 for daily work
$dateOptionsDailyWork = ""; // 用於保存 daily work 日期選項的字串
$sqlDatesDailyWork = "SELECT DISTINCT Date FROM daily_work WHERE S_Id = '$studentId'";
$resultDatesDailyWork = $conn->query($sqlDatesDailyWork);

// 存儲日期的數組
$dateArray = array();

// 檢查日期是否存在，再決定是否顯示
if ($resultDatesDailyWork->num_rows > 0) {
    while ($rowDate = $resultDatesDailyWork->fetch_assoc()) {
        $dateArray[] = $rowDate["Date"];
    }

    // 按日期排序
    usort($dateArray, function($a, $b) {
        return strtotime($a) - strtotime($b);
    });

    // 生成排序後的日期選項
    foreach ($dateArray as $date) {
        $dateOptionsDailyWork .= "<option value='" . $date . "'>" . $date . "</option>";
    }


    if ($resultStudent->num_rows > 0) {
        echo "<h3>學生資料：</h3>";
        echo "<table border='1'>";
        echo "<tr><th>學號</th><th>科系</th><th>班級</th></tr>";
        while ($rowStudent = $resultStudent->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $rowStudent["S_Id"] . "</td>";
            echo "<td>" . $rowStudent["DPT"] . "</td>";
            echo "<td>" . $rowStudent["Class"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "找不到學生資料";
    }
// 如果有選擇日期，則處理當天運動資料
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["date"])) {
    $selectedDate = $_POST["date"];
    $sqlDailyWork = "SELECT * FROM daily_work WHERE S_Id = '$studentId' AND Date = '$selectedDate'";
    $resultDailyWork = $conn->query($sqlDailyWork);

    if ($resultDailyWork->num_rows > 0) {
        echo "<h3>學生當天運動資料：</h3>";
        echo "<table border='1'>";
        echo "<tr><th>運動編號</th><th>日期</th><th>重量</th><th>組數</th></tr>";
        while ($rowDailyWork = $resultDailyWork->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $rowDailyWork["Sport_Id"] . "</td>";
            echo "<td>" . $rowDailyWork["Date"] . "</td>";
            echo "<td>" . $rowDailyWork["Weight"] . "</td>";
            echo "<td>" . $rowDailyWork["times"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "找不到學生當天運動資料";
    }
}



// 顯示學生體重身高資料
if ($resultBodyMeasurements->num_rows > 0) {
    echo "<h3>學生體重身高資料：</h3>";
    echo "<table border='1'>";
    echo "<tr><th>期初體重</th><th>期初身高</th><th>期初BMI</th><th>期末體重</th><th>期末身高</th><th>期末BMI</th></tr>";
    while ($rowMeasurements = $resultBodyMeasurements->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $rowMeasurements["Initial_Weight"] . "</td>";
        echo "<td>" . $rowMeasurements["Initial_Height"] . "</td>";
        echo "<td>" . $rowMeasurements["Initial_BMI"] . "</td>";
        echo "<td>" . $rowMeasurements["Final_Weight"] . "</td>";
        echo "<td>" . $rowMeasurements["Final_Height"] . "</td>";
        echo "<td>" . $rowMeasurements["Final_BMI"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "找不到學生體重身高資料";
}

// 顯示學生健康狀態資料
if ($resultHealthStatus->num_rows > 0) {
    echo "<h3>學生健康狀態資料：</h3>";
    echo "<table border='1'>";
    echo "<tr><th>血壓(高)</th><th>血壓(低)</th><th>心跳</th><th>血糖</th><th>膽固醇</th><th>病例</th></tr>";
    while ($rowHealthStatus = $resultHealthStatus->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $rowHealthStatus["Blood_Pressure_H"] . "</td>";
        echo "<td>" . $rowHealthStatus["Blood_Pressure_L"] . "</td>";
        echo "<td>" . $rowHealthStatus["Heart_Rate"] . "</td>";
        echo "<td>" . $rowHealthStatus["Blood_Sugar"] . "</td>";
        echo "<td>" . $rowHealthStatus["Cholesterol"] . "</td>";
        echo "<td>" . $rowHealthStatus["Sick_History"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "找不到學生健康狀態資料";
}

// 顯示學生體能資料
if ($resultPhysicalFitness->num_rows > 0) {
    echo "<h3>學生體能資料：</h3>";
    echo "<table border='1'>";
    echo "<tr><th>期初跑步</th><th>期初跳遠</th><th>期初仰臥起坐</th><th>期初坐姿體前彎</th><th>期末跑步</th><th>期末跳遠</th><th>期末仰臥起坐</th><th>期末坐姿體前彎</th></tr>";
    while ($rowPhysicalFitness = $resultPhysicalFitness->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $rowPhysicalFitness["Initial_Run"] . "</td>";
        echo "<td>" . $rowPhysicalFitness["Initial_Long_Jump"] . "</td>";
        echo "<td>" . $rowPhysicalFitness["Initial_Sit_Ups"] . "</td>";
        echo "<td>" . $rowPhysicalFitness["Initial_Bend"] . "</td>";
        echo "<td>" . $rowPhysicalFitness["Final_Run"] . "</td>";
        echo "<td>" . $rowPhysicalFitness["Final_Long_Jump"] . "</td>";
        echo "<td>" . $rowPhysicalFitness["Final_Sit_Ups"] . "</td>";
        echo "<td>" . $rowPhysicalFitness["Final_Bend"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "找不到學生體能資料";
}

    // 生成排序後的步數記錄選項
    foreach ($stepRecordArray as $date => $steps) {

        $stepRecordOptions .= "<td>" . $date . "</td>";
        $stepRecordOptions .= "<td>" . $steps . "</td>";
        $stepRecordOptions .= "</tr>";
    }

    // 輸出步數記錄選項
    echo "<h3>學生步數記錄：</h3>";
    echo "<table border='1'>";
    echo "<tr><th>日期</th><th>步數</th></tr>";
    echo $stepRecordOptions;
    echo "</table>";
} else {
    echo "找不到學生步數記錄";
}
// 關閉資料庫連接
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ... 其他 head 內容 ... -->
</head>
<body onload="loadStudentOptions()">
    

        <select id="date" name="date">
            <?php echo $dateOptionsDailyWork; ?>
        </select>

</body>
</html>
