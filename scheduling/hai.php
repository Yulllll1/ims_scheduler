<?php
include 'halo.php';

try {
    // PDO 객체 생성
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    // 에러 모드 설정
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // teacherss 테이블에서 데이터 가져오기
    $stmt = $conn->query("SELECT name, room, course FROM teacherss");
    
    // 결과를 HTML로 출력
    echo "<table border='1'>
            <tr>
                <th>Name</th>
                <th>Room</th>
                <th>Course</th>
            </tr>";
    
    // 각 행을 순회하며 데이터 출력
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['name']}</td>
                <td>{$row['room']}</td>
                <td>{$row['course']}</td>
            </tr>";
    }
    echo "</table>";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// time1 배열을 JSON으로 변환하여 출력합니다.
echo json_encode($time1);
?>

<script>
    // halo.php에서 time1 배열을 가져옵니다.
    var time1Array = <?php echo json_encode($time1); ?>;

    // 현재 teacher_1 select 요소의 값을 가져옵니다.
    var selectedValue = document.getElementById('teacher_1').value;

    // 현재 선택된 값이 time1 배열에 포함되어 있는지 체크합니다.
    if (time1Array.includes(selectedValue)) {
        // 배경색을 변경합니다.
        document.getElementById('teacher_1').style.backgroundColor = 'lightblue';
        document.getElementById('teacher_1').style.color = 'white';
    }
    // 해당 옵션이 "Special" 클래스를 갖고 있다면 글자 색상을 빨간색으로 변경합니다.
    if (selectElement.options[i].classList.contains('Special')) {
        selectElement.options[i].style.color = 'red';
    }
</script>