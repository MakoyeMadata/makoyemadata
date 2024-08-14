<?php
// Include database connection
include 'db_conn.php';

// Query to count the number of rows where the status is 'success'
$sql = "SELECT COUNT(*) AS count FROM service_deliveries";

// Execute the query
$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Fetch the count from the result
        $row = $result->fetch_assoc();
        $count = $row['count'];

        // Return the count as JSON response
        header('Content-Type: application/json');
        echo json_encode(['count' => $count]);
    } else {
        // If no rows found, return count as 0
        header('Content-Type: application/json');
        echo json_encode(['count' => 0]);
    }
} else {
    // If query execution failed, return an error message
    header('HTTP/1.1 500 Internal Server Error');
    header('Content-Type: application/json');
    echo json_encode(['error' => mysqli_error($conn)]);
}

// Close database connection
$conn->close();
?>
