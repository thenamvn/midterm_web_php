<?php
// Tên file CSV
$filename = "MOCK_DATA.csv";

// Kiểm tra nếu form được submit để thêm sinh viên
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin từ form
    $studentID = $_POST["studentID"];
    $name = $_POST["name"];
    $gender = $_POST["gender"];
    $dob = $_POST["dob"];
    $date = DateTime::createFromFormat('Y-m-d', $dob);
    $dob = $date->format('m/d/Y');
    

    // Mở file CSV và thêm dòng mới
    $file = fopen($filename, "a");
    fputcsv($file, [$studentID, $name, $gender, $dob]);
    fclose($file);

    // Chuyển hướng về trang chính sau khi thêm dữ liệu
    header("Location: index.php");
    exit();
}

// Hàm đọc file CSV và trả về dữ liệu
function readCSV($filename)
{
    $data = [];
    if (file_exists($filename)) {
        if (($file = fopen($filename, "r")) !== FALSE) {
            while (($row = fgetcsv($file, 1000, ",")) !== FALSE) {
                $data[] = $row;
            }
            fclose($file);
        }
    }
    return $data;
}

// Hàm xóa sinh viên khỏi CSV
function deleteStudent($filename, $studentID)
{
    if (file_exists($filename)) {
        $data = readCSV($filename);
        $newData = [];

        // Lọc dữ liệu, giữ lại những sinh viên không có studentID được chỉ định
        foreach ($data as $row) {
            if ($row[0] != $studentID) {
                $newData[] = $row;
            }
        }

        // Ghi lại dữ liệu mới vào CSV
        $file = fopen($filename, "w");
        foreach ($newData as $row) {
            fputcsv($file, $row);
        }
        fclose($file);
    }
}

// Nếu có yêu cầu xóa sinh viên
if (isset($_GET["delete"])) {
    $studentID = $_GET["delete"];
    deleteStudent($filename, $studentID);

    // Chuyển hướng về trang chính sau khi xóa dữ liệu
    header("Location: index.php");
    exit();
}

// Đọc dữ liệu từ CSV để hiển thị lên bảng
$students = readCSV($filename);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student List</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="fullcontainer">
        <div class="header">
            <div class="header-content">
                <h1>Student List</h1>
            </div>
            <div class="header-button">
                <button class="normalButton" id="showForm">Add Student</button>
                <div class="search-container">
                    <input id="searchInput" placeholder="Search..." class="search-input">
                </div>
            </div>
        </div>
        <div class="form-wrapper">
            <div class="form-content">
                <table id="studentTable">
                    <thead>
                        <tr>
                            <th>StudentID</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Date of Birth</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($students)) : ?>
                            <?php foreach ($students as $student) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($student[0]); ?></td>
                                    <td><?php echo htmlspecialchars($student[1]); ?></td>
                                    <td><?php echo htmlspecialchars($student[2]); ?></td>
                                    <td><?php echo htmlspecialchars($student[3]); ?></td>
                                    <td>
                                        <form action="index.php" method="get">
                                            <input type="hidden" name="delete" value="<?php echo $student[0]; ?>">
                                            <button type="submit" class="normalButton">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5">No students found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <form id="studentForm" class="formAdd" action="index.php" method="POST" style="display: none;">
                    <button class="closeButton" id="closeForm">X</button>
                    <div class="form-group">
                        <label for="studentID">StudentID</label>
                        <div class="form-input">
                            <input placeholder="Enter your StudentID" required type="number" name="studentID" id="studentID">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <div class="form-input">
                            <input placeholder="Enter your name" name="name" id="name">
                        </div>
                    </div>

                    <div class="gender-selection">
                        <label>Gender:</label>
                        <p>
                            <input type="radio" name="gender" value="Male"> Male
                        </p>
                        <p>
                            <input type="radio" name="gender" value="Female"> Female
                        </p>
                    </div>

                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <div class="form-input">
                            <input required type="date" name="dob" id="dob">
                        </div>
                    </div>

                    <div>
                        <button class="normalButton" type="submit">Add Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="scripts.js"></script>

</html>