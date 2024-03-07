<?php 
// 데이터베이스 연결 설정
include 'main.php';
include 'halo.php';

// 학생 정보값 받아오는 studen
$student_id = $_GET['id']; 
echo $student_id;

// 데이터베이스 연결 설정
$servername = "localhost"; 
$username = "root";
$password = "";
$dbname = "timetable_db"; 

try { 
    //데이터 조회
    // PDO 객체 생성
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password); 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

    // 학생 정보 가져오기
    $query = "SELECT * FROM student_info WHERE id = :student_id"; 
    $stmt = $conn->prepare($query); 
    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT); 
    $stmt->execute(); 
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // PHP 코드로부터 학생의 레벨(level)과 코스(course) 정보 가져오기
    $level = $student['level'];
    $course = $student['course'];
    $reading = $student['reading'];
    $speaking = $student['speaking'];
    $grammar = $student['grammar'];
    $vocabulary = $student['vocabulary'];
    
    //선생님 정보 가져오기
    $teachers = $conn->query("SELECT name, course FROM teacherss")->fetchAll(PDO::FETCH_ASSOC);
    
    // 학생의 시간표 정보 가져오기
    $schedule_query = "SELECT * FROM schedules WHERE student_id = :student_id"; 
    $stmt = $conn->prepare($schedule_query); 
    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT); 
    $stmt->execute(); 
    $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);


    // 선생님 정보 가져오기
    $teacher_query = "SELECT * FROM schedules"; 
    $stmt = $conn->prepare($teacher_query); 
    $stmt->execute(); 
    $teacher = $stmt->fetchAll(PDO::FETCH_ASSOC);



    
    
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
                        <td><?php echo $student['reading']; ?></td>
                        <td><?php echo $student['speaking']; ?></td>
                        <td><?php echo $student['grammar']; ?></td>
                        <td><?php echo $student['vocabulary']; ?></td>

                    </tr>
                </table>
            </div>

    <!-- 시간표 편집 폼 -->
    <form action="subject.php" method="POST">
    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">

