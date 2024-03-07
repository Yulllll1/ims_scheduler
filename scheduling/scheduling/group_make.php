<?php
include ('main.php');
include 'halo.php';

try{
    // 데이터베이스 연결 설정
    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $dbname = "timetable_db";
    
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password); 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

    
    //선생님 정보 가져오기
    $teachers = $conn->query("SELECT * FROM teacherss")->fetchAll(PDO::FETCH_ASSOC);



} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>


<html>
    <div class="container">
        <h1>Make a Group class</h1>

        <form action="group.php" method="POST">
            <div>
                <label for="time">Time:</label>
                <select id="time" name="time">
                    <option value="Select">Select</option>
                    <option value="8:30 - 9:15">8:30 - 9:15</option>
                    <option value="9:25 - 10:10">9:25 - 10:10</option>
                    <option value="10:20 - 11:05">10:20 - 11:05</option>
                    <option value="11:15 - 12:00">11:15 - 12:00</option>
                    <option value="Lunch-Time">Lunch Time</option>
                    <option value="1:00 - 1:45">1:00 - 1:45</option>
                    <option value="1:55 - 2:40">1:55 - 2:40</option>
                    <option value="2:50 - 3:35">2:50 - 3:35</option>
                    <option value="3:45 - 4:30">3:45 - 4:30</option>
                    <option value="4:40 - 5:25">4:40 - 5:25</option>
                    <!-- 다른 시간대를 추가할 수 있습니다. -->
                </select>
            </div>
        
            <div>
                <label>Subject Type:</label>
                <div>
                    <input type="radio" id="writing" name="subject_type" value="Writing">
                    <label for="writing">Writing</label>
                </div>
                <div>
                    <input type="radio" id="reading" name="subject_type" value="Reading">
                    <label for="reading">Reading</label>
                </div>
                <div>
                    <input type="radio" id="listening" name="subject_type" value="Listening">
                    <label for="listening">Listening</label>
                </div>
                <div>
                    <input type="radio" id="conversation" name="subject_type" value="Conversation">
                    <label for="conversation">Conversation</label>
                </div>
                <div>
                    <input type="radio" id="ielts" name="subject_type" value="Ielts">
                    <label for="ielts">IELTS</label>
                </div>
                <div>
                    <input type="radio" id="junior" name="subject_type" value="Junior">
                    <label for="junior">Junior</label>
                </div>
                <div>
                    <input type="radio" id="business" name="subject_type" value="Business">
                    <label for="business">Business</label>
                </div>
                
            </div>
        
            <div>
                <label for="subject">Subject:</label>
                <select id="subject" name="subject">
                    <!-- Subject 옵션들은 JavaScript를 통해 동적으로 추가됩니다. -->
                    <option value="Select">Select</option>
                </select>
            </div>
        
            <div>
                <label for="teacher">Teacher:</label>
                <select id="teacher" name="teacher">
                <?php foreach ($teachers as $teacher): ?>
                    <option value="<?php echo $teacher['name']; ?>"><?php echo $teacher['name']; ?></option>
                <?php endforeach; ?>
                </select>
            </div>
        
            <div>
                <label for="room_number">Room Number:</label>
                <select id="room_number" name="room_number">
                    <option value="G-560">G-560</option>
                    <option value="G-561">G-561</option>
                    <option value="G-562">G-562</option>
                    <option value="G-563">G-563</option>
                    <option value="G-564">G-564</option>
                    <option value="G-565">G-565</option>
                    <option value="G-566">G-566</option>
                    <option value="G-567">G-567</option>
                    <option value="G-568">G-568</option>
                    <option value="G-569">G-569</option>
                    <option value="G-570">G-570</option>
                    <option value="G-outside">G-Outside</option>
                </select>
            </div>
        
            <input type="submit" value="Submit">
        </form>
    </div>

    <script>
        // Subject 옵션들
        
        var subjects = {
            Writing: ['Writing-1', 'Writing-2', 'Writing-3', 'Writing-4'],
            Reading: ['IELTS-INTEG(Academic)', 'IELTS-INTEG(General)','Economic-TOEIC-RC'],
            Listening: ['Listening-1', 'Listening-2', 'Listening-3','Listening-5', 'Power-Speaking-Listening-1', 'Power-speaking-Listening-2', 'Power-Speaking-Listening-3', 'Economic-TOEIC-LC'],
            Conversation: ['Speaking-Beginner', 'Conversation-1', 'Conversation-2', 'Conversation-3','Native1', 'Native2'],
            Junior: ['Junior-Writing','Junior-Native','Junior-Integration','Junior-Listening','Junior-Writing','Special 9th', 'Playing time'],
            Business: ['Business-Integration1', 'Business-Integration2', 'Presentation'],
            Ielts: ['IELTS-Listening', 'IELTS-Listening(Pre-IELTS)', 'IELTS-Writing-Task2', 'IELTS-Grammar-Voca','IELTS-Grammar-Voca(PRE IELTS)','IELTS-Integration','IELTS-Integration(General)']
        };

        // Subject를 동적으로 업데이트하는 함수
        function updateSubjectOptions() {
            var subjectType = document.querySelector('input[name="subject_type"]:checked').value;
            var subjectSelect = document.getElementById('subject');
            subjectSelect.innerHTML = ''; // 기존 옵션 초기화
            subjects[subjectType].forEach(function(subject) {
                var optionElement = document.createElement('option');
                optionElement.value = subject;
                optionElement.textContent = subject;
                subjectSelect.appendChild(optionElement);
            });
        }

         // 선생님의 시간표를 저장하는 객체
    var teacherAvailability = {
        "8:30 - 9:15": <?php echo json_encode($time1); ?>,
        "9:25 - 10:10": <?php echo json_encode($time2); ?>,
        "10:20 - 11:05": <?php echo json_encode($time3); ?>,
        "11:15 - 12:00": <?php echo json_encode($time4); ?>,
        "1:00 - 1:45": <?php echo json_encode($time5); ?>,
        "1:55 - 2:40": <?php echo json_encode($time6); ?>,
        "2:50 - 3:35": <?php echo json_encode($time7); ?>,
        "3:45 - 4:30": <?php echo json_encode($time8); ?>,
        "4:40 - 5:25": <?php echo json_encode($time9); ?>
    };

    // 시간대가 변경될 때 선생님 목록 업데이트
    document.getElementById('time').addEventListener('change', function() {
        var selectedTime = this.value;
        var teacherSelect = document.getElementById('teacher');

        // 모든 옵션 삭제
        teacherSelect.innerHTML = '';

        // 모든 선생님을 가져옵니다.
        var allTeachers = <?php echo json_encode(array_column($teachers, 'name')); ?>;

        // 선택된 시간에 대한 선생님 목록을 생성
        var availableTeachers = allTeachers.filter(function(teacher) {
            return !teacherAvailability[selectedTime].includes(teacher);
        });

        // 선생님 목록에 옵션 추가
        availableTeachers.forEach(function(teacher) {
            var option = document.createElement('option');
            option.value = teacher;
            option.textContent = teacher;
            teacherSelect.appendChild(option);
        });
    });
        
        

        // 페이지 로딩 시 Subject 옵션 초기화
        window.onload = function() {
            updateSubjectOptions();
        };

        // Subject Type이 변경될 때마다 Subject 옵션 업데이트
        var radioInputs = document.querySelectorAll('input[name="subject_type"]');
        radioInputs.forEach(function(input) {
            input.addEventListener('change', updateSubjectOptions);
        });

        
        
    </script>
</html>
