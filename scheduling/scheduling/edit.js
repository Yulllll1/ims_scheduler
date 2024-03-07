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



window.onload = function() {
    setSubjectOptions();
};    



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
        } else if (level === 'Advanced-9' || level === 'Advanced-10' || level === 'advanced-11' || level === 'Master-12') {
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
        } else if (level === 'Advanced-9' || level === 'advanced-10' || level === 'advanced-11' || level === 'Master-12') {
            selectedBook = 'Destination C1';
        } 
    } else if (course ==='Power-Speaking' && selectedSubject === 'Speaking-Drill') {
        if (level === 'Beginner-1' || level === 'Elementary-2' || level === 'Elementary-3'|| level === 'Pre-Intermediate-4' || level === 'Intermediate-5' || level === 'Intermediate-6') {
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

// 페이지 로딩 시 과목 옵션 초기화