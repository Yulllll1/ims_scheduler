<?php 
// 데이터베이스 연결 설정
include 'main.php';

// 학생 정보값 받아오는 studen
$student_id = $_GET['id']; // edit.php?id=student_id로부터 받아오기

// 데이터베이스 연결 설정
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "timetable_db"; 

try { 
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password); 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

    // 학생 정보 가져오기
    $query = "SELECT * FROM student_info WHERE id = :student_id"; 
    $stmt = $conn->prepare($query); 
    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT); 
    $stmt->execute(); 
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // 데이터베이스에서 그룹 클래스 정보 가져오기
    $stmt = $conn->query("SELECT * FROM group_classes ORDER BY room_number");
    $group_classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 선생님 정보 가져오기
    $teachers = $conn->query("SELECT * FROM teacherss")->fetchAll(PDO::FETCH_ASSOC);
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // 각 시간별로 강의실 정보를 그룹화
    $schedule = [];
    foreach ($results as $row) {
        $schedule[$row['room_number']][$row['time']][] = $row;
    }
    // PHP 코드로부터 학생의 레벨(level)과 코스(course) 정보 가져오기
    $level = $student['level'];
    $course = $student['course'];
    
    $subjectOptions = [];

    
?>
<!DOCTYPE html>
<html lang="en">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Information</title>
    <style>
    form {
        margin-bottom: 20px;
    }

    form div {
        position: relative;
        display: flex;
        align-items: center;
    }

    label {
        position:relative;
        margin-left: 10px;
        margin-right: 10px;
        font-weight: bold;
    }

    select, input[type="text"] {
        flex: 1;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 12px 20px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }

    
    </style>
</head>
<body>
<div class="container">
    <h1>Edit Student Schedule</h1>
    <!-- 학생 시간표 편집 폼 -->
    <div class="container" style="display:none;">
                <h1>Student Information</h1>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Level</th>
                    </tr>
                    <tr>
                        <!-- 학생정보  이름, 코스, 레벨 -->
                        <td><?php echo $student['id']; ?></td>
                        <td><?php echo $student['name']; ?></td>
                        <td><?php echo $student['course']; ?></td>
                        <td><?php echo $student['level']; ?></td>
                    </tr>
                </table>
            </div>

    <form action="process_edit.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
        
        <?php
        $times = ['8:30 - 9:15', '9:25 - 10:10', '10:20 - 11:05', '11:15 - 12:00', '1:00 - 1:45', '1:55 - 2:40', '2:50 - 3:35', '3:45 - 4:30', '4:40 - 5:25'];
        foreach ($times as $time) {
            echo "<div>";
            echo "<label for='time_$time'>$time:</label>";
            echo "<div class='time_$time'>";
            echo "<label for='subject_$time'>Select Subject:</label>";
            echo "<select id='subject_$time' name='subject_$time'>";
            echo "<option value=''>Select Subject</option>";
            foreach ($group_classes as $class) {
                if ($class['time'] == $time) {
                    echo "<option value='{$class['subject']}'>{$class['subject']} (Room {$class['room_number']})</option>";
                }
            }
            echo "</select>";
            echo "</div>";
            echo "<label for='teacher_$time'>Teacher:</label>";
            echo "<select id='teacher_$time' name='teacher_$time'>";
            foreach ($teachers as $teacher) {
                echo "<option value='{$teacher['name']}'>{$teacher['name']}</option>";
            }
            echo "</select>";
            echo "</div>";
        }
        ?>

    
        

        <input type="submit" value="Submit">
    </form>
    
    <!-- 선택된 책을 표시하는 부분 -->
    <div id="selectedBook"></div>

</div>
</body>
</html>
<?php

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} 
?>