<?php
$timeOptions = array(
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
?>

<?php for ($i = 1; $i <= 9; $i++): ?>
    <div>
        <label for="time_<?php echo $i; ?>">Time:</label>
        <select id="time_<?php echo $i; ?>" name="time_<?php echo $i; ?>">
            <?php foreach ($timeOptions as $timeOption): ?>
                <option value="<?php echo $timeOption; ?>" <?php if ($i === 1 && $timeOption === "8:30 - 9:15") echo 'selected="selected"'; ?>
                <?php if ($i === 2 && $timeOption === "9:25 - 10:10") echo 'selected="selected"'; ?>
                <?php if ($i === 3 && $timeOption === "10:20 - 11:05") echo 'selected="selected"'; ?>
                <?php if ($i === 4 && $timeOption === "11:15 - 12:00") echo 'selected="selected"'; ?>
                <?php if ($i === 5 && $timeOption === "1:00 - 1:45") echo 'selected="selected"'; ?>
                <?php if ($i === 6 && $timeOption === "1:55 - 2:40") echo 'selected="selected"'; ?>
                <?php if ($i === 7 && $timeOption === "2:50 - 3:35") echo 'selected="selected"'; ?>
                <?php if ($i === 8 && $timeOption === "3:45 - 4:30") echo 'selected="selected"'; ?>
                <?php if ($i === 9 && $timeOption === "4:40 - 5:25") echo 'selected="selected"'; ?>><?php echo $timeOption; ?></option>
            <?php endforeach; ?>
        </select>

        <label for="subject_<?php echo $i; ?>">Select Subject:</label>
            <select id="subject_<?php echo $i; ?>" name="subject_<?php echo $i; ?>" onchange="checkSubject(this, <?php echo $i; ?>)">
                <?php foreach ($subjectOptions as $subjectOption): ?>
                    <option value="<?php echo $subjectOption; ?>" <?php if (isset($_POST['subject_' . $i]) && $_POST['subject_' . $i] === $subjectOption) echo 'selected="selected"'; ?>><?php echo $subjectOption; ?></option>
                <?php endforeach; ?>
            </select>

<script>
    function checkSubject(subjectSelect, index) {
        var selectedSubject = subjectSelect.value;
        var teacherSelect = document.getElementById('teacher_' + index);

        if (selectedSubject === 'Self-Study' || selectedSubject.startsWith('G')) {
            teacherSelect.value = ''; // VACANT로 설정
            teacherSelect.disabled = false; // 선택 불가능하도록 설정
        }
    }

    
</script>

<label for="teacher_<?php echo $i; ?>">Teacher:</label>
<select id="teacher_<?php echo $i; ?>" name="teacher_<?php echo $i; ?>">
    <option value="">VACANT</option> <!-- 기본 옵션 -->
    <?php
// 각 teacher의 시간에 이미 선택된 선생님 배열
    $timeArray = ($i == 1) ? $time1 : 
                (($i == 2) ? $time2 : 
                (($i == 3) ? $time3 : 
                (($i == 4) ? $time4 : 
                (($i == 5) ? $time5 :
                (($i == 6) ? $time6 :
                (($i == 7) ? $time7 :
                (($i == 8) ? $time8 :
                (($i == 9) ? $time9 : null))))))));

    // 중복된 선생님을 제외한 선생님 목록을 생성합니다.
    $availableTeachers = array_diff(array_column($teachers, 'name'), $timeArray);

    // 특별 선생님과 일반 선생님을 구분합니다.
    $specialTeachers = [];
    $normalTeachers = [];

    foreach ($availableTeachers as $teacher) {
        if ($teachers[array_search($teacher, array_column($teachers, 'name'))]['course'] == 'Special') {
            $specialTeachers[] = $teacher;
        } else {
            $normalTeachers[] = $teacher;
        }
    }

// 선택된 선생님 목록을 섞습니다.
shuffle($specialTeachers);
shuffle($normalTeachers);


    // Toeic 코스의 경우 특별 선생님을 우선 선택하고, 그 후에 일반 선생님도 옵션으로 추가합니다.
    if ($course === 'Toeic' || $course === 'IELTS-Academic' || $course === 'IELTS-General' || $course === 'Pre-IELTS-Academic' || $course ==='Pre-IELTS-General' || $course === 'Pre-Toeic') {
        foreach ($specialTeachers as $teacher) {
            ?>
            <option value="<?php echo $teacher; ?>" <?php if ((isset($_POST['teacher_' . $i]) && $_POST['teacher_' . $i] === 'special_' . $teacher) || empty($_POST['teacher_' . $i])) echo 'selected="selected"'; ?> style="color: red;">
                <?php echo $teacher; ?>
            </option>
            <?php
        }
        // 일반 선생님도 옵션으로 추가합니다.
        foreach ($normalTeachers as $teacher) {
            ?>
            <option value="<?php echo $teacher; ?>" <?php if ((isset($_POST['teacher_' . $i]) && $_POST['teacher_' . $i] === 'normal_' . $teacher) || empty($_POST['teacher_' . $i])) ; ?>>
                <?php echo $teacher; ?>
            </option>
            <?php
        }
    }  else {
        // Toeic 코스가 아닌 경우에는 특별 선생님을 옵션으로만 추가합니다.
        foreach ($specialTeachers as $teacher) {
            ?>
            <option value="<?php echo $teacher; ?>" style="color: red;">
                <?php echo $teacher; ?>
            </option>
            <?php
        }
    
        // 일반 선생님을 옵션으로 추가합니다.
        foreach ($normalTeachers as $teacher) {
            ?>
            <option value="<?php echo $teacher; ?>" <?php if ((isset($_POST['teacher_' . $i]) && $_POST['teacher_' . $i] === 'normal_' . $teacher) || empty($_POST['teacher_' . $i])) echo 'selected="selected"'; ?>>
                <?php echo $teacher; ?>
            </option>
            <?php
        }
    }
    ?>
</select>


        <br>
        <input type="text" id="books_<?php echo $i; ?>" name="books_<?php echo $i; ?>">
    </div>
<?php endfor; ?>

<!-- 필요한 만큼 시간대를 추가합니다. -->
<input type="submit" value="submit" >
</form>
    
    <!-- 선택된 책을 표시하는 부분 -->
    <div id="selectedBook"></div>

    

</div>

<style>
        .recommendation {
            position: absolute;
            top: 700px;
            left: 30%;  
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .recommendation h2 {
            color: #333;
            margin-bottom: 10px;
        }
        .recommendation .class-list {
            margin-left: 20px;
        }
        .recommendation .class-list li {
            list-style: none;
            margin-bottom: 5px;
        }
    </style>

<div class="recommendation">
        <h2>Group Class Recommendation List</h2>
        <ul class="class-list">
            <?php
            if ($grammar <= 10) {
                echo "<li>Listening - 1</li>";
            } else if ($grammar <= 15 && $grammar > 10) {
                echo "<li>Listening - 2</li>";
            } else if ($grammar <= 20 && $grammar > 15){
                echo "<li>Listening - 3</li>";
            } else if ($grammar <= 25 && $grammar >20) {
                echo "<li>Listening - 5</li>";
            }

            if ($speaking <= 6) {
                echo "<li>Speaking Beginner</li>";
            } else if ($speaking <= 10 && $speaking > 6) {
                echo "<li>Conversation - 1</li>";
            } else if ($speaking <= 15 && $speaking > 10) {
                echo "<li>Conversation - 2</li>";
            } else if ($speaking <= 25 && $speaking >11){
                echo "<li>Conversation - 3</li>";
            }

            if ($vocabulary <= 6) {
                echo "<li>Writing - 1</li>";
            } else if ($vocabulary <= 10 && $vocabulary > 6){
                echo "<li>Writing - 2</li>";
            } else if ($vocabulary <= 15 && $vocabulary > 10){
                echo "<li>Writing - 3</li>";
            } else if ($vocabulary <= 25 && $vocabulary > 15){
                echo "<li>Writing - 4</li>";
            }

            if ($grammar == 0 && $speaking == 0 && $vocabulary == 0) {
                echo "<li>No Recommendation.</li>";
            }
            ?>
        </ul>
    </div>
<script>
    // PHP에서 받아온 학생의 코스 정보
    var course = "<?php echo $student['course']; ?>";

// 과목 옵션들을 설정하는 함수
function setSubjectOptions() {
    var subjectSelect1 = document.getElementById('subject_1');
    var subjectSelect2 = document.getElementById('subject_2');
    var subjectSelect3 = document.getElementById('subject_3');
    var subjectSelect4 = document.getElementById('subject_4');
    var subjectSelect5 = document.getElementById('subject_5');
    var subjectSelect6 = document.getElementById('subject_6');
    var subjectSelect7 = document.getElementById('subject_7');
    var subjectSelect8 = document.getElementById('subject_8');
    var subjectSelect9 = document.getElementById('subject_9');

    subjectSelect1.innerHTML = ''; // 기존 옵션 초기화
    subjectSelect2.innerHTML = ''; // 기존 옵션 초기화
    subjectSelect3.innerHTML = ''; // 기존 옵션 초기화
    subjectSelect4.innerHTML = ''; // 기존 옵션 초기화
    subjectSelect5.innerHTML = ''; // 기존 옵션 초기화
    subjectSelect6.innerHTML = ''; // 기존 옵션 초기화
    subjectSelect7.innerHTML = ''; // 기존 옵션 초기화
    subjectSelect8.innerHTML = ''; // 기존 옵션 초기화
    subjectSelect9.innerHTML = ''; // 기존 옵션 초기화


    // course 값에 따라 다른 과목 옵션 설정

    switch (course) {
        case 'Premium':
            addSubjectOption('Select');
            addSubjectOption('Reading');
            addSubjectOption('Speaking');
            addSubjectOption('Grammar');
            addSubjectOption('Vocabulary');
            addSubjectOption('Self-Study');
            break;
        case 'Intensive':
            addSubjectOption('Select');
            addSubjectOption('Reading');
            addSubjectOption('Speaking');
            addSubjectOption('Grammar');
            addSubjectOption('Vocabulary');
            addSubjectOption('Self-Study');
            break;
        case 'Power-Speaking':
            addSubjectOption('Select');
            addSubjectOption('Speaking-Drill');
            addSubjectOption('Speaking');
            addSubjectOption('Grammar');
            addSubjectOption('Vocabulary');
            addSubjectOption('Self-Study');
            break;
        case 'Esl-Essential':
            addSubjectOption('Select');
            addSubjectOption('Reading');
            addSubjectOption('Speaking');
            addSubjectOption('Grammar');
            addSubjectOption('Vocabulary');
            addSubjectOption('Self-Study');
            break;
        case 'Toeic':
            addSubjectOption('Select');
            addSubjectOption('Reading');
            addSubjectOption('Speaking');
            addSubjectOption('Grammar');
            addSubjectOption('Vocabulary');
            addSubjectOption('Self-Study');
            break;
        case 'Pre-Toeic':
            addSubjectOption('Select');
            addSubjectOption('Reading');
            addSubjectOption('Speaking');
            addSubjectOption('Grammar');
            addSubjectOption('Vocabulary');
            addSubjectOption('Self-Study');
            break;
        case 'IELTS-Academic':
            addSubjectOption('Select');
            addSubjectOption('Reading');
            addSubjectOption('Writing-T1');
            addSubjectOption('Speaking');
            addSubjectOption('Pronunciation');
            addSubjectOption('Self-Study');
            break;
        case 'IELTS-General':
            addSubjectOption('Select');
            addSubjectOption('Reading');
            addSubjectOption('Writing-T1');
            addSubjectOption('Speaking');
            addSubjectOption('Pronunciation');
            addSubjectOption('Self-Study');
            break;

        case 'Pre-IELTS-Academic':
            addSubjectOption('Select');
            addSubjectOption('Reading');
            addSubjectOption('Writing');
            addSubjectOption('Listening');
            addSubjectOption('Speaking');
            addSubjectOption('Self-Study');
            break;
        case 'Pre-IELTS-General':
            addSubjectOption('Select');
            addSubjectOption('Reading');
            addSubjectOption('Writing');
            addSubjectOption('Listening');
            addSubjectOption('Speaking');
            addSubjectOption('Self-Study');
            break;
        case 'Business':
            addSubjectOption('Select');
            addSubjectOption('Speaking');
            addSubjectOption('Business-Grammar-and-Voca');
            addSubjectOption('Business-Writing');
            addSubjectOption('Professional-English');
            addSubjectOption('Self-Study');
            break;
        case 'Parent':
            addSubjectOption('Select');
            addSubjectOption('Reading');
            addSubjectOption('Speaking');
            addSubjectOption('Grammar');
            addSubjectOption('Vocabulary');
            addSubjectOption('Self-Study');
            break;
        case 'Junior-6':
            addSubjectOption('Select');
            addSubjectOption('Reading');
            addSubjectOption('Speaking');
            addSubjectOption('Grammar');
            addSubjectOption('Vocabulary');
            addSubjectOption('Self-Study');
            break;
        case 'Junior-8':
            addSubjectOption('Select');
            addSubjectOption('Reading');
            addSubjectOption('Speaking');
            addSubjectOption('Grammar');
            addSubjectOption('Vocabulary');
            addSubjectOption('Self-Study');
            break;
        case 'Junior-9':
            addSubjectOption('Select');
            addSubjectOption('Reading');
            addSubjectOption('Speaking');
            addSubjectOption('Grammar');
            addSubjectOption('Vocabulary');
            addSubjectOption('Self-Study');
            break;
        default:
            console.log('Unknown course');
    }
    // 선택된 값 다시 설정
    subjectSelect1.value = selectedValue1;
}

// 새로운 과목 옵션을 추가하는 함수
function addSubjectOption(subject) {
    // Loop through each subject select box from 1 to 9
    for (var i = 1; i <= 9; i++) {
        var optionElement = document.createElement('option');
        optionElement.value = subject;
        optionElement.textContent = subject;
        document.getElementById('subject_' + i).appendChild(optionElement);
    }
}









// 페이지 로딩 시 과목 옵션 초기화
window.onload = function() {
    setSubjectOptions();
};

var subjectSelect1 = document.getElementById('subject_1');

// subject_1 select 요소에 클릭 이벤트 리스너를 추가합니다.
subjectSelect1.addEventListener('click', function handleClick() {
    // AJAX를 사용하여 서버로 요청을 보내 데이터베이스에서 그룹 클래스 정보를 가져옵니다.
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'group.php?time=8:30 - 9:15', true); // group.php 파일은 데이터베이스에서 그룹 클래스 정보를 가져오는 PHP 파일입니다.
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // 요청이 성공적으로 완료되면 수업 정보를 처리합니다.
                var groupClasses1 = xhr.responseText;


                // 기존의 select 요소를 가져옵니다.
                var subjectSelect1 = document.getElementById('subject_1');

                // 기존의 select 요소에 새로운 옵션을 추가합니다.

                // 가져온 수업 정보를 처리하여 옵션을 추가합니다.
                var newOptions = groupClasses1.split('</option>');
                newOptions.forEach(function(option) {
                    if (option.includes('G1-')) { // 8:30-9:15 시간대의 옵션만 추가합니다.
                        var newOption = option + '</option>';
                        subjectSelect1.innerHTML += newOption;
                    }
                });

                // 클릭 이벤트 리스너를 삭제합니다.
                subjectSelect1.removeEventListener('click', handleClick);
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        }
    };
    xhr.send();
});


