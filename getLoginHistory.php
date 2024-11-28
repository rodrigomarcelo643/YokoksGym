<?php
include 'connection.php'; 
$response = array();

if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
    $user_id = $_GET['user_id'];


    $sql = "SELECT device_info, login_time FROM login_history WHERE user_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $response[] = $row;
        }

      
        header('Content-Type: application/json');
        echo json_encode($response);
        
        $stmt->close(); 
    } else {
        echo json_encode(array("error" => "Failed to prepare statement"));
    }
} else {
    echo json_encode(array("error" => "Invalid request: user_id is missing or empty"));
}


$conn->close();
?>
