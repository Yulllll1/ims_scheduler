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

<?php for ($i = 5; $i <= 5; $i++): ?>
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
<script>
    // PHP에서 받아온 학생의 코스 정보
    var course = "<?php echo $student['course']; ?>";

// 과목 옵션들을 설정하는 함수
function setSubjectOptions() {

    var subjectSelect5 = document.getElementById('subject_5');

    subjectSelect5.innerHTML = ''; // 기존 옵션 초기화


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
        case 'Junior':
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
    for (var i = 5; i <= 5; i++) {
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
            if (grammar >= 1 && grammar <= 6) {
                selectedBook = 'Side by Side1';
            } else if (grammar >= 7 && grammar <= 10) {
                selectedBook = 'Basic Grmmar In use';
            } else if (grammar >= 11 && grammar <=15) {
                selectedBook = 'Grammar in use Inter';
            } else if (grammar >= 16 && grammar <=20) {
                selectedBook = 'Grammar in use Advanced'
            } else if (grammar >= 21 && grammar <= 25) {
                selectedBook = 'Destination C1'
            }
        } else if ((course === 'Junior') && selectedSubject === 'Reading') {
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
        } else if ((course === 'Junior') && selectedSubject === 'Speaking') {
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
        } else if ((course === 'Junior') && selectedSubject === 'Vocabulary') {
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
        } else if ((course === 'Junior') && selectedSubject === 'Grammar') {
            // Reading 과목에 대한 조건 추가
            if (grammar >= 1 && grammar <= 6) {
                selectedBook = 'My First Grammar 1';
            } else if (grammar >= 7 && grammar <= 10) {
                selectedBook = 'My Next Grammar 1';
            } else if (grammar >= 11 && grammar <=15) {
                selectedBook = 'My Next Grammar 2';
            } else if (grammar >= 16 && grammar <=20) {
                selectedBook = 'Basic Grammar in Use'
            } else if (grammar >= 21 && grammar <= 25) {
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
            if (grammar >= 1 && grammar <= 6) {
                selectedBook = 'Side by Side1';
            } else if (grammar >= 7 && grammar <= 10) {
                selectedBook = 'Basic Grmmar In use';
            } else if (grammar >= 11 && grammar <=15) {
                selectedBook = 'Grammar in use Inter';
            } else if (grammar >= 16 && grammar <=20) {
                selectedBook = 'Grammar in use Advanced'
            } else if (grammar >= 21 && grammar <= 25) {
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
            selectedBook = 'No book found for the specified criteria.';
        }

        // 선택된 책 정보를 화면에 출력합니다.
        var booksInput = document.getElementById('books_' + time);
        booksInput.value = selectedBook;
    }

    // 과목 선택이 변경될 때마다 책 정보를 업데이트합니다.

    document.getElementById('subject_5').addEventListener('change', function() { updateBook(5); });


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

