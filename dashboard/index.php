<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: index.php");
    exit();
}

// Tên file CSV
$filename = "MOCK_DATA.csv";
$data = readCSV($filename); // Populate $data with CSV content

// check if form is submitted to add student
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin từ form
    $studentID = $_POST["studentID"];
    $name = $_POST["name"];
    $gender = $_POST["gender"];
    $dob = $_POST["dob"];
    $date = DateTime::createFromFormat('Y-m-d', $dob);
    $dob = $date->format('m/d/Y');

    // check if studentID already exists
    $exists = false;
    foreach ($data as $row) {
        if ($row[0] == $studentID) {
            $exists = true;
            break;
        }
    }

    if ($exists) {
        // alert when studentID already exists
        echo "<script>alert('Student ID already exists. Please use a different ID.');</script>";
    } else {
        // if studentID does not exist, add new student to data array
        $data[] = [$studentID, $name, $gender, $dob];

        // Sort data by studentID (assuming studentID is the first element in each row)
        usort($data, function($a, $b) {
            return $a[0] <=> $b[0]; // So sánh tăng dần theo studentID
        });

        // Ghi dữ liệu đã sắp xếp lại vào file CSV
        $file = fopen($filename, "w");
        foreach ($data as $row) {
            fputcsv($file, $row);
        }
        fclose($file);

        // redirect to index.php after adding data
        header("Location: index.php");
        exit();
    }
}

// Hàm để đọc CSV
function readCSV($filename) {
    $data = [];
    if (($file = fopen($filename, "r")) !== false) {
        while (($row = fgetcsv($file, 1000, ",")) !== false) {
            $data[] = $row;
        }
        fclose($file);
    }
    return $data;
}


// delete student from CSV
function deleteStudent($filename, $studentID)
{
    if (file_exists($filename)) {
        $data = readCSV($filename);
        $newData = [];

        // filter data, keep students without the specified studentID
        foreach ($data as $row) {
            if ($row[0] != $studentID) {
                $newData[] = $row;
            }
        }

        // write new data to CSV
        $file = fopen($filename, "w");
        foreach ($newData as $row) {
            fputcsv($file, $row);
        }
        fclose($file);
    }
}

if (isset($_GET["delete"])) {
    $studentID = $_GET["delete"];
    deleteStudent($filename, $studentID);
    header("Location: index.php");
    exit();
}

// read data from CSV to display on the table
$students = readCSV($filename);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="fullcontainer">
        <div class="header">
            <div class="header-content">
                <div>
                    <h1>Student List</h1>
                </div>
                <a href="logout.php" class="logout-icon">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
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
        <button onclick="topFunction()" id="scrollTopBtn">
          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-up-square-fill" viewBox="0 0 16 16">
            <path d="M2 16a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2zm6.5-4.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 1 0"/>
          </svg>
        </button>
    </div>
</body>
<script src="scripts.js"></script>

</html>