var subjectSelect2 = document.getElementById('subject_2');

// subject_1 select 요소에 클릭 이벤트 리스너를 추가합니다.
subjectSelect2.addEventListener('click', function handleClick() {
    // AJAX를 사용하여 서버로 요청을 보내 데이터베이스에서 그룹 클래스 정보를 가져옵니다.
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'group.php?time=9:25 - 10:10', true); // group.php 파일은 데이터베이스에서 그룹 클래스 정보를 가져오는 PHP 파일입니다.
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // 요청이 성공적으로 완료되면 수업 정보를 처리합니다.
                var groupClasses2 = xhr.responseText;


                // 기존의 select 요소를 가져옵니다.
                var subjectSelect2 = document.getElementById('subject_2');

                // 기존의 select 요소에 새로운 옵션을 추가합니다.

                // 가져온 수업 정보를 처리하여 옵션을 추가합니다.
                var newOptions = groupClasses2.split('</option>');
                newOptions.forEach(function(option) {
                    if (option.includes('G2-')) { // 8:30-9:15 시간대의 옵션만 추가합니다.
                        var newOption = option + '</option>';
                        subjectSelect2.innerHTML += newOption;
                    }
                });

                // 클릭 이벤트 리스너를 삭제합니다.
                subjectSelect2.removeEventListener('click', handleClick);
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        }
    };
    xhr.send();
});



