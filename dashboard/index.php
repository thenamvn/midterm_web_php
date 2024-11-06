<?php include 'function.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>WAD2024</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="fullcontainer">
        <div id="myModal" class="modal" style="display: <?php echo $showModal ? 'block' : 'none'; ?>;">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <p>Student ID <strong><?php echo htmlspecialchars($existingStudentID); ?></strong> already exists. Please use a different ID.</p>
            </div>
        </div>
        <div class="header">
            <div class="header-content">
                <div>
                    <h1>WAD2024</h1>
                </div>
                <a href="logout.php" class="logout-icon">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
            <div class="header-button">
                <div class="header-left">
                    <button class="normalButton" id="showForm">Add Student</button>
                    <form action="index.php" method="get" style="display:inline;">
                        <input type="hidden" name="export" value="1">
                        <button class="normalButton" type="submit" id="exportCSV">Export CSV</button>
                    </form>
                </div>
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
                                            <button type="submit" class="delButton">Delete</button>
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
                            <p style="display: none;" class="error" id="studentIDError"></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <div class="form-input">
                            <input placeholder="Enter your name" name="name" id="name">
                            <p style="display: none;" class="error" id="nameError"></p>
                        </div>
                    </div>

                    <div class="gender-selection">
                        <label>Gender:</label>
                        <p>
                            <input type="radio" name="gender" value="Male" required> Male
                        </p>
                        <p>
                            <input type="radio" name="gender" value="Female" required> Female
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
                <path d="M2 16a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2zm6.5-4.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 1 0" />
            </svg>
        </button>
    </div>
</body>
<script src="scripts.js"></script>

</html>