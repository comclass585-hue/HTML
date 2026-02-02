<?php
// 1. Enable Error Reporting (This helps us see what's wrong)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Database Connection Details
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "giet_university";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if connection worked
if (!$conn) {
    die("<h2 style='color:red;'>Connection Failed:</h2> " . mysqli_connect_error());
}

// 3. Check if the form was actually submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Capture data and clean it to prevent errors
    $student_no = mysqli_real_escape_string($conn, $_POST['st_no']);
    $name       = mysqli_real_escape_string($conn, $_POST['st_name']);
    $gender     = isset($_POST['GENDER']) ? mysqli_real_escape_string($conn, $_POST['GENDER']) : "Not Specified";
    $pass       = mysqli_real_escape_string($conn, $_POST['pass']); 
    $branch     = mysqli_real_escape_string($conn, $_POST['BRANCH']);
    $address    = mysqli_real_escape_string($conn, $_POST['address']);

    // 4. The SQL Query
    // IMPORTANT: Ensure these column names match your phpMyAdmin table exactly!
    $sql = "INSERT INTO students (student_no, student_name, gender, password, branch, address)
            VALUES ('$student_no', '$name', '$gender', '$pass', '$branch', '$address')";

    echo "<div style='text-align:center; padding:50px; font-family:Arial;'>";

    if (mysqli_query($conn, $sql)) {
        echo "<h1 style='color:green;'>Registration Successful!</h1>";
        echo "<p>Student <b>$name</b> has been saved to the database.</p>";
        echo "<p>Redirecting back to form in 3 seconds...</p>";
        
        // Auto-redirect back to index.html
        header("refresh:3; url=index.html");
    } else {
        // This will print the EXACT error from MySQL if it fails
        echo "<h1 style='color:red;'>Database Error:</h1>";
        echo "<p>" . mysqli_error($conn) . "</p>";
        echo "<br><a href='index.html'>Go Back</a>";
    }

    echo "</div>";
}

// 5. Close Connection
mysqli_close($conn);
?>