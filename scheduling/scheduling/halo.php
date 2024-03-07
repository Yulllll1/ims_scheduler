<?php
include 'main.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timetable_db";

try {
    // 각 시간대에 대한 선생님 정보를 저장할 배열들
    $time1 = array(); // 8:30 - 9:15
    $time2 = array(); // 9:25 - 10:10
    $time3 = array(); // 10:20 - 11:05
    $time4 = array(); // 11:15 - 12:00
    $time5 = array(); // 1:00 - 1:45
    $time6 = array(); // 1:55 - 2:40
    $time7 = array(); // 2:50 - 3:35
    $time8 = array(); // 3:45 - 4:30
    $time9 = array(); // 4:40 - 5:25

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 각 시간대에 대한 선생님 정보 가져오기
    $time_slots = array(
        "8:30 - 9:15",
        "9:25 - 10:10",
        "10:20 - 11:05",
        "11:15 - 12:00",
        "1:00 - 1:45",
        "1:55 - 2:40",
        "2:50 - 3:35",
        "3:45 - 4:30",
        "4:40 - 5:25"
    );

    // 데이터베이스에서 각 시간대에 대한 선생님 정보를 가져와서 해당 배열에 추가
    foreach ($time_slots as $index => $time_slot) {
        $stmt = $conn->prepare("SELECT DISTINCT teacher FROM group_classes WHERE time = :time");
        $stmt->bindParam(':time', $time_slot, PDO::PARAM_STR);
        $stmt->execute();
        $teachers_group_classes = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if ($teachers_group_classes) {
            ${"time" . ($index + 1)} = array_merge(${"time" . ($index + 1)}, $teachers_group_classes);
        }

        $stmt = $conn->prepare("SELECT DISTINCT teacher FROM schedules WHERE time_slot = :time_slot");
        $stmt->bindParam(':time_slot', $time_slot, PDO::PARAM_STR);
        $stmt->execute();
        $teachers_schedules = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if ($teachers_schedules) {
            ${"time" . ($index + 1)} = array_merge(${"time" . ($index + 1)}, $teachers_schedules);
        }
    }



} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>