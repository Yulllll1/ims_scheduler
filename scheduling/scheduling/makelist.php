<?php
error_reporting(E_ALL ^ E_NOTICE);
include 'main.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['proceed'])) {
    // PROCEED 버튼이 눌렸을 때만 실행
}

// 데이터 조회 및 삭제
try {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "timetable_db";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 데이터 조회
    $result = $conn->query("SELECT * FROM student_info");

    // When delete button click
// When delete button click
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $idToDelete = $_POST['delete_id'];

    try {
        // 데이터 삭제
        $deleteStudentSql = "DELETE FROM student_info WHERE id = :idToDelete";
        $deleteStudentStmt = $conn->prepare($deleteStudentSql);
        $deleteStudentStmt->bindParam(':idToDelete', $idToDelete, PDO::PARAM_INT);
        $deleteStudentStmt->execute();

        // student_info 테이블에서 삭제한 후, schedules 테이블에서도 관련된 레코드 삭제
        $deleteScheduleSql = "DELETE FROM schedules WHERE student_id = :idToDelete";
        $deleteScheduleStmt = $conn->prepare($deleteScheduleSql);
        $deleteScheduleStmt->bindParam(':idToDelete', $idToDelete, PDO::PARAM_INT);
        $deleteScheduleStmt->execute();

        // 삭제가 성공하면 메시지 출력
        echo "Record deleted successfully";
    } catch (PDOException $e) {
        echo "Error deleting record: " . $e->getMessage();
    }
}

    //데이터 추가
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['proceed'])) {
        $name = $_POST['name'];
        $course = $_POST['course'];
        $level = $_POST['level'];
        $reading = $_POST['reading'];
        $speaking = $_POST['speaking'];
        $grammar = $_POST['grammar'];
        $vocabulary = $_POST['vocabulary'];
        $startdate = $_POST['startdate'];
        $enddate = $_POST['enddate'];

        try {
            $insertSql = "INSERT INTO student_info (name, course, level, reading, speaking, grammar, vocabulary, startdate, enddate) VALUES (:name, :course, :level, :reading, :speaking, :grammar, :vocabulary, :startdate, :enddate)";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bindParam(':name', $name, PDO::PARAM_STR);
            $insertStmt->bindParam(':course', $course, PDO::PARAM_STR);
            $insertStmt->bindParam(':level', $level, PDO::PARAM_STR);
            $insertStmt->bindParam(':reading', $reading, PDO::PARAM_STR);
            $insertStmt->bindParam(':speaking', $speaking, PDO::PARAM_STR);
            $insertStmt->bindParam(':grammar', $grammar, PDO::PARAM_STR);
            $insertStmt->bindParam(':vocabulary', $vocabulary, PDO::PARAM_STR);
            $insertStmt->bindParam(':startdate', $startdate, PDO::PARAM_STR);
            $insertStmt->bindParam(':enddate', $enddate, PDO::PARAM_STR);
            $insertStmt->execute();

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // 검색 쿼리 실행
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    // 검색 결과를 저장할 변수
    $searchResults = [];

    $searchKeyword = trim($_GET['search']); // 공백 제거
    if (!empty($searchKeyword)) {
        $searchSql = "SELECT * FROM student_info WHERE name LIKE :searchKeyword";
        $searchStmt = $conn->prepare($searchSql);
        $searchStmt->bindValue(':searchKeyword', "%$searchKeyword%", PDO::PARAM_STR);
        $searchStmt->execute();
        $searchResults = $searchStmt->fetchAll(PDO::FETCH_ASSOC);
        // 검색 결과 출력
        if (!empty($searchResults)) {
            echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Level</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Action</tj>
                </tr>";

            // 결과를 테이블에 출력
            foreach ($searchResults as $row) {
                echo "<tr>
                    <td>" . $row["id"]. "</td>
                    <td>" . $row["name"] . "</td>
                    <td>" . $row["course"] . "</td>
                    <td>" . $row["level"] . "</td>
                    <td>" . $row["startdate"] . "</td>
                    <td>" . $row["enddate"] . "</td>
                    <td>
                        <!--삭제 버튼 폼 -->
                        <form method='post' action=''>
                            <input type='hidden' name='delete_id' value='{$row['id']}'>
                            <input type='submit' name='delete' value='DELETE'>
                        </form>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "No results found.";
        }
    } else {
        echo "Please enter a search keyword.";
    }
} else {
    // 일반적인 데이터 조회 쿼리
    $selectAllSql = "SELECT * FROM student_info ORDER BY startdate DESC";
    $searchResults = $conn->query($selectAllSql)->fetchAll(PDO::FETCH_ASSOC);
}
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information</title>
    <style>
        table {
            position: relative;
            border-collapse: collapse;
            width: 50%;
            top: 270px;
            left: 50%;
            margin-bottom: 20px;
            transform: translateX(-50%);
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .searching {
            position: absolute;
            top: 220px;
            left: 50%;
            transform: translateX(-50%);
        }

        input[type="text"], select, input[type="date"] {
            padding: 8px;
            margin: 5px 0;
        }

        input[type="submit"], input[type="button"] {
            display: inline-block;
            padding: 10px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover, input[type="button"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
<div class="searching">
    <form method="get">
        <label for="search">Searching:</label>
        <input type="text" id="search" name="search" value=" ">
        <input type="submit" value="Search">
    </form>
</div>

<?php
if (!empty($searchResults)) {
    echo "<table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Course</th>
                <th>Level</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Action</th>
            </tr>";

    // 결과를 테이블에 출력
    foreach ($searchResults as $row) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['course']}</td>
                <td>{$row['level']}</td>
                <td>{$row['startdate']}</td>
                <td>{$row['enddate']}</td>
                <td>
                    <div style='display: inline-block;'>
                        <form method='get' action='subject.php'>
                            <input type='hidden' name='student_id' value='{$row['id']}'>
                            <input type='submit' name='subject' value='Subject'>
                        </form>
                    </div>

                <!-- Delete 버튼 폼 -->
                    <div style='display: inline-block;'>
                        <form method='post' action=''>
                            <input type='hidden' name='delete_id' value='{$row['id']}'>
                            <input type='submit' name='delete' value='DELETE'>
                        </form>
                    </div>
                </td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "0 results";
}
?>
</body>
</html>