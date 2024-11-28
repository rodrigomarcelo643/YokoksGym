<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cebu City Branch | Forgot Password</title>
    <link href="../src/output.css" rel="stylesheet">
    <link href="../Assets/Yokoks_logo.png" rel="icon">
    <link href="../CSS/reset_password.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
    /* Green theme for the login form */
    #login-form-container {
        background: #f0fdf4;
        /* Light green background */
        padding: 20px;

        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    #login-form-container h1 {
        font-size: 1.1rem;
        font-weight: 600;
        color: green;
        margin-top: 10px;
        margin-bottom: px;
        /* Dark green text */
    }

    /* Centering profile image in login form */
    #login-profile-image {
        display: flex;
        justify-content: center;
        margin-bottom: 15px;
    }

    #login-profile-image img {
        width: 100px !important;
        height: 100px !important;
        border-radius: 50%;
    }

    .back_arrow {
        width: 35px;
        height: 35px;
        cursor: pointer;
    }

    .back_arrow:hover {
        transform: scale(1.1);
        transition: transform 0.5s;
    }

    .back_container {
        padding: 20px;
    }

    .profile-container {
        display: flex;
        align-items: center;
    }

    .profile-image {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin-right: 20px;
    }

    .profile-info {
        display: flex;
        flex-direction: column;
    }

    .profile-email {
        font-size: 16px;
        font-weight: bold;
        color: #333;
    }

    .hidden {
        display: none;
    }

    .message img {
        margin-right: 10px;
        width: 30px;
        height: 30px;
    }

    #proceed-login {
        width: 150px;
        height: 40px;
        background-color: green;
        color: white;
        letter-spacing: 0.5px;
        border-radius: 10px;
        margin-top: 25px;
    }

    #proceed-login:hover {
        background-color: rgb(28, 109, 28);
        font-weight: bold;
    }

    #login-error-message {
        margin-top: 10px;
        margin-bottom: -20px;
    }

    .btn-primary {
        background-color: #009B7B !important;
    }
    </style>
</head>

