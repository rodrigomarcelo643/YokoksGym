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

<body class="flex h-screen justify-center">


   <!-- Left Side: Login Form -->
    <div class="w-1/2 flex items-center justify-center p-8">
        <div class="block max-w-md w-full p-10 rounded-lg">
            <div class="flex justify-center mb-8">
                <img src="../Assets/logo.png" alt="Yokok's Logo" style="width:150px;height:120px;"> <!-- Bigger Logo -->
            </div>

            <form id="loginForm" method="post">
                <div class="mb-6 relative">
                    <input type="text" id="username" name="staffUsername" required
                        class="w-full border border-gray-300 p-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent peer"
                        placeholder=" ">
                    <label for="username"
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 transition-all duration-300 text-gray-500 peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:top-2 peer-focus:text-xs peer-focus:text-green-600 bg-white px-2">Username</label>
                    <div id="usernameError" class="text-red-500 text-sm mt-1 error-message"></div>
                </div>

                <div class="mb-6 relative">
                    <input type="password" id="password" name="staffPassword" required
                        class="w-full border border-gray-300 p-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent peer"
                        placeholder=" ">
                    <label for="password"
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 transition-all duration-300 text-gray-500 peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:top-2 peer-focus:text-xs peer-focus:text-green-600 bg-white px-2">Password</label>
                    <div id="passwordError" class="text-red-500 text-sm mt-1 error-message"></div>
                </div>

                <div class="flex items-center mb-6">
                    <input type="checkbox" id="rememberMe" class="mr-2">
                    <p class="remember text-gray-600 text-sm">Remember Me</p>
                    <a href="sF.php" class="forgot text-green-600 hover:underline ml-auto text-sm" style="margin-left:120px;">Forgot your password?</a>
                </div>

                <button type="submit" id="submitButton" style="background-color:#009B7B"
                        class="w-full  text-white mt-5 py-2 rounded-lg flex items-center justify-center hover:bg-green-600">
                        <span id="buttonText">Sign In</span>
                        <div id="spinnerContainer" class="hidden ml-2">
                            <img src="../Assets/alternate_loading.gif" style="width:15px;height:15px;border-radius:50%;">
                        </div>
                    </button>
            </form>
        </div>
    </div>

    <!-- Right Side: Background Image with Text -->
    <div class="w-1/2 bg-cover bg-center relative" style="background-image: url('../Assets/login_staff.jpg');">
        <div class="absolute inset-0 bg-black opacity-40"></div> <!-- Add overlay for contrast -->
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white px-6">
            <h1 class="text-5xl font-extrabold leading-tight mb-4">Yokok's Gym</h1>
            <p class="text-xl font-semibold tracking-wide mb-6">Personalized Fitness Experience</p>
            <hr class="w-16 border-t-2 border-white mb-1" style="margin-bottom:-20px;">
            <p class="text-sm font-light tracking-wide leading-relaxed" style="padding:50px;">Where Fitness Meets Passion. Get ready to unlock your potential and transform your fitness journey with us!</p>
        </div>
    </div>

<div id="spinnerOverlay" style="display: none;">
    <div class="block">
        <div class="text-center bg-white shadow-md flex align-center"
            style="width:350px;height:56px;align-content:center;border-radius:10px;">
            <div class="mt-2 ml-2 flex">
                <img src="../Assets/success_message.png" class="ml-3 mt-.5" alt="Success Message"
                    style="width:30px;height:30px;margin-right:20px;">
                <h1 class="text-black font-bold mt-1">You are Authorized Redirecting....</h1>
            </div>
        </div>
        <div style="background-color:transparent;padding:5px;border-radius:50%;text-align:center;display:flex;justify-content:center;align-items:center;">
            <img src="../Assets/alternate_loading.gif" class="loading" alt="Loading Spinner" style="width:50px;height:50px;">
        </div>
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
}

.relative {
    position: relative;
}

.error-message {
    font-size: 9px;
}
</style>

</html>