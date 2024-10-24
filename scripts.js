// Lấy ra input và thêm sự kiện input
// Lấy các phần tử HTML cần thiết
const addStudentButton = document.getElementById('showForm');
const studentForm = document.getElementById('studentForm');
const closeFormButton = document.getElementById('closeForm');

// Sự kiện khi nhấn nút "Add Student"
addStudentButton.addEventListener('click', function () {
    studentForm.style.display = 'block'; // Hiển thị form
});

// Sự kiện khi nhấn nút "X" để đóng form
closeFormButton.addEventListener('click', function (event) {
    event.preventDefault(); // Ngăn hành vi mặc định (nếu có)
    studentForm.style.display = 'none'; // Ẩn form
});

document.getElementById('searchInput').addEventListener('input', function () {
    var input = this.value.toLowerCase();
    var rows = document.querySelectorAll('#studentTable tbody tr');

    // Duyệt qua tất cả các dòng trong bảng và kiểm tra giá trị
    rows.forEach(function (row) {
        var studentID = row.cells[0].textContent.toLowerCase();
        var name = row.cells[1].textContent.toLowerCase();
        var gender = row.cells[2].textContent.toLowerCase();
        var dob = row.cells[3].textContent.toLowerCase();

        // Nếu dữ liệu dòng nào phù hợp với giá trị nhập vào thì hiển thị dòng đó, ngược lại ẩn đi
        if (studentID.includes(input) || name.includes(input) || gender.includes(input) || dob.includes(input)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});