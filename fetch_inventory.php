<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'eds_erp');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Get store ID from query parameters
if (isset($_GET['store_id'])) {
    $store_id = intval($_GET['store_id']);
    $query = "SELECT inventory_name FROM add_ivantory_name WHERE store_id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $store_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $inventories = [];
    while ($row = $result->fetch_assoc()) {
        $inventories[] = $row;
    }
    
    // Return inventory names as JSON
    echo json_encode($inventories);
    
    $stmt->close();
} else {
    echo json_encode([]);
}

$conn->close();
?>
