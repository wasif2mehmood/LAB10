<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delete Employee</title>

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
      padding: 0;
      margin: 0;
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
      background-color: #e74c3c;
      color: #fff;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #c0392b;
    }

    h2 {
      text-align: center;
      color: #333;
    }

    .message {
      text-align: center;
      margin-top: 200px;
      padding: 10px;
      background-color: #e74c3c;
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

  // Prepare and execute SQL query for deletion
  $sql = "DELETE FROM employees WHERE employeeNumber=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $employeeNumber);

  if ($stmt->execute()) {
    echo "Employee deleted successfully.";
  } else {
    echo "Error deleting employee: " . $stmt->error;
  }

  $stmt->close();
}
?>

<!-- Navigation -->
<nav>
  <ul class="navigation">
    <li class="active"><a href="index.php">Create</a></li>
    <li><a href="update.php">Update</a></li>
    <li><a href="delete.php">Delete</a></li>
    <li><a href="view.php">View</a></li>
  </ul>
</nav>

<!-- Delete Employee Form -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <h2>Delete Employee</h2>

  <label for="employeeNumber">Employee Number:</label>
  <input type="number" name="employeeNumber" required>

  <input type="submit" value="Delete Employee">

  <div class="message" id="errorMessage">Error deleting employee.</div>
</form>

<script>
  // Show error message after form submission
  if (window.location.href.indexOf("error=true") > -1) {
    document.getElementById("errorMessage").style.display = "block";
  }
</script>

</body>
</html>
