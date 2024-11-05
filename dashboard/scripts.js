const addStudentButton = document.getElementById('showForm');
const studentForm = document.getElementById('studentForm');
const closeFormButton = document.getElementById('closeForm');
const mybutton = document.getElementById("scrollTopBtn");
const nameError = document.getElementById('nameError');
const studentIDError = document.getElementById('studentIDError');
// Sự kiện khi nhấn nút "Add Student"
addStudentButton.addEventListener('click', function () {
    studentForm.style.display = 'block';
});

// Sự kiện khi nhấn nút "X" để đóng form
closeFormButton.addEventListener('click', function (event) {
    event.preventDefault();
    studentForm.style.display = 'none';
    nameError.style.display = 'none';
    studentIDError.style.display = 'none';
    document.getElementById('studentForm').reset();
});

document.getElementById('searchInput').addEventListener('input', function () {
    var input = this.value.toLowerCase();
    var rows = document.querySelectorAll('#studentTable tbody tr');

    rows.forEach(function (row) {
        var studentID = row.cells[0].textContent.toLowerCase();
        var name = row.cells[1].textContent.toLowerCase();
        var gender = row.cells[2].textContent.toLowerCase();
        var dob = row.cells[3].textContent.toLowerCase();

        if (studentID.includes(input) || name.includes(input) || gender.includes(input) || dob.includes(input)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Kiểm tra khi nhập vào trường tên
document.getElementById('name').addEventListener('input', function () {
  var name = this.value;
  // Kiểm tra xem tên có chỉ chứa các ký tự chữ cái không
  var nameRegex = /^[\p{L}\s]+$/u; // Regex cho phép chữ cái và khoảng trắng

  if (!nameRegex.test(name)) {
      nameError.textContent = 'Name must contain only letters.'; // Thông báo lỗi
      nameError.style.display = 'block'; // Hiển thị thông báo lỗi
  } else {
      nameError.style.display = 'none'; // Ẩn thông báo lỗi nếu hợp lệ
  }
});

// Kiểm tra khi nhập vào trường studentID
document.getElementById('studentID').addEventListener('input', function () {
  var studentID = this.value;

  // Kiểm tra xem studentID có chỉ chứa các số không
  var studentIDRegex = /^[0-9]+$/; // Regex cho phép chỉ số

  if (!studentIDRegex.test(studentID)) {
      studentIDError.textContent = 'Student ID must contain only numbers.'; // Thông báo lỗi
      studentIDError.style.display = 'block'; // Hiển thị thông báo lỗi
  } else {
      studentIDError.style.display = 'none'; // Ẩn thông báo lỗi nếu hợp lệ
  }
});

document.getElementById('studentForm').addEventListener('submit', function (event) {
  var studentID = document.getElementById('studentID').value;
  var name = document.getElementById('name').value;

  // Kiểm tra xem tên có chỉ chứa các ký tự chữ cái không
  var nameRegex = /^[\p{L}\s]+$/u; // Regex cho phép chữ cái và khoảng trắng

  // Kiểm tra xem studentID có chỉ chứa các số không
  var studentIDRegex = /^[0-9]+$/; // Regex cho phép chỉ số

  let isValid = true; // Biến để theo dõi tính hợp lệ

  if (!nameRegex.test(name)) {
      nameError.textContent = 'Name must contain only letters.'; // Thông báo lỗi
      nameError.style.display = 'block'; // Hiển thị thông báo lỗi
      isValid = false; // Đánh dấu là không hợp lệ
  } else {
      nameError.style.display = 'none'; // Ẩn thông báo lỗi nếu hợp lệ
  }

  if (!studentIDRegex.test(studentID)) {
      studentIDError.textContent = 'Student ID must contain only numbers.'; // Thông báo lỗi
      studentIDError.style.display = 'block'; // Hiển thị thông báo lỗi
      isValid = false; // Đánh dấu là không hợp lệ
  } else {
      studentIDError.style.display = 'none'; // Ẩn thông báo lỗi nếu hợp lệ
  }

  // Nếu không hợp lệ, ngăn chặn gửi biểu mẫu
  if (!isValid) {
      event.preventDefault(); // Ngăn chặn gửi biểu mẫu
  }
});


// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () {
  scrollFunction();
};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  window.scrollTo({
    top: 0,
    behavior: 'smooth' // Thêm hiệu ứng cuộn mượt
  });
}
