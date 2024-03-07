document.getElementById("studentForm").addEventListener("submit", function(event) {
    event.preventDefault();
    
    // 폼 데이터를 가져오기
    var name = document.getElementById("name").value;
    var course = document.getElementById("course").value;
    var level = document.getElementById("level").value;
    var startDate = document.getElementById("startDate").value;
    var endDate = document.getElementById("endDate").value;

    // 가져온 데이터 출력 (여기에서는 콘솔에 출력)
    console.log("이름: " + name);
    console.log("코스: " + course);
    console.log("레벨: " + level);
    console.log("시작 날짜: " + startDate);
    console.log("끝나는 날짜: " + endDate);

    // 여기서 서버에 데이터를 전송하거나 다른 작업을 수행할 수 있습니다.
});