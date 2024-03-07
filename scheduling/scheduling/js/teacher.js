function addInfo() {
    // 입력된 이름과 방번호 가져오기
    var nameInput = document.getElementById("nameInput");
    var roomNumberInput = document.getElementById("roomNumberInput");

    var name = nameInput.value;
    var roomNumber = roomNumberInput.value;

    // 빈 입력 방지
    if (name.trim() === "" || roomNumber.trim() === "") {
        alert("이름과 방번호를 모두 입력하세요.");
        return;
    }

    // 이름과 방번호 리스트에 추가
    var infoList = document.getElementById("infoList");
    var listItem = document.createElement("li");

    // 리스트 아이템 내용
    listItem.innerHTML = name + " - 방번호: " + roomNumber;

    // 수정 및 삭제 버튼 추가
    var editBtn = document.createElement("span");
    editBtn.className = "edit-btn";
    editBtn.innerHTML = "수정";
    editBtn.onclick = function() {
        editInfo(listItem);
    };

    var deleteBtn = document.createElement("span");
    deleteBtn.className = "delete-btn";
    deleteBtn.innerHTML = "삭제";
    deleteBtn.onclick = function() {
        deleteInfo(listItem);
    };

    listItem.appendChild(editBtn);
    listItem.appendChild(deleteBtn);

    // 리스트에 추가
    infoList.appendChild(listItem);

    // 입력칸 비우기
    nameInput.value = "";
    roomNumberInput.value = "";
}

function editInfo(listItem) {
    var newName = prompt("새로운 이름을 입력하세요:");
    if (newName !== null && newName.trim() !== "") {
        listItem.firstChild.nodeValue = newName + " - " + listItem.firstChild.nodeValue.split("-")[1];
    }
}

function deleteInfo(listItem) {
    if (confirm("정말로 삭제하시겠습니까?")) {
        listItem.remove();
    }
}