<?php

include('main.php');
// 데이터베이스 연결 설정
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timetable_db";

try {
    // 데이터베이스 연결
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // subject 가져오기
    $stmt = $conn->query("SELECT DISTINCT subject FROM group_classes");
    $subjects = $stmt->fetchAll(PDO::FETCH_COLUMN);

    

    // 모든 선생님 가져오기
    $teachers = $conn->query("SELECT DISTINCT teacher FROM schedules")->fetchAll(PDO::FETCH_COLUMN);

   // 모든 시간대 가져오기 (정렬 추가)
    $time_slots = $conn->query("SELECT DISTINCT time_slot FROM schedules ORDER BY FIELD(time_slot, '8:30 - 9:15', '9:25 - 10:10', '10:20 - 11:05', '11:15 - 12:00', '1:00 - 1:45', '1:55 - 2:40', '2:50 - 3:35', '3:45 - 4:30', '4:40 - 5:25')")->fetchAll(PDO::FETCH_COLUMN);
    

    
    // 테이블 시작

    echo "<table border='1'>";
    echo "<tr><th>Teacher</th>"; // 첫 번째 행에 Teacher 추가

    // 모든 시간대를 테이블 헤더로 추가
    foreach ($time_slots as $slot) {
        echo "<th>$slot</th>";
    }
    echo "</tr>";

    // 각 선생님에 대한 일정 출력
    foreach ($teachers as $teacher) {
        // 선생님 이름이 비어있는 경우 해당 열을 출력하지 않음
        if (!empty($teacher)) {
            echo "<tr>";
            echo "<td>$teacher</td>"; // 첫 번째 열에 선생님 이름 추가
            // 각 시간대에 대한 일정 출력
            foreach ($time_slots as $slot) {
                $stmt = $conn->prepare("SELECT subject, student_id, books FROM schedules WHERE teacher = :teacher AND time_slot = :time_slot");
                $stmt->bindParam(':teacher', $teacher);
                $stmt->bindParam(':time_slot', $slot);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $subject = $result ? $result['subject'] : ''; // 해당 시간에 해당 선생님의 과목
                $student_id = $result ? $result['student_id'] : ''; // 해당 시간에 해당 선생님의 학생 ID
                $books = $result ? $result['books'] : ''; // 해당 시간에 해당 선생님의 책 정보
    
                // 학생 ID 대신 학생 이름으로 대체
                if (!empty($student_id)) {
                    $student_name_stmt = $conn->prepare("SELECT name FROM student_info WHERE id = :student_id");
                    $student_name_stmt->bindParam(':student_id', $student_id);
                    $student_name_stmt->execute();
                    $student_result = $student_name_stmt->fetch(PDO::FETCH_ASSOC);
                    $student_name = $student_result ? $student_result['name'] : ''; // 학생 이름
                } else {
                    $student_name = '';
                }
    
                // subject가 group_classes에 있는 subject와 일치하는 경우에는 셀을 빨간색으로 출력
                $color = '';
                if (!empty($subject)) {
                    $group_subject_stmt = $conn->prepare("SELECT subject FROM group_classes WHERE subject = :subject");
                    $group_subject_stmt->bindParam(':subject', $subject);
                    $group_subject_stmt->execute();
                    $group_subject_result = $group_subject_stmt->fetch(PDO::FETCH_ASSOC);
                    if ($group_subject_result) {
                        $color = 'style="color: red;"';
                        $student_name = '';
                    }
                }
    
                echo "<td $color>$subject <br> <span class=\"books\">$books</span> <br> $student_name</td>";
            }
            echo "</tr>";
        }
    }


    // 테이블 종료
    echo "</table>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<style>

.books {
    font-size: 12px; /* 또는 원하는 크기로 지정하세요 */
}
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            position: absolute;
            top:300px;
            transform: translateX(-50%);
            left:50%;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        td {
            background-color: #fff;
        }

        .teacher-column {
            min-width: 150px;
        }

        .empty-cell {
            background-color: #f9f9f9;
        }

        /* 버튼 스타일 */
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
            top:250px;
            transform: translateX(-50%);
            left:50%;
        }
    </style>

<html>
    <div class="button">

        <!-- 그룹 페이지로 이동하는 버튼 -->
        <form action="group.php" method="get">
            <input type="submit" value="Go to Group Page">
        </form>
        <!-- 개인 페이지로 이동하는 버튼 -->
        <form action="personal.php" method="get">
            <input type="submit" value="Go to Personal Page">
        </form>
    </div>
</html>