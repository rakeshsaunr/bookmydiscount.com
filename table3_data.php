<?php
session_start();

// Check if UID is set in the session
if (isset($_SESSION['UID'])) {
    $host = "localhost";
    $dbname = "eds_erp";
    $username = "root";
    $password = "";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }

    // Prepare the SQL statement
    $query = "SELECT * FROM user WHERE id = ?";

    // Prepare the statement
    $stmt = $pdo->prepare($query);

    // Bind the UID parameter
    $stmt->bindParam(1, $_SESSION['UID']);

    // Execute the statement
    $stmt->execute();

    // Fetch the data
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the data in JSON format
    echo json_encode($data);
} else {
    // If UID is not set in the session, return an empty array
    echo json_encode([]);
}

?>
