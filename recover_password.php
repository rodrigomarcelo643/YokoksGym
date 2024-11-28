<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
   
    $username = $_POST['username'];

  
    $sql = "SELECT id, first_name, last_name, contact_number FROM members_mobile WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

 
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

 
    if ($result->num_rows > 0) {
        $accounts = [];
        while ($user = $result->fetch_assoc()) {
            $accounts[] = $user;
        }
        echo json_encode([
            "status" => "success",
            "accounts" => $accounts
        ]);
    } else {
        echo json_encode([
            "status" => "not_found",
            "message" => "No account associated with this username."
        ]);
    }

}
?>
