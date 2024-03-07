<?php
ob_start();
error_reporting(E_ALL ^ E_NOTICE);
include 'teacher.php';

$searchResults = []; // 검색 결과를 저장할 배열을 초기화

try {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "timetable_db";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 데이터 조회
    $result = $conn->query("SELECT * FROM teacherss");


    // When delete button click
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
        $idToDelete = $_POST['delete_id'];

        // 데이터 삭제
        $deleteSql = "DELETE FROM teacherss WHERE id = :idToDelete";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bindParam(':idToDelete', $idToDelete, PDO::PARAM_INT);
        $deleteStmt->execute();

        header("Location: {$_SERVER['REQUEST_URI']}");
        exit();
    }



    // 데이터 추가
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['proceed'])) {
        $name = $_POST['name'];
        $room = $_POST['room'];
        $course = $_POST['course'];

        try {
            $insertSql = "INSERT INTO teacherss (name, room, course) VALUES (:name, :room, :course)";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bindParam(':name', $name, PDO::PARAM_STR);
            $insertStmt->bindParam(':room', $room, PDO::PARAM_STR);
            $insertStmt->bindParam(':course', $course, PDO::PARAM_STR);
            $insertStmt->execute();

            header("Location: {$_SERVER['REQUEST_URI']}");
            exit();
        } catch (PDOException $e) {
            echo "Error:" . $e->getMessage();
        }
    }

    // 데이터 조회 쿼리
    $selectAllSql = "SELECT * FROM teacherss ORDER BY room";
    $searchResults = $conn->query($selectAllSql)->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error:" . $e->getMessage();
}

?>

<html>

    <?php
    if (!empty($searchResults)) {
        echo "<table>
                <tr>
                    <th>Name</th>
                    <th>Room</th>
                    <th>Course</th>
                    <th>Action</th>
                </tr>";

        // 결과를 테이블에 출력
        foreach ($searchResults as $row) {
            echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['room']}</td>
                    <td>{$row['course']}</td>
                    <td>
                        <!-- 삭제 버튼 폼 -->
                        <form method='post' action=''>
                            <input type='hidden' name='delete_id' value='{$row['id']}'>
                            <input type='submit' name='delete' value='DELETE'>
                        </form>
                    </td>
                </tr>";
        }

        echo "</table>";
        
    } else {
        echo "0 results";
    }
    ?>
</html>