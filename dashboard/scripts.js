const addStudentButton = document.getElementById('showForm');
const studentForm = document.getElementById('studentForm');
const closeFormButton = document.getElementById('closeForm');
const mybutton = document.getElementById("scrollTopBtn");
// Sự kiện khi nhấn nút "Add Student"
addStudentButton.addEventListener('click', function () {
    studentForm.style.display = 'block';
});

// Sự kiện khi nhấn nút "X" để đóng form
closeFormButton.addEventListener('click', function (event) {
    event.preventDefault();
    studentForm.style.display = 'none';
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
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}

function topFunction() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}