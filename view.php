<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Employees</title>

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

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #4caf50;
      color: #fff;
    }

    a {
      text-decoration: none;
    }

    .update, .delete {
      padding: 5px 10px;
      margin: 2px;
      display: inline-block;
      text-align: center;
      border-radius: 3px;
      cursor: pointer;
    }

    .update {
      background-color: #3498db;
      color: #fff;
    }

    .delete {
      background-color: red;
      color: #fff;
    }

    .delete-link {
        background-color: red;
      cursor: pointer;
    }
  </style>
</head>
<body>
<nav>
  <ul class="navigation">
    <!-- Link to other pages here -->
    <li class="active"><a href="index.php">Create</a></li>
    <li><a href="update.php">Update</a></li>
    <li><a href="delete.php">Delete</a></li>
    <li><a href="view.php">View</a></li>
  </ul>
</nav>

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

// Process deletion if the employeeNumber is provided in the URL
if (isset($_GET['employeeNumber'])) {
  $employeeNumberToDelete = $_GET['employeeNumber'];

  // Prepare and execute SQL query for deletion
  $deleteSql = "DELETE FROM employees WHERE employeeNumber=?";
  $deleteStmt = $conn->prepare($deleteSql);
  $deleteStmt->bind_param("i", $employeeNumberToDelete);

  if ($deleteStmt->execute()) {
    echo "Employee deleted successfully.";
  } else {
    echo "Error deleting employee: " . $deleteStmt->error;
  }

  $deleteStmt->close();
}

// Query to retrieve employee data with related information
$sql = "SELECT e.employeeNumber, e.lastName, e.firstName, e.extension, e.email, 
               o.city AS officeName, r.firstName AS reportsToFirstName, r.lastName AS reportsToLastName, e.jobTitle
        FROM employees e
        LEFT JOIN offices o ON e.officeCode = o.officeCode
        LEFT JOIN employees r ON e.reportsTo = r.employeeNumber";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo "<table>";
  echo "<tr>
          <th>Employee Number</th>
          <th>Last Name</th>
          <th>First Name</th>
          <th>Extension</th>
          <th>Email</th>
          <th>Office</th>
          <th>Reports To</th>
          <th>Job Title</th>
          <th>Actions</th>
        </tr>";

  while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['employeeNumber']}</td>
            <td>{$row['lastName']}</td>
            <td>{$row['firstName']}</td>
            <td>{$row['extension']}</td>
            <td>{$row['email']}</td>
            <td>{$row['officeName']}</td>
            <td>{$row['reportsToFirstName']} {$row['reportsToLastName']}</td>
            <td>{$row['jobTitle']}</td>
            <td>
              <a class='update' href='update.php?employeeNumber={$row['employeeNumber']}'>Update</a>
              <span class='delete' onclick='confirmDelete({$row['employeeNumber']})'>Delete</span>
            </td>
          </tr>";
  }

  echo "</table>";
} else {
  echo "No records found.";
}

$conn->close();
?>

<script>
  function confirmDelete(employeeNumber) {
    var confirmDelete = confirm("Are you sure you want to delete this employee?");
    if (confirmDelete) {
      window.location.href = "view.php?employeeNumber=" + employeeNumber;
    }
  }
</script>

</body>
</html>