// subject_3 select 요소에 클릭 이벤트 리스너를 추가합니다.
var subjectSelect3 = document.getElementById('subject_3');
subjectSelect3.addEventListener('click', function handleClick() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'group.php?time=10:20 - 11:05', true); // 해당 시간대에 해당하는 그룹 클래스 정보를 가져오는 요청을 보냅니다.
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var groupClasses3 = xhr.responseText;

                var subjectSelect3 = document.getElementById('subject_3');

                var newOptions = groupClasses3.split('</option>');
                newOptions.forEach(function(option) {
                    if (option.includes('G3-')) { // 해당 시간대의 옵션만 추가합니다.
                        var newOption = option + '</option>';
                        subjectSelect3.innerHTML += newOption;
                    }
                });

                subjectSelect3.removeEventListener('click', handleClick);
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        }
    };
    xhr.send();
});

// subject_4 select 요소에 클릭 이벤트 리스너를 추가합니다.
var subjectSelect4 = document.getElementById('subject_4');
subjectSelect4.addEventListener('click', function handleClick() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'group.php?time=11:15 - 12:00', true); // 해당 시간대에 해당하는 그룹 클래스 정보를 가져오는 요청을 보냅니다.
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var groupClasses4 = xhr.responseText;

                var subjectSelect4 = document.getElementById('subject_4');

                var newOptions = groupClasses4.split('</option>');
                newOptions.forEach(function(option) {
                    if (option.includes('G4-')) { // 해당 시간대의 옵션만 추가합니다.
                        var newOption = option + '</option>';
                        subjectSelect4.innerHTML += newOption;
                    }
                });

                subjectSelect4.removeEventListener('click', handleClick);
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        }
    };
    xhr.send();
});

