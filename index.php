
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Programming Quiz</title>

  <style>
    
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
    }
    .navigation {
            display: flex;
            align-items: center;
            background-color: green;
            height: 50px;
            list-style: none;
        }

        .navigation li {
            margin: 0;
            padding: 0 20px;
        }

        .navigation a {
            font-size: 18px;
            text-decoration: none;
            color: #ffffff;
            transition: color 0.3s ease-in-out;
        }

        .navigation a:hover {
            color: #dc6060;
        }
    form {
      max-width: 600px;
      margin: auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    label {
      display: block;
      margin-bottom: 8px;
    }

    input {
      width: 100%;
      padding: 8px;
      margin-bottom: 12px;
      box-sizing: border-box;
    }

    input[type="submit"] {
      background-color: #4caf50;
      color: #fff;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }

    h2 {
      text-align: center;
      color: #333;
    }

    .message {
      text-align: center;
      margin-top: 20px;
      padding: 10px;
      background-color: #4caf50;
      color: #fff;
      display: none;
    }
  </style>
</head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "23031946";
$dbname = "classicmodels";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Collect form data
  $employeeNumber = $_POST["employeeNumber"];
  $lastName = $_POST["lastName"];
  $firstName = $_POST["firstName"];
  $extension = $_POST["extension"];
  $email = $_POST["email"];
  $officeCode = $_POST["officeCode"];
  $reportsTo = $_POST["reportsTo"];
  $jobTitle = $_POST["jobTitle"];

  // Prepare and execute SQL query
  $sql = "INSERT INTO employees (employeeNumber, lastName, firstName, extension, email, officeCode, reportsTo, jobTitle) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("isssssis", $employeeNumber, $lastName, $firstName, $extension, $email, $officeCode, $reportsTo, $jobTitle);

  if ($stmt->execute()) {
    echo "Employee added successfully.";
  } else {
    echo "Error adding employee: " . $stmt->error;
  }

  $stmt->close();
}

$conn->close();
?>


<!-- Employee Form -->
<nav>
        <ul class="navigation">
            <!-- Link to other pages here -->
            <li class="active"><a href="">Create</a></li>
            <li><a href="update.php">Update</a></li>
            <li><a href="delete.php">Delete</a></li>
            <li><a href="view.php">View</a></li>
            
        </ul>
    </nav>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <h2>Add Employee</h2>

  <label for="employeeNumber">Employee Number:</label>
  <input type="number" name="employeeNumber" required>

  <label for="lastName">Last Name:</label>
  <input type="text" name="lastName" required>

  <label for="firstName">First Name:</label>
  <input type="text" name="firstName" required>

  <label for="extension">Extension:</label>
  <input type="text" name="extension" required>

  <label for="email">Email:</label>
  <input type="email" name="email" required>

  <label for="officeCode">Office Code:</label>
  <input type="text" name="officeCode" required>

  <label for="reportsTo">Reports To:</label>
  <input type="number" name="reportsTo">

  <label for="jobTitle">Job Title:</label>
  <input type="text" name="jobTitle" required>

  <input type="submit" value="Add Employee">

  <div class="message" id="successMessage">Employee added successfully.</div>
</form>

<script>
  // Show success message after form submission
  if (window.location.href.indexOf("success=true") > -1) {
    document.getElementById("successMessage").style.display = "block";
  }
</script>

</body>
</html>
