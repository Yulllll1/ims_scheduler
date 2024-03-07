<?php
include ('main.php');
// group.php입니다

// 데이터베이스 연결 설정
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timetable_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    // 폼으로부터 전송된 데이터를 저장
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // 삭제 버튼 클릭 시에만 실행
        if (isset($_POST['delete'])) {
            $id = $_POST['delete'];
            // 선택된 수업 정보를 데이터베이스에서 삭제
            $stmt_delete = $conn->prepare("DELETE FROM group_classes WHERE id = :id");
            $stmt_delete->bindParam(':id', $id);
            $stmt_delete->execute();

             // 삭제 후 리다이렉션
            header("Location: ".$_SERVER['PHP_SELF']); // 현재 페이지로 리다이렉션
            exit();
        }
    }
    // 폼으로부터 전송된 데이터를 저장
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $time = $_POST['time'];
        $subjectType = $_POST['subject_type'];
        $subject = $_POST['subject'];
        $teacher = $_POST['teacher'];
        $roomNumber = $_POST['room_number'];

        

        // 데이터베이스에 데이터 삽입
        $stmt = $conn->prepare("INSERT INTO group_classes (time, subject_type, subject, teacher, room_number) 
                                VALUES (:time, :subject_type, :subject, :teacher, :room_number)");
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':subject_type', $subjectType);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':teacher', $teacher);
        $stmt->bindParam(':room_number', $roomNumber);
        $stmt->execute();

        //POST 요청 후에는 리다이렉션
        header("Location: ".$_SERVER['PHP_SELF']); // 현재 페이지로 리다이렉션
        exit();
    }

    // 데이터베이스에서 저장된 그룹 클래스 정보를 가져옴
    $stmt = $conn->query("SELECT * FROM group_classes ORDER BY room_number");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 시간대별로 그룹 수업 정보를 저장할 배열 초기화
    $groupClassesTime1 = [];
    $groupClassesTime2 = [];
    $groupClassesTime3 = [];
    $groupClassesTime4 = [];
    $groupClassesTime5 = [];
    $groupClassesTime6 = [];
    $groupClassesTime7 = [];
    $groupClassesTime8 = [];
    $groupClassesTime9 = [];

    
    

    // 8:30 - 9:15 시간대의 그룹 수업 정보 가져오기
    $stmt1 = $conn->prepare("SELECT * FROM group_classes WHERE time = '8:30 - 9:15'");
    $stmt1->execute();
    $groupClassesTime1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    // 9:25 - 10:10 시간대의 그룹 수업 정보 가져오기
    $stmt2 = $conn->prepare("SELECT * FROM group_classes WHERE time = '9:25 - 10:10'");
    $stmt2->execute();
    $groupClassesTime2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    $stmt3 = $conn->prepare("SELECT * FROM group_classes WHERE time = '10:20 - 11:05'");
    $stmt3->execute();
    $groupClassesTime3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);

    $stmt4 = $conn->prepare("SELECT * FROM group_classes WHERE time = '11:15 - 12:00'");
    $stmt4->execute();
    $groupClassesTime4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);

    $stmt5 = $conn->prepare("SELECT * FROM group_classes WHERE time = '1:00 - 1:45'");
    $stmt5->execute();
    $groupClassesTime5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);

    $stmt6 = $conn->prepare("SELECT * FROM group_classes WHERE time = '1:55 - 2:40'");
    $stmt6->execute();
    $groupClassesTime6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);

    // 2:50 - 3:35 시간대의 그룹 수업 정보 가져오기
    $stmt7 = $conn->prepare("SELECT * FROM group_classes WHERE time = '2:50 - 3:35'");
    $stmt7->execute();
    $groupClassesTime7 = $stmt7->fetchAll(PDO::FETCH_ASSOC);

    // 3:45 - 4:30 시간대의 그룹 수업 정보 가져오기
    $stmt8 = $conn->prepare("SELECT * FROM group_classes WHERE time = '3:45 - 4:30'");
    $stmt8->execute();
    $groupClassesTime8 = $stmt8->fetchAll(PDO::FETCH_ASSOC);

    // 4:40 - 5:25 시간대의 그룹 수업 정보 가져오기
    $stmt9 = $conn->prepare("SELECT * FROM group_classes WHERE time = '4:40 - 5:25'");
    $stmt9->execute();
    $groupClassesTime9 = $stmt9->fetchAll(PDO::FETCH_ASSOC);

    

    // 8:30 - 9:15 시간대의 그룹 수업 정보를 배열에 추가
    foreach ($groupClassesTime1 as $class) {
        // 시간대와 과목을 결합하여 고유한 값을 생성
        $value = 'G1-' . $class['subject'];
        // 옵션을 출력
        echo "<option value='" . $value . "'>" . "<span style='display:none'>" . $class['subject'] . "</span>" . "</option>";
    }

    // 9:25 - 10:10 시간대의 그룹 수업 정보를 배열에 추가
    foreach ($groupClassesTime2 as $class) {
        // 시간대와 과목을 결합하여 고유한 값을 생성
        $value = 'G2-' . $class['subject'];
        // 옵션을 출력
        echo "<option value='" . $value . "' style='display: none;'>" . $class['subject'] . "</option>";
    }
    
    // 10:20 - 11:05 시간대의 그룹 수업 정보를 배열에 추가
    foreach ($groupClassesTime3 as $class) {
        // 시간대와 과목을 결합하여 고유한 값을 생성
        $value = 'G3-' . $class['subject'];
        // 옵션을 출력
        echo "<option value='" . $value . "' style='display: none;'>" . $class['subject'] . "</option>";
    }

    // 11:15 - 12:00 시간대의 그룹 수업 정보를 배열에 추가
    foreach ($groupClassesTime4 as $class) {
        // 시간대와 과목을 결합하여 고유한 값을 생성
        $value = 'G4-' . $class['subject'];
        // 옵션을 출력
        echo "<option value='" . $value . "' style='display: none;'>" . $class['subject'] . "</option>";
    }

    // 1:00 - 1:45 시간대의 그룹 수업 정보를 배열에 추가
    foreach ($groupClassesTime5 as $class) {
        // 시간대와 과목을 결합하여 고유한 값을 생성
        $value = 'G5-' . $class['subject'];
        // 옵션을 출력
        echo "<option value='" . $value . "' style='display: none;'>" . $class['subject'] . "</option>";
    }

    // 1:55 - 2:40 시간대의 그룹 수업 정보를 배열에 추가
    foreach ($groupClassesTime6 as $class) {
        // 시간대와 과목을 결합하여 고유한 값을 생성
        $value = 'G6-' . $class['subject'];
        // 옵션을 출력
        echo "<option value='" . $value . "' style='display: none;'>" . $class['subject'] . "</option>";
    }

    // 2:50 - 3:35 시간대의 그룹 수업 정보를 배열에 추가
    foreach ($groupClassesTime7 as $class) {
        // 시간대와 과목을 결합하여 고유한 값을 생성
        $value = 'G7-' . $class['subject'];
        // 옵션을 출력
        echo "<option value='" . $value . "' style='display: none;'>" . $class['subject'] . "</option>";
    }

    // 3:45 - 4:30 시간대의 그룹 수업 정보를 배열에 추가
    foreach ($groupClassesTime8 as $class) {
        // 시간대와 과목을 결합하여 고유한 값을 생성
        $value = 'G8-' . $class['subject'];
        // 옵션을 출력
        echo "<option value='" . $value . "' style='display: none;'>" . $class['subject'] . "</option>";
    }

    // 4:40 - 5:25 시간대의 그룹 수업 정보를 배열에 추가
    foreach ($groupClassesTime9 as $class) {
        // 시간대와 과목을 결합하여 고유한 값을 생성
        $value = 'G9-' . $class['subject'];
        // 옵션을 출력
        echo "<option value='" . $value . "' style='display: none;'>" . $class['subject'] . "</option>";
    }


    // 각 시간별로 강의실 정보를 그룹화
    $schedule = [];
    foreach ($results as $row) {
        $schedule[$row['room_number']][$row['time']][] = $row;
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?><html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
        }

        h1 {
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            display: inline-block;
            margin-right: 10px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .button {
            position: absolute;
            top: 310px;
            transform: translateX(-50%);
            left:50%;
            z-index: 1;
        }


    </style>
</head>



<body>
    <!-- 그룹 페이지로 이동하는 버튼 -->
    <div class="button">
        <form action="group.php" method="get">
            <input type="submit" value="Go to Group Page">
        </form>
        <!-- 개인 페이지로 이동하는 버튼 -->
        <form action="personal.php" method="get">
            <input type="submit" value="Go to Personal Page">
        </form>
    </div>

    <div class="container">
        <h1>Group Class Schedule</h1>
        <form action="group_make.php">
            <input type="submit" value="Create New Group Class">
        </form>
        

        <table border="1">
            <tr>
                <th>Room Number</th>
                <th>8:30 - 9:15</th>
                <th>9:25 - 10:10</th>
                <th>10:20 - 11:05</th>
                <th>11:15 - 12:00</th>
                <th>Lunch Time</th>
                <th>1:00 - 1:45</th>
                <th>1:55 - 2:40</th>
                <th>2:50 - 3:35</th>
                <th>3:45 - 4:30</th>
                <th>4:40 - 5:25</th>
                <!-- 추가 시간에 대한 열을 필요에 따라 추가할 수 있습니다. -->
            </tr>
            <?php
            // 각 강의실별로 행을 생성하고 각 시간대에 대한 정보를 출력
            foreach ($schedule as $roomNumber => $times) {
                echo "<tr>";
                echo "<td>$roomNumber</td>";
                foreach (['8:30 - 9:15', '9:25 - 10:10', '10:20 - 11:05', '11:15 - 12:00','1:00 - 1:45', '1:55 - 2:40', '2:50 - 3:35', '3:45 - 4:30', '4:40 - 5:25', ''] as $time) {
                    echo "<td>";
                    if (isset($times[$time])) {
                        foreach ($times[$time] as $class) {
                            echo "<div>";
                            echo "<p>{$class['subject']}</p>";
                            echo "<p>{$class['teacher']}</p>";
                            // 삭제 버튼 추가
                            echo "<div style='color: red;'>"; // 빨간색 스타일 추가
                            echo "<form method='post'>";
                            echo "<input type='hidden' name='delete' value='{$class['id']}'>";
                            echo "<input type='submit' value='Delete' style='background-color: red; color: white;'>"; // 빨간 배경색, 흰색 글자색으로 변경
                            echo "</form>";
                            echo "</div>";
                        }
                    }
                    echo "</td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

