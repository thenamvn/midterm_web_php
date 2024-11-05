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