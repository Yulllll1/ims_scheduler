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

    //선생님 정보 가져오기
    $teachers = $conn->query("SELECT * FROM teacherss")->fetchAll(PDO::FETCH_ASSOC);
    
    

    
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
        
        <div>
            <label for="time_1">8:30 - 9:15:</label>
            <div class="time_1" name="time_1">
                <label for="subject_1">Select Subject:</label>
                <select id="subject_1">
                    <!-- Subject options will be dynamically added here -->
                </select>
            </div>
            <label for="teacher">Teacher:</label>
            <select id="teacher_1" name="teacher">
                <?php foreach ($teachers as $teacher): ?>
                    <option value="<?php echo $teacher['name']; ?>"><?php echo $teacher['name']; ?></option>
                <?php endforeach; ?>
            </select><br>
            <input type="text" id="books_1" name="books_1">
        </div>
    
        <div>
            <label for="time_2">9:25 - 10:10:</label>
            <div class="time_2" name="time_2">
                <label for="subject_2">Select Subject:</label>
                <select id="subject_2" name="subject_2"> <!-- ID와 name 모두 수정 -->
                    <!-- Subject options will be dynamically added here -->
                </select>
            </div>
            <label for="teacher_2">Teacher:</label>
            <select id="teacher_2" name="teacher_2"> <!-- ID와 name 모두 수정 -->
                <?php foreach ($teachers as $teacher): ?>
                    <option value="<?php echo $teacher['name']; ?>"><?php echo $teacher['name']; ?></option>
                <?php endforeach; ?>
            </select><br>
            <input type="text" id="books_2" name="books_2">
        </div>

        <div>
            <label for="time_3">10:20 - 11:05:</label>
            <div class="time_3" name="time_3">
                <label for="subject_3">Select Subject:</label>
                <select id="subject_3" name="subject_3"> <!-- ID와 name 모두 수정 -->
                    <!-- Subject options will be dynamically added here -->
                </select>
            </div>
            <label for="teacher_3">Teacher:</label>
            <select id="teacher_3" name="teacher_3"> <!-- ID와 name 모두 수정 -->
                <?php foreach ($teachers as $teacher): ?>
                    <option value="<?php echo $teacher['name']; ?>"><?php echo $teacher['name']; ?></option>
                <?php endforeach; ?>
            </select><br>
            <input type="text" id="books_3" name="books_3">
        </div>

        <div>
            <label for="time_4">11:15 - 12:00:</label>
            <div class="time_4" name="time_4">
                <label for="subject_4">Select Subject:</label>
                <select id="subject_4" name="subject_4"> <!-- ID와 name 모두 수정 -->
                    <!-- Subject options will be dynamically added here -->
                </select>
            </div>
            <label for="teacher_4">Teacher:</label>
            <select id="teacher_4" name="teacher_4"> <!-- ID와 name 모두 수정 -->
                <?php foreach ($teachers as $teacher): ?>
                    <option value="<?php echo $teacher['name']; ?>"><?php echo $teacher['name']; ?></option>
                <?php endforeach; ?>
            </select><br>
            <input type="text" id="books_4" name="books_4">
        </div>

        <div>
            <label for="time_5">1:00 - 1:45:</label>
            <div class="time_5" name="time_5">
                <label for="subject_5">Select Subject:</label>
                <select id="subject_5" name="subject_5"> <!-- ID와 name 모두 수정 -->
                    <!-- Subject options will be dynamically added here -->
                </select>
            </div>
            <label for="teacher_5">Teacher:</label>
            <select id="teacher_5" name="teacher_5"> <!-- ID와 name 모두 수정 -->
                <?php foreach ($teachers as $teacher): ?>
                    <option value="<?php echo $teacher['name']; ?>"><?php echo $teacher['name']; ?></option>
                <?php endforeach; ?>
            </select><br>
            <input type="text" id="books_5" name="books_5">
        </div>

        <div>
            <label for="time_6">1:55 - 2:40:</label>
            <div class="time_6" name="time_6">
                <label for="subject_6">Select Subject:</label>
                <select id="subject_6" name="subject_6"> <!-- ID와 name 모두 수정 -->
                    <!-- Subject options will be dynamically added here -->
                </select>
            </div>
            <label for="teacher_6">Teacher:</label>
            <select id="teacher_6" name="teacher_6"> <!-- ID와 name 모두 수정 -->
                <?php foreach ($teachers as $teacher): ?>
                    <option value="<?php echo $teacher['name']; ?>"><?php echo $teacher['name']; ?></option>
                <?php endforeach; ?>
            </select><br>
            <input type="text" id="books_6" name="books_6">
        </div>

        <div>
            <label for="time_7">2:50 - 3:35:</label>
            <div class="time_7" name="time_7">
                <label for="subject_7">Select Subject:</label>
                <select id="subject_7" name="subject_7"> <!-- ID와 name 모두 수정 -->
                    <!-- Subject options will be dynamically added here -->
                </select>
            </div>
            <label for="teacher_7">Teacher:</label>
            <select id="teacher_7" name="teacher_7"> <!-- ID와 name 모두 수정 -->
                <?php foreach ($teachers as $teacher): ?>
                    <option value="<?php echo $teacher['name']; ?>"><?php echo $teacher['name']; ?></option>
                <?php endforeach; ?>
            </select><br>
            <input type="text" id="books_7" name="books_7">
        </div>

        <div>
            <label for="time_8">3:45 - 4:30:</label>
            <div class="time_8" name="time_8">
                <label for="subject_8">Select Subject:</label>
                <select id="subject_8" name="subject_8"> <!-- ID와 name 모두 수정 -->
                    <!-- Subject options will be dynamically added here -->
                </select>
            </div>
            <label for="teacher_8">Teacher:</label>
            <select id="teacher_8" name="teacher_8"> <!-- ID와 name 모두 수정 -->
                <?php foreach ($teachers as $teacher): ?>
                    <option value="<?php echo $teacher['name']; ?>"><?php echo $teacher['name']; ?></option>
                <?php endforeach; ?>
            </select><br>
            <input type="text" id="books_8" name="books_8">
        </div>

        <div>
            <label for="time_9">4:40 - 5:25:</label>
            <div class="time_9" name="time_9">
                <label for="subject_9">Select Subject:</label>
                <select id="subject_9" name="subject_9"> <!-- ID와 name 모두 수정 -->
                    <!-- Subject options will be dynamically added here -->
                </select>
            </div>
            <label for="teacher_9">Teacher:</label>
            <select id="teacher_9" name="teacher_9"> <!-- ID와 name 모두 수정 -->
                <?php foreach ($teachers as $teacher): ?>
                    <option value="<?php echo $teacher['name']; ?>"><?php echo $teacher['name']; ?></option>
                <?php endforeach; ?>
            </select><br>
            <input type="text" id="books_9" name="books_9">
        </div>

        <!-- 필요한 만큼 시간대를 추가합니다. -->

        <input type="submit" value="Submit">
    </form>
    
    <!-- 선택된 책을 표시하는 부분 -->
    <div id="selectedBook"></div>

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
        
        default:
            console.log('Unknown course');
    }
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


    // php 변수를 가져와서 사용할 수 있도록 
    var level = "<?php echo $level; ?>";
    var course = "<?php echo $course; ?>";

    function updateBook(time) {
        var selectedSubject = document.getElementById('subject_' + time).value;
        var selectedBook = ''; // 선택된 책 정보를 저장할 변수

        // 선택된 레벨, 코스, 과목에 따라 책 정보를 설정합니다.
        if ((course === 'Premium' || course === 'Intensive' || course === 'Esl-Essential') && selectedSubject === 'Reading') {
            if (level === 'Beginner-1' || level === 'Elementary-2' || level === 'Elementary-3') {
                selectedBook = 'Reading Advantage1';
            } else if (level === 'Pre-Intermediate-4') {
                selectedBook = 'Reading Advantage2';
            } else if (level === 'Intermediate-5' || level === 'Intermediate-6') {
                selectedBook = 'Reading Advantage3';
            } else if (level === 'Upper-Intermediate-7' || level === 'Upper-Intermediate-8') {
                selectedBook = 'Reading Advantage4';
            } else if (level === 'Advanced-9' || level === 'Advanced-10' || level === 'Advanced-11' || level === 'Master-12') {
                selectedBook = 'Reading explorer 4';
            }
        }else if((course === 'Premium' || course =='Intensive' || course === 'Esl-Essential') && selectedSubject === 'Speaking') {
            if (level === 'Beginner-1' || level === 'Elementary-2' || level === 'Elementary-3') {
                selectedBook = 'Speaking Juice1';
            } else if(level === 'Pre-Intermediate-4') {
                selectedBook = "SLE 1";
            } else if (level ==='Intermediate-5' || level === 'Intermediate-6') {
                selectedBook = "SLE 2";
            } else if (level === "Upper-Intermediate-7" || level === 'Upper-Intermediate-8') {
                selectedBook = 'SLE 3';
            } else if (level === "Advanced-9" || level === 'Advanced-10' || level ==='Advanced-11' || level === 'Master-12') {
                selectedBook = 'EXpress yourself 1';
            }
        } else if ((course === 'Premium'|| course ==='Intensive' || course ==='Esl-Essential' || course ==='Power-Speaking') && selectedSubject === 'Grammar') {
            if (level === 'Beginner-1' || level === 'Elementary-2' || level === 'Elementary-3') {
                selectedBook = 'Side by Side1';
            } else if (level === 'Pre-Intermediate-4') {
                selectedBook = 'Basic Grammar in use';
            }  else if (level === 'Intermediate-5' || level === 'Intermediate-6') {
                selectedBook = 'Grammar in use Inter';
            } else if (level === 'Upper-Intermediate-7' || level === 'Upper-Intermediate-8') {
                selectedBook = 'Grammar in use Advanced';
            } else if (level === 'Advanced-9' || level === 'Advanced-10' || level === 'advanced-11' || level === 'Matser-12') {
                selectedBook = 'Destination C1';
            }
        } else if ((course === 'Premium'|| course ==='Intensive' || course ==='Esl-Essential' || course ==='Power-Speaking') && selectedSubject === 'Vocabulary') {
            if (level === 'Beginner-1' || level === 'Elementary-2' || level === 'Elementary-3') {
                selectedBook = 'Elementary Vocabulary';
            } else if (level === 'Pre-Intermediate-4') {
                selectedBook = 'Inter Vocabulary';
            } else if (level === 'Intermediate-5' || level === 'Intermediate-6') {
                selectedBook = 'Inter Vocabulary';
            } else if (level === 'Upper-Intermediate-7' || level === 'Upper-Intermediate-8') {
                selectedBook = '4000 words 5';
            } else if (level === 'Advanced-9' || level === 'advanced-10' || level === 'advanced-11' || level === 'Matser-12') {
                selectedBook = 'Destination C1';
            } 
        } else if (course ==='Power-Speaking' && selectedSubject === 'Speaking-Drill') {
            if (level === 'Beginner-1' || level === 'Elementary-2' || level === 'Elementary-3'|| level === 'Pre-Intermediate-4' || level === 'Intermediate-5' || leve === 'Intermediate-6') {
                selectedBook = 'Stage 1';
            } else {
                selectedBook= 'Stage 3';
            }
        } else if (course === 'Power-Speaking'&& selectedSubject === 'Speaking') {
            if (level === 'Beginner-1' || level === 'Elementary-2' || level === 'Elementary-3') {
                selectedBook = 'Speaking Juice1';
            }
            else if (level === 'Pre-Intermediate-4') {
                selectedBook = 'Speaking Juice3';
            }  
            else if(level === 'Intermediate-5' || level === 'Intermediate-6'){
                selectedBook = 'SLE 1';
            }
            else if(level === 'Upper-Intermediate-7'|| level ==='Upper-Intermediate-8') {
                selectedBook = 'SLE 2';
            }
            else{
                selectedBook ='SLE 3';
            }
        } else if ((course === 'Toeic' || course === 'Pre-Toeic') && level ==='No-Level') {
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
    document.getElementById('subject_1').addEventListener('change', function() { updateBook(1); });
    document.getElementById('subject_2').addEventListener('change', function() { updateBook(2); });
    document.getElementById('subject_3').addEventListener('change', function() { updateBook(3); });
    document.getElementById('subject_4').addEventListener('change', function() { updateBook(4); });
    document.getElementById('subject_5').addEventListener('change', function() { updateBook(5); });
    document.getElementById('subject_6').addEventListener('change', function() { updateBook(6); });
    document.getElementById('subject_7').addEventListener('change', function() { updateBook(7); });
    document.getElementById('subject_8').addEventListener('change', function() { updateBook(8); });
    document.getElementById('subject_9').addEventListener('change', function() { updateBook(9); });
    
</script>
</body>
</html>
<?php

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} 
?>