// subject_5 select 요소에 클릭 이벤트 리스너를 추가합니다.
var subjectSelect5 = document.getElementById('subject_5');
subjectSelect5.addEventListener('click', function handleClick() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'group.php?time=1:00 - 1:45', true); // 해당 시간대에 해당하는 그룹 클래스 정보를 가져오는 요청을 보냅니다.
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var groupClasses5 = xhr.responseText;

                var subjectSelect5 = document.getElementById('subject_5');

                var newOptions = groupClasses5.split('</option>');
                newOptions.forEach(function(option) {
                    if (option.includes('G5-')) { // 해당 시간대의 옵션만 추가합니다.
                        var newOption = option + '</option>';
                        subjectSelect5.innerHTML += newOption;
                    }
                });

                subjectSelect5.removeEventListener('click', handleClick);
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        }
    };
    xhr.send();
});

// subject_6 select 요소에 클릭 이벤트 리스너를 추가합니다.
var subjectSelect6 = document.getElementById('subject_6');
subjectSelect6.addEventListener('click', function handleClick() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'group.php?time=1:55 - 2:40', true); // 해당 시간대에 해당하는 그룹 클래스 정보를 가져오는 요청을 보냅니다.
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var groupClasses6 = xhr.responseText;

                var subjectSelect6 = document.getElementById('subject_6');

                var newOptions = groupClasses6.split('</option>');
                newOptions.forEach(function(option) {
                    if (option.includes('G6-')) { // 해당 시간대의 옵션만 추가합니다.
                        var newOption = option + '</option>';
                        subjectSelect6.innerHTML += newOption;
                    }
                });

                subjectSelect6.removeEventListener('click', handleClick);
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        }
    };
    xhr.send();
});

// subject_7 select 요소에 클릭 이벤트 리스너를 추가합니다.
var subjectSelect7 = document.getElementById('subject_7');
subjectSelect7.addEventListener('click', function handleClick() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'group.php?time=2:50 - 3:35', true); // 해당 시간대에 해당하는 그룹 클래스 정보를 가져오는 요청을 보냅니다.
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var groupClasses7 = xhr.responseText;

                var subjectSelect7 = document.getElementById('subject_7');

                var newOptions = groupClasses7.split('</option>');
                newOptions.forEach(function(option) {
                    if (option.includes('G7-')) { // 해당 시간대의 옵션만 추가합니다.
                        var newOption = option + '</option>';
                        subjectSelect7.innerHTML += newOption;
                    }
                });

                subjectSelect7.removeEventListener('click', handleClick);
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        }
    };
    xhr.send();
});

// subject_8 select 요소에 클릭 이벤트 리스너를 추가합니다.
var subjectSelect8 = document.getElementById('subject_8');
subjectSelect8.addEventListener('click', function handleClick() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'group.php?time=3:45 - 4:30', true); // 해당 시간대에 해당하는 그룹 클래스 정보를 가져오는 요청을 보냅니다.
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var groupClasses8 = xhr.responseText;

                var subjectSelect8 = document.getElementById('subject_8');

                var newOptions = groupClasses8.split('</option>');
                newOptions.forEach(function(option) {
                    if (option.includes('G8-')) { // 해당 시간대의 옵션만 추가합니다.
                        var newOption = option + '</option>';
                        subjectSelect8.innerHTML += newOption;
                    }
                });

                subjectSelect8.removeEventListener('click', handleClick);
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        }
    };
    xhr.send();
});