<body>

    <div id="spinnerOverlay" style="display: none;">
        <div class="block">
            <div class="text-center bg-white shadow-md flex align-center" class="redirect-message"
                style="width:350px;height:56px;align-content:center;border-radius:10px;">
                <div class="mt-2 ml-2 flex">
                    <img src="../Assets/success_message.png" class="ml-3 mt-.5" alt="Success Message"
                        style="width:30px;height:30px;margin-right:20px;">
                    <h1 class="text-black font-bold mt-1 ">You are Authorized Redirecting....</h1>
                </div>
            </div>
              <div style="background-color:white;padding:5px;border-radius:50% !important;display:flex;justify-content:center;align-items:center;">
                        <img src="../Assets/alternate_loading.gif" class="loading" alt="Loading Spinner" style="width:50px !important;height:50px!important;" >
            </div>
        </div>
    </div>

    <div class="back_container">
        <img src="../Assets/back_arrow.png" onclick="backArrow()" class="back_arrow">
    </div>
    <section class="container">
        <!--===================== Forgot Password Form -->
        <div id="forgot-password-card" class="card">
            <div class="text-center">
                <h1 class="text-lg font-bold text-gray-800">Forgot Password</h1>
                <p class="text-gray-800 mb-8">Enter your email address to receive a password reset link.</p>
            </div>
            <form id="forgot-password-form">
                <div class="grid gap-y-4">
                    <div id="email-section" style="margin-bottom:25px!important;">
                        <label for="email" class="block mb-2 text-xs font-semibold">Email Address</label>
                        <div id="error-message" class="message message-error mt-5 hidden" ></div>
                        <input type="email" id="email" name="email"
                            class="block w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required placeholder="Enter your email address" style="margin-top:5px !important;">
                    </div>
                    <button type="submit" id="find-email-button" class="btn-primary">Find Email</button>
                </div>
            </form>

            <!-- Results Section -->
            <div id="results" class="hidden">
                <img id="back-button" src="../Assets/back_arrow.png"
                    style="width:25px;height:25px;cursor:pointer;margin-bottom:15px;">
                <div id="result-message" class="message mb-4">
                    <!-- Profile container will be dynamically inserted here -->
                </div>
                <div id="options" class="block gap-x-4">
                    <div id="spinnerOverlaySelectOption" style="display: none;">
                        <div class="block justify-center align-center align-content-center">
                            <h1 class="text-black font-bold mt-1 text-select-option">Pls Select An Option</h1>
                        </div>
                    </div>
                    <div class="mb-3" style="margin-bottom:10px;">
                        <label class="radio-label">
                            <input type="radio" name="action" value="enterPassword">
                            <span class="radio-text">Enter Password</span>
                        </label>
                    </div>
                    <div class="mb-3">
                        <label class="radio-label">
                            <input type="radio" name="action" value="resetPassword">
                            <span class="radio-text">Reset Password</span>
                        </label>
                    </div>
                </div>
                <button id="proceed-button" class="btn-primary">Proceed</button>
            </div>
        </div>

        <!-- Login Form -->
        <div id="login-form-container" class="hidden">
            <img id="back-button2" src="../Assets/back_arrow.png" onclick="backButton()"
                style="width:25px;height:25px;cursor:pointer;margin-bottom:15px;">
            <form id="login-form">
                <div class="grid gap-y-4">
                    <div id="login-email-section">
                        <div id="login-profile-image" class="profile-container"></div>
                        <input type="email" id="login-email" name="login-email"
                            class="block w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-md shadow-sm"
                            required placeholder="Your email address" readonly>
                    </div>
                    <h1 for="password" class="block mb-2 text-xs font-semibold label-password">Password</h1>
                    <div id="login-password-section">

                        <input type="password" id="password" name="password"
                            class="block w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-md shadow-sm"
                            required placeholder="Enter your password">
                    </div>
                    <button type="submit" id="proceed-login" class="btn-primary">Proceed</button>
                </div>
            </form>
        </div>
    </section>
    <img id="sending-gif" src="../Assets/send.gif" alt="Sending..." style="display: none; width: 90px; height: 90px;">

    <script>
    function backArrow() {
        window.location.href = "L.php";
    }

    function backButton() {
        const displayF = document.getElementById('forgot-password-card');
        displayF.classList.remove('hidden');
        const hidedisplayF = document.getElementById('login-form-container');
        hidedisplayF.classList.add('hidden');
    }
    document.getElementById('forgot-password-form').addEventListener('submit', async function(event) {
        event.preventDefault();

        const email = document.getElementById('email').value;
        const errorMessageDiv = document.getElementById('error-message');
        const findEmailButton = document.getElementById('find-email-button');
        const response = await fetch('find_email.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                email
            })
        });

        const data = await response.json();

        const resultsDiv = document.getElementById('results');
        const emailSection = document.getElementById('email-section');
        const resultMessage = document.getElementById('result-message');
        if (data.found) {
            emailSection.classList.add('hidden');
            findEmailButton.classList.add('hidden');
            errorMessageDiv.classList.add('hidden');

            // Use default profile image if 'default' is returned
            const profileImage = data.profileImage === 'default' ? '../Assets/profile.png' :
                `data:image/jpeg;base64,${data.profileImage}`;
            const profileImageHtml =
                `<img src="${profileImage}" alt="Profile Image" class="profile-image" style="width:60px;height:60px;">`;
            const emailHtml = `<div class="profile-info">
                           <div class="profile-email"> ${data.email}</div>
                        </div>`;

            resultMessage.innerHTML =
                `<div class="profile-container">${profileImageHtml}${emailHtml}</div>`;
            resultMessage.className = 'message message-success';

            resultsDiv.classList.remove('hidden');
        } else {
            errorMessageDiv.textContent = 'Email not found.';
            errorMessageDiv.classList.remove('hidden');
        }
    });


    document.getElementById('proceed-button').addEventListener('click', async function() {
        const selectedAction = document.querySelector('input[name="action"]:checked');
        if (!selectedAction) {
            document.getElementById('spinnerOverlaySelectOption').style.display = "block";

            setTimeout(function() {
                document.getElementById('spinnerOverlaySelectOption').style.display = "none";
            }, 4000);
            return;
        }

        const email = document.getElementById('email').value;
        const action = selectedAction.value;
        const resultMessage = document.getElementById('result-message');
        const sendingGif = document.getElementById('sending-gif');
        const loginFormContainer = document.getElementById('login-form-container');

        if (action === 'enterPassword') {
            const response = await fetch('fetch_user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    email
                })
            });
            const data = await response.json();

            if (data.found) {
                document.getElementById('forgot-password-card').classList.add('hidden');
                loginFormContainer.classList.remove('hidden');

                document.getElementById('login-email').value = data.email;

                // Use default profile image if 'default' is returned
                const profileImage = data.profileImage === 'default' ? '../Assets/profile.png' :
                    `data:image/jpeg;base64,${data.profileImage}`;
                const profileImageHtml =
                    `<img src="${profileImage}" alt="Profile Image" class="profile-image" style="width:60px;height:60px;">`;
                document.getElementById('login-profile-image').innerHTML = profileImageHtml;
            } else {
                alert('Email not found.');
            }
        } else if (action === 'resetPassword') {
            resultMessage.innerHTML =
                '<img src="../Assets/send.gif" alt="Sending..." style="width:150px; height:150px;">';
            resultMessage.className = 'message message-info';
            sendingGif.style.display = 'block';

            const response = await fetch('send_reset_link.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    email
                })
            });
            const data = await response.json();

            sendingGif.style.display = 'none';
            if (data.message.includes('sent')) {
                resultMessage.innerHTML =
                    '<div style="display: flex; align-items: center;">' +
                    '<img src="../Assets/success_message.png" alt="Success" style="width:30px; height:30px; margin-right:10px;">' +
                    `<span>${data.message}</span>` +
                    '</div>';
                resultMessage.className = 'message message-success';
            } else {
                resultMessage.innerHTML =
                    '<div style="display: flex; align-items: center;">' +
                    `<span>${data.message}</span>` +
                    '</div>';
                resultMessage.className = 'message message-error';
            }
        }
    });

    document.getElementById('back-button').addEventListener('click', function() {
        document.getElementById('results').classList.add('hidden');
        document.getElementById('email-section').classList.remove('hidden');
        document.getElementById('find-email-button').classList.remove('hidden');
        document.getElementById('error-message').classList.add('hidden');
    });

    document.getElementById('login-form').addEventListener('submit', async function(event) {
        event.preventDefault();

        const spinnerOverlay = document.getElementById("spinnerOverlay");
        const loginErrorMessageDiv = document.getElementById('login-error-message');
        const email = document.getElementById('login-email').value;
        const password = document.getElementById('password').value;

        const response = await fetch('login_f.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                email,
                password
            })
        });

        const data = await response.json();

        if (data.success) {
            // Delay before showing spinner overlay
            setTimeout(function() {
                spinnerOverlay.style.display = "flex";
                setTimeout(function() {
                    window.location.href = "../p/d.php";
                }, 1000);
            }, 10); // Adjust delay as needed
        } else {
            loginErrorMessageDiv.textContent = data.message;
            loginErrorMessageDiv.classList.remove('hidden');
        }
    });
    </script>
</body>

</html>