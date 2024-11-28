<?php
session_start();

include '../p/connection.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string(trim($_POST['username']));
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM Admin WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['staffUsername'] = $row['username'];
            $_SESSION['firstName'] = $row['firstName'];
            $_SESSION['lastName'] = $row['lastName'];
            $_SESSION['staffEmail'] = $row['email'];
            $_SESSION['profileImage'] = isset($row['profileImage']) ? $row['profileImage'] : '';
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with that username.";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cebu City Branch | Yokok's Staff Sign In</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" href="../Assets/Yokoks_logo.png">
    <link rel="stylesheet" href="../CSS/loginForm.css">
</head>

<body class="flex login-main h-screen justify-center">

    <!-- Left Side: Login Form -->
    <div class="w-full flex items-center justify-center bg-transparent p-8">
        <div class="block">

            <div class="w-full max-w-full bg-white p-8 rounded-lg shadow-lg" style="width:500px; max-width:500px;">
                <div class="flex ml-4 justify-center mb-4">
                    <img src="../Assets/logo.png" style="width:120px; height:100px;">
                </div>
                <div class="text-center mb-6">
                    <div class="text-black p-4 rounded-lg flex items-center justify-left mb-4"
                        style="margin-left:-16px;">
                        <span class="text-lg font-bold" style="font-size:25px">Welcome Admin 👋</span>
                    </div>
                </div>

                <form method="POST" action="">
                    <div class="mb-4 relative">
                        <input type="text" id="username" name="username" required
                            class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder=" ">
                        <label for="username"
                            class="absolute left-3 top-1/2 transform -translate-y-1/2 transition-all duration-300 text-gray-500">Username</label>
                        <?php if (isset($error) && strpos($error, 'username') !== false): ?>
                        <div class="text-red-500 mb-1 error-message"><?php echo $error; ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-4 relative">
                        <input type="password" id="password" name="password" required
                            class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder=" ">
                        <label for="password"
                            class="absolute left-3 top-1/2 transform -translate-y-1/2 transition-all duration-300 text-gray-500">Password</label>
                        <?php if (isset($error) && strpos($error, 'password') !== false): ?>
                        <div class="text-red-500 mb-1 error-message"><?php echo $error; ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="flex">
                        <div class="flex">
                            <input type="checkbox" for="remember" class="mr-1" />
                            <p class="font-bold text-green-500 font-sm" style="font-size:13px;margin-top:4px;">Remember
                                Me</p>
                        </div>
                        <div class="forgot_password">
                            <a class="font-bold text-green-500 font-sm hover:underline"
                                style="margin-left:217px;font-size:13px;margin-top:4px;"
                                href="forgot_passwordAdmin">Forgot Password</a>
                        </div>
                    </div>
                    <button type="submit" id="submitButton" style="background-color:#009B7B"
                        class="w-full text-white mt-5 py-2 rounded-lg flex items-center justify-center hover:bg-green-600">
                        <span id="buttonText">Sign In</span>
                        <div id="spinnerContainer" class="hidden ml-2">
                            <img src="../Assets/loading.gif" style="width:15px;height:15px;border-radius:50%;">
                        </div>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div id="spinnerOverlay" style="display: none;">
        <div class="block">
            <div class="text-center bg-white shadow-md flex align-center"
                style="width:350px; height:56px; align-content:center; border-radius:10px;">
                <div class="mt-2 ml-2 flex">
                    <img src="../Assets/success_message.png" class="ml-3 mt-.5" alt="Success Message"
                        style="width:30px; height:30px; margin-right:20px;">
                    <h1 class="text-black font-bold mt-1 ">You are Authorized Redirecting....</h1>
                </div>
            </div>
            <img class="text-center" style="position:relative; left:100px;" src="../Assets/loading_L.gif" alt="Loading">
        </div>
    </div>

    <script src="../JS/login.js"></script>
</body>
<style>
input {
    padding: 1.5rem 0.9rem;
}

.forgot {
    font-size: 12px !important;
    color: #009B7B;
    margin-left: 56px;

}

input:focus+label,
input:not(:placeholder-shown)+label {
    transform: translateY(-40px);
    color: #009B7B;
    background-color: white;
    font-size: 12px;
    padding: 5px;
}

label {
    pointer-events: none;
}

.remember {
    font-size: 12px !important;
    margin-top: 80px;
}

.relative {
    position: relative;
}

.error-message {
    font-size: 9px;
}
</style>
</style>

</html>