// subject_9 select 요소에 클릭 이벤트 리스너를 추가합니다.
var subjectSelect9 = document.getElementById('subject_9');
subjectSelect9.addEventListener('click', function handleClick() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'group.php?time=4:40 - 5:25', true); // 해당 시간대에 해당하는 그룹 클래스 정보를 가져오는 요청을 보냅니다.
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var groupClasses9 = xhr.responseText;

                var subjectSelect9 = document.getElementById('subject_9');

                var newOptions = groupClasses9.split('</option>');
                newOptions.forEach(function(option) {
                    if (option.includes('G9-')) { // 해당 시간대의 옵션만 추가합니다.
                        var newOption = option + '</option>';
                        subjectSelect9.innerHTML += newOption;
                    }
                });

                subjectSelect9.removeEventListener('click', handleClick);
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        }
    };
    xhr.send();
});








    // php 변수를 가져와서 사용할 수 있도록 
    var level = "<?php echo $level; ?>";
    var course = "<?php echo $course; ?>";
    var reading = "<?php echo $reading; ?>";
    var speaking = "<?php echo $speaking; ?>";
    var grammar = "<?php echo $grammar; ?>";
    var vocabulary = "<?php echo $vocabulary; ?>";

    function updateBook(time) {
        var selectedSubject = document.getElementById('subject_' + time).value;
        var selectedBook = ''; // 선택된 책 정보를 저장할 변수

        // 선택된 레벨, 코스, 과목에 따라 책 정보를 설정합니다.
        if ((course === 'Premium' || course === 'Intensive' || course === 'Esl-Essential' || course === 'Parent') && selectedSubject === 'Reading') {
            // Reading 과목에 대한 조건 추가
            if (reading >= 1 && reading <= 6) {
                selectedBook = 'Reading Advantage1';
            } else if (reading >= 7 && reading <= 10) {
                selectedBook = 'Reading Advantage2';
            } else if (reading >= 11 && reading <=15) {
                selectedBook = 'Reading Advantage3';
            } else if (reading >= 16 && reading <=20) {
                selectedBook = 'Reading Advantage4'
            } else if (reading >= 21 && reading <= 25) {
                selectedBook = 'Reading EXplorer'
            }
        }else if ((course === 'Premium' || course === 'Intensive' || course === 'Esl-Essential' || course === 'Parent') && selectedSubject === 'Speaking') {
            // Reading 과목에 대한 조건 추가
            if (speaking >= 1 && speaking <= 6) {
                selectedBook = 'Speaking Juice1';
            } else if (speaking >= 7 && speaking <= 10) {
                selectedBook = 'SLE1';
            } else if (speaking >= 11 && speaking <=15) {
                selectedBook = 'SLE2';
            } else if (speaking >= 16 && speaking <=20) {
                selectedBook = 'SLE3'
            } else if (speaking >= 21 && speaking <= 25) {
                selectedBook = 'EXPRESS YOURSELF'
            }
        } else if ((course === 'Premium' || course === 'Intensive' || course === 'Esl-Essential' || course === 'Parent') && selectedSubject === 'Vocabulary') {
            // Reading 과목에 대한 조건 추가
            if (vocabulary >= 1 && vocabulary <= 6) {
                selectedBook = 'Elementary Vocabulary';
            } else if (vocabulary >= 7 && vocabulary <= 10) {
                selectedBook = 'Inter Vocabulary';
            } else if (vocabulary >= 11 && vocabulary <=15) {
                selectedBook = 'Inter Vocabulary';
            } else if (vocabulary >= 16 && vocabulary <=20) {
                selectedBook = '4000 words'
            } else if (vocabulary >= 21 && vocabulary <= 25) {
                selectedBook = 'Destination C1'
            }
        }else if ((course === 'Premium' || course === 'Intensive' || course === 'Esl-Essential' || course === 'Parent') && selectedSubject === 'Grammar') {
            // Reading 과목에 대한 조건 추가
            if (vocabulary >= 1 && vocabulary <= 6) {
                selectedBook = 'Side by Side1';
            } else if (vocabulary >= 7 && vocabulary <= 10) {
                selectedBook = 'Basic Grmmar In use';
            } else if (vocabulary >= 11 && vocabulary <=15) {
                selectedBook = 'Grammar in use Inter';
            } else if (vocabulary >= 16 && vocabulary <=20) {
                selectedBook = 'Grammar in use Advanced'
            } else if (vocabulary >= 21 && vocabulary <= 25) {
                selectedBook = 'Destination C1'
            }
        } else if ((course === 'Junior-6' || course === 'Junior-8' || course === 'Junior-9') && selectedSubject === 'Reading') {
            // Reading 과목에 대한 조건 추가
            if (reading >= 1 && reading <= 6) {
                selectedBook = 'Reading Juice for Kids 1';
            } else if (reading >= 7 && reading <= 10) {
                selectedBook = 'Reading Juice for Kids 2';
            } else if (reading >= 11 && reading <=15) {
                selectedBook = 'Reading Juice for Kids 3';
            } else if (reading >= 16 && reading <=20) {
                selectedBook = 'Reading Advantage 1'
            } else if (reading >= 21 && reading <= 25) {
                selectedBook = 'Reading Advantage(2~4)'
            }
        } else if ((course === 'Junior-6' || course === 'Junior-8' || course === 'Junior-9') && selectedSubject === 'Speaking') {
            // Reading 과목에 대한 조건 추가
            if (speaking >= 1 && speaking <= 6) {
                selectedBook = 'Speaking Juice for Kids 1';
            } else if (speaking >= 7 && speaking <= 10) {
                selectedBook = 'Speaking Juice for Kids 2';
            } else if (speaking >= 11 && speaking <=15) {
                selectedBook = 'Speaking Juice for kids 3';
            } else if (speaking >= 16 && speaking <=20) {
                selectedBook = 'SLE 1'
            } else if (speaking >= 21 && speaking <= 25) {
                selectedBook = 'SLE 2'
            }
        } else if ((course === 'Junior-6' || course === 'Junior-8' || course === 'Junior-9') && selectedSubject === 'Vocabulary') {
            // Reading 과목에 대한 조건 추가
            if (vocabulary >= 1 && vocabulary <= 6) {
                selectedBook = '1000 Basic English Words 1';
            } else if (vocabulary >= 7 && vocabulary <= 10) {
                selectedBook = '1000 Basic English Words 2';
            } else if (vocabulary >= 11 && vocabulary <=15) {
                selectedBook = '1000 Basic English words 3';
            } else if (vocabulary >= 16 && vocabulary <=20) {
                selectedBook = 'Voca in use Elementary'
            } else if (vocabulary >= 21 && vocabulary <= 25) {
                selectedBook = '4000 Essential words 1'
            }
        } else if ((course === 'Junior-6' || course === 'Junior-8' || course === 'Junior-9') && selectedSubject === 'Grammar') {
            // Reading 과목에 대한 조건 추가
            if (vocabulary >= 1 && vocabulary <= 6) {
                selectedBook = 'My First Grammar 1';
            } else if (vocabulary >= 7 && vocabulary <= 10) {
                selectedBook = 'My Next Grammar 1';
            } else if (vocabulary >= 11 && vocabulary <=15) {
                selectedBook = 'My Next Grammar 2';
            } else if (vocabulary >= 16 && vocabulary <=20) {
                selectedBook = 'Basic Grammar in Use'
            } else if (vocabulary >= 21 && vocabulary <= 25) {
                selectedBook = 'Grammar in use Intermediate'
            }
        } else if (course ==='Power-Speaking' && selectedSubject === 'Speaking') {
            if (speaking >= 1 && speaking <=6) {
                selectedBook = 'Speaking Juice 1';
            } else if (speaking >= 7 && speaking <= 10) {
                selectedBook = 'Speaking Juice 3';
            } else if (speaking >= 11 && speaking <=15) {
                selectedBook = 'SLE1';
            } else if (speaking >= 16 && speaking <=20) {
                selectedBook = 'SLE2'
            } else if (speaking >= 21 && speaking <= 25) {
                selectedBook = 'SLE3'
            }
        } else if (course ==='Power-Speaking' && selectedSubject === 'Speaking-Drill') {
            if (speaking >= 1 && speaking <=6) {
                selectedBook = 'Stage 1';
            } else if (speaking >= 7 && speaking <= 10) {
                selectedBook = 'Stage 1';
            } else if (speaking >= 11 && speaking <=15) {
                selectedBook = 'Stage 1';
            } else if (speaking >= 16 && speaking <=20) {
                selectedBook = 'Stage 3'
            } else if (speaking >= 21 && speaking <= 25) {
                selectedBook = 'Stage 3'
            }
        } else if (course ==='Power-Speaking' && selectedSubject === 'Grammar') {
            // Reading 과목에 대한 조건 추가
            if (vocabulary >= 1 && vocabulary <= 6) {
                selectedBook = 'Side by Side1';
            } else if (vocabulary >= 7 && vocabulary <= 10) {
                selectedBook = 'Basic Grmmar In use';
            } else if (vocabulary >= 11 && vocabulary <=15) {
                selectedBook = 'Grammar in use Inter';
            } else if (vocabulary >= 16 && vocabulary <=20) {
                selectedBook = 'Grammar in use Advanced'
            } else if (vocabulary >= 21 && vocabulary <= 25) {
                selectedBook = 'Destination C1'
            }
        } else if  (course ==='Power-Speaking' && selectedSubject === 'Vocabulary') {
            // Reading 과목에 대한 조건 추가
            if (vocabulary >= 1 && vocabulary <= 6) {
                selectedBook = 'Elementary Vocabulary';
            } else if (vocabulary >= 7 && vocabulary <= 10) {
                selectedBook = 'Inter Vocabulary';
            } else if (vocabulary >= 11 && vocabulary <=15) {
                selectedBook = 'Inter Vocabulary';
            } else if (vocabulary >= 16 && vocabulary <=20) {
                selectedBook = '4000 words'
            } else if (vocabulary >= 21 && vocabulary <= 25) {
                selectedBook = 'Destination C1'
            }
        }else if ((course === 'Toeic' || course === 'Pre-Toeic') && level ==='No-Level') {
            if (selectedSubject === 'Reading') {
                selectedBook = 'Economic TOEIC RC';
            } else if(selectedSubject === 'Speaking') {
                selectedBook = 'Collins Business Speaking';
            } else if(selectedSubject === 'Grammar') {
                selectedBook = 'TOEIC Starter';
            } else if(selectedSubject === 'Vocabulary') {
                selectedBook = '600 TOEIC Vocabulary';
            }
        } else if (course === 'IELTS-Academic'){
            if (selectedSubject === 'Reading') {
                selectedBook = 'Ultimate Guide to academic Reading';
            } else if(selectedSubject === 'Writing-T1') {
                selectedBook = 'IELTS Writing';
            } else if (selectedSubject === 'Pronunciation'){
                selectedBook = "English Pronunciation Made Easy";
            } else if (selectedSubject === 'Speaking') {
                selectedBook = "IELTS Speaking Success";
            }
        } else if (course === 'IELTS-General') {
            if(selectedSubject === 'Reading') {
                selectedBook = 'Improve IELTS Reading 6-7.5';
            } else if(selectedSubject === 'Writing-T1') {
                selectedBook = 'Barrons Writing IELTS';
            } else if (selectedSubject === 'Pronunciation'){
                selectedBook = "English Pronunciation Made Easy";
            } else if (selectedSubject === 'Speaking') {
                selectedBook = "IELTS Speaking Success";
            }
        } else if (course === 'Pre-IELTS-Academic'){
            if (selectedSubject === 'Reading') {
                selectedBook = 'Get Ready for IELTS Reading';
            } else if(selectedSubject === 'Writing') {
                selectedBook = 'Get Ready for IELTS Writing';
            } else if (selectedSubject === 'Listening'){
                selectedBook = "Get ready for IELTS listening";
            } else if (selectedSubject === 'Speaking') {
                selectedBook = "Get ready for IELTS speaking";
            }
        } else if (course === 'Pre-IELTS-General') {
            if(selectedSubject === 'Reading') {
                selectedBook = 'IELTS GENERAL READING + Cambridge IELTS Books';
            } else if(selectedSubject === 'Writing') {
                selectedBook = 'IELTS GENERAL READING + Cambridge IELTS Books';
            } else if (selectedSubject === 'Listening'){
                selectedBook = "Get ready for IELTS listening";
            } else if (selectedSubject === 'Speaking') {
                selectedBook = "Get ready for IELTS speaking";
            }
        } else if (course === 'Business'){
            if(selectedSubject === 'Speaking'){
                selectedBook = 'Collins Business Communication'; 
            } else if(selectedSubject === 'Business-Grammar-and-Voca'){
                selectedBook = 'Delta Business Communictaion';
            } else if(selectedSubject === 'Business-Writing') {
                selectedBook = 'Emailing Business Communication skills';
            } else if(selectedSubject === 'Professional-English') {
                selectedBook = 'Depending on Major';
            }

        }
        //IELTS has level or not ? to be continue ...
        else {
            selectedBook = '';
        }

        // 선택된 책 정보를 화면에 출력합니다.
        var booksInput = document.getElementById('books_' + time);
        booksInput.value = selectedBook;
    }

    // 과목 선택이 변경될 때마다 책 정보를 업데이트합니다.
    document.getElementById('subject_1').addEventListener('change', function() { updateBook(1); });
    document.getElementById('subject_2').addEventListener('change', function() { updateBook(2); });
    document.getElementById('subject_3').addEventListener('change', function() { updateBook(3); });
    document.getElementById('subject_4').addEventListener('change', function() { updateBook(4); });
    document.getElementById('subject_5').addEventListener('change', function() { updateBook(5); });
    document.getElementById('subject_6').addEventListener('change', function() { updateBook(6); });
    document.getElementById('subject_7').addEventListener('change', function() { updateBook(7); });
    document.getElementById('subject_8').addEventListener('change', function() { updateBook(8); });
    document.getElementById('subject_9').addEventListener('change', function() { updateBook(9); });

    // 그룹 클래스 선택이 변경될 때마다 해당하는 시간과 과목을 가져와서 표시합니다.
    document.getElementById('subject_1').addEventListener('change', function() {
    var selectedGroupClass = this.value;

}
);




</script>
</body>
</html>
<?php

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} 
?>

<?php
function getTimeLabel($slot) {
    switch ($slot) {
        case 1:
            return '8:30 - 9:15';
        case 2:
            return '9:25 - 10:10';
        case 3:
            return '10:20 - 11:05';
        case 4:
            return '11:15 - 12:00';
        case 5:
            return '1:00 - 1:45';
        case 6:
            return '1:55 - 2:40';
        case 7:
            return '2:50 - 3:35';
        case 8:
            return '3:45 - 4:30';
        case 9:
            return '4:40 - 5:25';
        default:
            return '';
    }
}
?>

