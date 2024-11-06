<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: index.php");
    exit();
}

// Tên file CSV
$filename = "MOCK_DATA.csv";
if (!file_exists($filename)) {
    $file = fopen($filename, "w");
    fclose($file);

}
$data = readCSV($filename); // Populate $data with CSV content
$existingStudentID = '';
// check if form is submitted to add student
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["importCSV"])) {
        importCSV($filename);
    } else {
        // Lấy thông tin từ form
        $studentID = $_POST["studentID"] ?? null;
        $name = $_POST["name"] ?? null;
        $gender = $_POST["gender"] ?? null;
        $dob = $_POST["dob"] ?? null;

        if ($studentID && $name && $gender && $dob) {
            $date = DateTime::createFromFormat('Y-m-d', $dob);
            if ($date) {
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
            } else {
                echo "<script>alert('Invalid date format.');</script>";
            }
        } else {
            echo "<script>alert('All fields are required.');</script>";
        }
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

// Hàm để xuất CSV
function exportCSV($filename) {
    // Đọc dữ liệu từ CSV
    $data = readCSV($filename);

    // Thiết lập tiêu đề cho file CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="students_export.csv"');

    // Mở output stream
    $output = fopen('php://output', 'w');

    // Ghi tiêu đề cột
    fputcsv($output, ['StudentID', 'Name', 'Gender', 'Date of Birth']);

    // Ghi dữ liệu sinh viên
    foreach ($data as $row) {
        fputcsv($output, $row);
    }

    // Đóng output stream
    fclose($output);
    exit();
}

// Hàm để nhập CSV
// Hàm để nhập CSV
function importCSV($filename) {
    if (isset($_FILES["importFile"]) && $_FILES["importFile"]["error"] == 0) {
        $importFile = $_FILES["importFile"]["tmp_name"];
        $data = readCSV($filename);
        $importData = readCSV($importFile);

        // Merge imported data with existing data
        $data = array_merge($data, $importData);

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

        // redirect to index.php after importing data
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Error uploading file.');</script>";
    }
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

if (isset($_GET["export"])) {
    exportCSV($filename);
    header("Location: index.php");
}

// read data from CSV to display on the table
$students = readCSV($filename);
?>