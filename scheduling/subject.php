<?php 
include 'main.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // PROCEED 버튼이 눌렸을 때만 실행
}

// 학생 정보값 받아오는 student_id
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : null;
// student_id가 존재하는지 확인
if ($student_id !== null) {
    // 여기에 학생 정보를 가져오고 표시하는 코드를 추가하세요.
} else {
    echo "Student ID is not provided.";
}

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "timetable_db"; 

try { 
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password); 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    
    // GET으로 받은 선택된 과목 정보를 데이터베이스에 저장
    // 학생 정보 및 시간표 정보 가져오기
    $query = "SELECT * FROM student_info WHERE id = :student_id"; 
    $stmt = $conn->prepare($query); 
    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT); 
    $stmt->execute(); 
    $student = $stmt->fetch(PDO::FETCH_ASSOC); 

    $query = "SELECT * FROM schedules WHERE student_id = :student_id AND time_slot IS NOT NULL ORDER BY FIELD(time_slot, '8:30 - 9:15', '9:25 - 10:10', '10:20 - 11:05', '11:15 - 12:00', '1:00 - 1:45', '1:55 - 2:40', '2:50 - 3:35', '3:45 - 4:30', '4:40 - 5:25')";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
    $stmt->execute();
    $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $query = "SELECT * FROM group_classes";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $group_classes = $stmt->fetchAll(PDO::FETCH_ASSOC);




     // 선생님의 방 번호를 가져오는 함수
    function getTeacherRoom($teacher_name, $conn) {
        if ($teacher_name === '') {
            return '';
        } else {
            $sql = "SELECT room FROM teacherss WHERE name = :teacher_name";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':teacher_name', $teacher_name, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['room'];
        }
    }


    $result = $conn->query("SELECT * FROM schedules");

    
    


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $student_id = $_POST['student_id'];
    
        // 1부터 9까지의 시간대에 대한 데이터 삽입 루프
        for ($i = 1; $i <= 9; $i++) {
            $time_slot = $_POST['time_' . $i];
            // NULL인 경우 데이터를 삽입하지 않음
            if ($time_slot === NULL) {
                continue;
            }
            $subject = $_POST['subject_' . $i];
            $teacher = $_POST['teacher_' . $i];
            $books = $_POST['books_' . $i];
            if ($_POST['teacher_' . $i] == 'VACANT') {
                // 선택된 옵션이 "나중에 선택하세요"가 아닌 경우에만 데이터베이스에 삽입하는 코드 실행
                // 여기에 데이터 삽입 코드 작성
                $selectedTeacher = $_POST['teacher_' . $i];
                
                // 여기에 데이터 삽입 코드를 작성하면 됩니다.
            } else {
                // 선택된 옵션이 "나중에 선택하세요"인 경우에 대한 처리
                // 선택하지 않은 경우를 처리할 수 있도록 추가 작업 수행
                // 예를 들어, 오류 메시지를 사용자에게 표시하거나 기타 작업을 수행할 수 있습니다.
                echo "선생님을 선택하세요."; // 사용자에게 오류 메시지 표시
            // 과목 값이 "G1-"로 시작하는 경우에는 "G1-"을 제거하여 실제 과목명을 가져옴
            if (strpos($subject, 'G1-') === 0) {
                $subject = substr($subject, 3); // "G1-" 부분을 제거
            } else if (strpos($subject, 'G2-') === 0) {
                $subject = substr($subject, 3); // "G1-" 부분을 제거
            } else if (strpos($subject, 'G3-') === 0) {
                $subject = substr($subject, 3); // "G1-" 부분을 제거
            } else if (strpos($subject, 'G4-') === 0) {
                $subject = substr($subject, 3); // "G1-" 부분을 제거
            } else if (strpos($subject, 'G5-') === 0) {
                $subject = substr($subject, 3); // "G1-" 부분을 제거
            } else if (strpos($subject, 'G6-') === 0) {
                $subject = substr($subject, 3); // "G1-" 부분을 제거
            } else if (strpos($subject, 'G7-') === 0) {
                $subject = substr($subject, 3); // "G1-" 부분을 제거
            } else if (strpos($subject, 'G8-') === 0) {
                $subject = substr($subject, 3); // "G1-" 부분을 제거
            } else if (strpos($subject, 'G9-') === 0) {
                $subject = substr($subject, 3); // "G1-" 부분을 제거
            }
            
            // group_classes에서 해당 과목 정보를 가져오기
            $query_group_class = "SELECT * FROM group_classes WHERE subject = :subject";
            $stmt_group_class = $conn->prepare($query_group_class);
            $stmt_group_class->bindParam(':subject', $subject, PDO::PARAM_STR);
            $stmt_group_class->execute();
            $group_class = $stmt_group_class->fetch(PDO::FETCH_ASSOC);
            
            // 해당 과목의 선생님과 강의실 정보 가져오기
            if ($group_class) {
                $teacher = $group_class['teacher'];
                $room = $group_class['room_number'];
            }
            }
            
            
            
    
            // 기존 데이터가 있는지 확인
            $query = "SELECT COUNT(*) FROM schedules WHERE student_id = :student_id AND time_slot = :time_slot";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
            $stmt->bindParam(':time_slot', $time_slot, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();
    
            // 이미 해당 시간대의 레코드가 있는 경우 UPDATE 수행
            if ($count > 0) {
                $sql = "UPDATE schedules SET subject = :subject, teacher = :teacher, books = :books WHERE student_id = :student_id AND time_slot = :time_slot";
            } else {
                // 새로운 레코드를 추가합니다.
                $sql = "INSERT INTO schedules (student_id, time_slot, subject, teacher, books) 
                        VALUES (:student_id, :time_slot, :subject, :teacher, :books)";
            }
    
            // SQL 쿼리 준비
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
            $stmt->bindParam(':time_slot', $time_slot, PDO::PARAM_STR);
            $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
            $stmt->bindParam(':teacher', $teacher, PDO::PARAM_STR);
            $stmt->bindParam(':books', $books, PDO::PARAM_STR);
    
            // 쿼리 실행
            if ($stmt->execute()) {
                echo "Record(s) updated successfully";
            } else {
                echo "Error: " . $stmt->errorInfo()[2] . "<br>";
            }
        }
        header("Location: http://localhost/scheduling/subject.php?student_id=" . $student_id . "&subject=" . $subject);
        exit(); // 리디렉션 후 스크립트 실행 중지
    }
    
    if ($student) { 
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Student Information</title>
            <style>
        .container {
            margin: 20px auto;
            padding: 20px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: center; /* 가운데 정렬 추가 */
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Student Information</h1>
        <!-- 학생 정보 표시 -->
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Course</th>
                <th>Level</th>
            </tr>
            <tr>
                <td><?php echo $student['id']; ?></td>
                <td><?php echo $student['name']; ?></td>
                <td><?php echo $student['course']; ?></td>
                <td><?php echo $student['level']; ?></td>
            </tr>
        </table>

        <table>
            <tr>
                <th>Time</th>
                <?php foreach ($schedules as $event): ?>
                    <td style="white-space: nowrap;"><?php echo $event['time_slot']; ?></td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <th>Subject</th>
                <?php foreach ($schedules as $event): ?>
                    <td><?php echo $event['subject']; ?></td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <th>Teacher</th>
                <?php foreach ($schedules as $event): ?>
                    
                    <td><?php echo $event['teacher']; ?></td>
                <?php endforeach; ?>
            </tr>
            <tr>
    <th>Room</th>
    <?php foreach ($schedules as $event): ?>
        <?php
        // 해당 강의의 강의실 정보 가져오기
        $subject = $event['subject'];
        $teacher = $event['teacher'];

        // 과목과 선생님을 기준으로 group_classes 테이블에서 강의실 정보 가져오기
        $query_room = "SELECT room_number FROM group_classes WHERE subject = :subject AND teacher = :teacher";
        $stmt_room = $conn->prepare($query_room);
        $stmt_room->bindParam(':subject', $subject, PDO::PARAM_STR);
        $stmt_room->bindParam(':teacher', $teacher, PDO::PARAM_STR);
        $stmt_room->execute();
        $room_info = $stmt_room->fetch(PDO::FETCH_ASSOC);

        // 만약 group_classes에서 해당하는 강의실 정보가 없다면, teacherss 테이블에서 가져옵니다.
        if (!$room_info) {
            $room_info['room_number'] = getTeacherRoom($teacher, $conn);
        }
        ?>
        <td><?php echo $room_info['room_number']; ?></td>
    <?php endforeach; ?>
</tr>
            <tr>
                <th>Books</th>
                <?php foreach ($schedules as $event): ?>
                    <td><?php echo $event['books']; ?></td>
                    <?php endforeach; ?>
                </tr>
                <tr>
                <th style="border: none; background-color: white;"></th>
                <tr></tr>
                <th style="border: none; background-color: white;"><tr></tr></th>
                <th style="border: none; background-color: white;"></th>
                <tr></tr>
                <th style="border: none; background-color: white;"><tr></tr></th>
    <th>Edit</th>
    <?php for ($i = 1; $i <= 9; $i++): ?>
    <td>
        <form method="get" action="edit<?php echo $i; ?>.php">
            <input type="hidden" name="id" value="<?php echo $student_id; ?>">
            <button type="submit">Edit <?php echo $i; ?></button>
        </form>
    </td>
<?php endfor; ?>
</tr>
        </table>
        <br>
        
        <!-- Edit 버튼 -->
        <a href="edit.php?id=<?php echo $student_id; ?>">All Edit</a>
        
    </div>
</body>


</html>
        <?php
    } else {
        echo "Student information not found.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} 


?>
