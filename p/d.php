<?php
session_start();

if (!isset($_SESSION['staffUsername'])) {
    header("Location: L.php");
    exit();
}

$staffUsername = htmlspecialchars($_SESSION['staffUsername']);
$firstName = htmlspecialchars($_SESSION['firstName']);
$lastName = htmlspecialchars($_SESSION['lastName']);
$staffEmail = htmlspecialchars($_SESSION['staffEmail']);
$profileImage = isset($_SESSION['profileImage']) ? $_SESSION['profileImage'] : ''; 

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../src/output.css" rel="stylesheet">
    <link href="../CSS/dashboard.css" rel="stylesheet">
    <link href="../CSS/members.css" rel="stylesheet">
    <link href="../CSS/sendSales.css" rel="stylesheet">
    <link href="../CSS/Products.css" rel="stylesheet">
    <link href="../CSS/notif.css" rel="stylesheet">
    <link href="../CSS/add_member.css" rel="stylesheet">
    <link href="../CSS/pagination.css" rel="stylesheet">
    <link href="../CSS/expenses.css" rel="stylesheet">
    <link href="../CSS/profile.css" rel="stylesheet">
    <link rel="icon" href="../Assets/Yokoks_logo.png">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/dist/index.global.min.css' rel='stylesheet' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.0.2/index.min.css" />
    <title>Cebu City Branch | Staff Dashboard</title>
    <link href="../CSS/showSettings.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<!--=========================================Show Settings==================-->
<div id="ShowSettings" style="display: none;">
    <div class="modal-content-settings w-96 mx-auto p-6 bg-white rounded-lg shadow-lg relative">
        <span class="close-btn" onclick="HideSettings()">&#10006;</span>
        <div class="flex">
            <img src="../Assets/settings.png" style="width:35px;height:35px;margin-right:10px;">
            <h2 class="text-2xl mb-4 text-green-500 font-bold">Settings</h2>
        </div>
        <div id="settings-section-container">
            <!-- Default View -->
            <div id="default-view">
                <div class="setting-top flex justify-center items-center mb-4">
                    <img src="../Assets/settings_top.png" alt="Settings Top">
                </div>
                <div class="settings-section mb-4" style="margin-top:-40px;">
                    <div class="flex mb-5" style="margin-bottom:12px;">
                        <img src="../Assets/profile.png" style="width:35px;height:35px;margin-right:10px;">
                        <h3 class="text-xl text-green-500 font-bold mb-2" style="letter-spacing:.5px;margin-top:5px;">
                            Profile Details</h3>
                    </div>
                    <ul class="list-none p-0" style="margin-left:15px;">
                        <li class="mb-2 flex">
                            <div class="design"
                                style="width:21px;height:7px;background-color:green;border-radius:8px; margin-top:8px; margin-right:6px;">
                            </div>
                            <a href="#" onclick="showProfileDetails(); return false;"
                                class="text-greeb-600 hover:underline  font-bold edit-profile">Edit
                                Profile</a>
                        </li>
                        <li class="flex">
                            <div class="design"
                                style="width:21px;height:7px;background-color:green;border-radius:8px; margin-top:8px; margin-right:6px;">
                            </div>
                            <a href="#" onclick="showAccountInfo(); return false;"
                                class="text-green-600 hover:underline account-info ">Account Info</a>
                        </li>
                    </ul>
                </div>
                <div class="settings-section">
                    <div class="flex mb-5" style="margin-bottom:12px;">
                        <img src="../Assets/password.png" style="width:35px;height:35px;margin-right:10px;">
                        <h3 class="text-xl text-green-500 font-bold mb-2" style="letter-spacing:.5px;margin-top:5px;">
                            Profile Password</h3>
                    </div>
                    <ul class="list-none p-0 flex" style="margin-left:15px;">
                        <div class="design"
                            style="width:21px;height:7px;background-color:green;border-radius:8px; margin-top:8px; margin-right:6px;">
                        </div>
                        <li><a href="#" onclick="showChangePassword(); return false;"
                                class="text-green-600 hover:underline change-password">Change Password</a></li>
                    </ul>
                </div>
            </div>

            <!-- Profile Details View -->
            <div id="profile-details-view" class="view-content">
                <img src="../Assets/back_arrow.png" class="back-button" onclick="showDefaultView()">
                <div class="flex align-center flex justify-center align-center">
                    <img src="../Assets/edit-profile.png" style="width:35px;height:35px;margin-right:10px;">
                    <h3 class="view-title text-align:center " style="letter-spacing:.5px;">Edit Profile
                    </h3>
                </div>
                <form id="profile-edit-form" enctype="multipart/form-data" class="form-container">
                    <div class="view-info">
                        <div class="wrap-image-container">
                            <div class="image-preview-container">
                                <!-- Display the profile image or default if not set -->
                                <img src="<?php echo !empty($profileImage) ? 'data:image/jpeg;base64,' . htmlspecialchars($profileImage) : '../Assets/profile.png'; ?>"
                                    alt="Profile Image" id="profile-img" class="profile-img">
                                <label for="profileImage" class="custom-file-upload">
                                    <input type="file" name="profileImage" id="profileImage" accept="image/*"
                                        onchange="previewImage(event)">
                                    <span class="upload-icon" style="margin-top:-7px;">+</span>
                                </label>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="block">
                                <label for="firstName" style="font-weight:bold;margin-bottom:15px;">First Name</label>
                                <input type="text" name="firstName" id="firstName"
                                    value="<?php echo htmlspecialchars($firstName); ?>" class="form-input f-edit">
                            </div>
                            <span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>
                            <div class="block">
                                <label for="lastName" style="font-weight:bold;margin-bottom:8px;">Last Name</label>
                                <input type="text" name="lastName" id="lastName"
                                    value="<?php echo htmlspecialchars($lastName); ?>" class="form-input f-edit">
                            </div>
                        </div>
                        <label for="staffEmail" style="font-weight:bold;margin-bottom:15px;">Email</label>
                        <input type="email" name="staffEmail" id="staffEmail"
                            value="<?php echo htmlspecialchars($staffEmail); ?>" class="form-input" readonly>
                        <input type="hidden" name="staffUsername"
                            value="<?php echo htmlspecialchars($staffUsername); ?>">
                    </div>
                    <div id="form-messages" class="form-messages"></div>
                    <button type="submit" class="submit-button">Save Changes</button>
                </form>
            </div>

            <!--============Account informtaion view ===============-->
            <div id="account-info-view" class="view-content" style="display: none;">
                <img src="../Assets/back_arrow.png" class="back-button" onclick="showDefaultView()">
                <div class="flex">
                    <img src="../Assets/account-info.png" style="width:35px;height:35px;margin-right:10px;">
                    <h3 class="view-title">Account Information</h3>
                </div>
                <div class="view-info1">
                    <div class="profile">
                        <img src="<?php echo !empty($profileImage) ? 'data:image/jpeg;base64,' . htmlspecialchars($profileImage) : '../Assets/profile.png'; ?>"
                            alt="Profile Image" id="profile-img" class="profile-img">
                    </div>
                    <div class="info-details">
                        <div class="info-row">
                            <label>Username</label>
                            <p><?php echo $staffUsername; ?></p>
                        </div>
                        <div class="info-row">
                            <label>First Name</label>
                            <p><?php echo $firstName; ?></p>
                        </div>
                        <div class="info-row">
                            <label>Last Name</label>
                            <p><?php echo $lastName; ?></p>
                        </div>
                        <div class="info-row email-row">
                            <img src="../Assets/email.png" style="width:35px;height:35px;margin-right:10px;">
                            <p><?php echo $staffEmail; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Change Password View -->
            <div id="change-password-view" class="view-content" style="display: none;">
                <img src="../Assets/back_arrow.png" class="back-button" onclick="showDefaultView()">
                <div class="flex text-center justify-center">
                    <h3 class="view-title">Change Password</h3>
                    <img src="../Assets/change_password.png" style="width:35px;height:35px;margin-left:10px;">
                </div>
                <div class="username-block" style="border-bottom:2px solid green;margin-bottom:10px;">
                </div>
                <form id="change-password-form" method="po  t" class="password-form">
                    <label for="current-password" style="margin-bottom:-7px;font-weight:bold;font-size:15px;">Current
                        Password</label>
                    <input type="password" id="current-password" name="current-password" class="input-field" required>
                    <label for="new-password" style="font-weight:bold;margin-bottom:-7px;font-size:15px;">New
                        Password</label>
                    <input type="password" id="new-password" name="new-password" class="input-field" required>
                    <div id="change-password-message" class="message"></div>
                    <button type="submit" class="update-button">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!--=========================================Show Settings=================================================-->

<!-- =====Updating Membership Renewal Modal Sucecss-->
<div id="successModalRenew" class="modal">
    <div class="modal-content modal-success">
        <span class="close">&times;</span>
        <div class="modal-header" style="display:flex;">
            <img src="../Assets/success_message.png" alt="Success Icon" class="success-icon">
            <h2 class="success-message">Membership Renewed!</h2>
        </div>
        <div class="loading-bar">
            <div id="progress" class="progress"></div>
        </div>
    </div>
</div>
<!-- =====DELETE MEMBERS  Modal Sucecss-->
<div id="successModalAddedExpenses" class="modal" style="z-index:999;">
    <div class="modal-content modal-success">
        <span class="close">&times;</span>
        <div class="modal-header" style="display:flex;">
            <img src="../Assets/success_message.png" alt="Success Icon" class="success-icon">
            <h2 class="success-message">Expense Added</h2>
        </div>
        <div class="loading-bar">
            <div id="progress" class="progress"></div>
        </div>
    </div>
</div>
<!-- =====DELETE MEMBERS  Modal Sucecss-->
<div id="successModalDeleteMember" class="modal" style="z-index:999;">
    <div class="modal-content modal-success">
        <span class="close">&times;</span>
        <div class="modal-header" style="display:flex;">
            <img src="../Assets/success_message.png" alt="Success Icon" class="success-icon">
            <h2 class="success-message">Member Deleted !</h2>
        </div>
        <div class="loading-bar">
            <div id="progress" class="progress"></div>
        </div>
    </div>
</div>
<!-- =====DELETE MEMBERS  Modal Sucecss-->
<!-- Success Modal -->
<div id="successModal" class="modal">
    <div class="modal-content modal-success">
        <span class="close">&times;</span>
        <div class="modal-header" style="display:flex;">
            <img src="../Assets/success_message.png" alt="Success Icon" class="success-icon">
            <h2 class="success-message">Product Added!</h2>
        </div>
        <div class="loading-bar">
            <div id="progress" class="progress"></div>
        </div>
    </div>
</div>
<!-- Success Modal Add Member -->
<div id="successModal1" class="modal">
    <div class="modal-content modal-success">
        <span class="close">&times;</span>
        <div class="modal-header" style="display:flex;">
            <img src="../Assets/success_message.png" alt="Success Icon" class="success-icon">
            <h2 class="success-message">Member Added</h2>
        </div>
        <div class="loading-bar">
            <div id="progress" class="progress"></div>
        </div>
    </div>
</div>


<!-- Notification Modal -->
<div id="notification-modal" class=" fixed flex items-center justify-center bg-gray-900 bg-opacity-50 hidden"
    style="overflow:scroll">
    <div class="modal-content bg-white p-6 rounded-lg shadow-lg">
        <div class="close flex justify-end" id="close-notification">
            <img src="../Assets/close.png" class="text-align-right">
        </div>
        <div class=" flex">
            <h1 class="text-lg font-bold" style="margin-right:250px;font-size:20px;width:50%;margin-top:20px;">
                Notifications</h1>

        </div>
        <!--============Today Content Goes here==============-->
        <div class="Today-container flex" id="Today-container">
            <p class="mb-4 flex" style="margin-top:30px;"> Today <span style="margin-top:10px;margin-left:10px;">
                    <img src="../Assets/chevron_green.png"></span>
            </p>
        </div>
        <div class="mb-4 flex"
            style="display: flex; align-items: center; width: 100%; overflow: hidden; height: auto; box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.1);">
            <img src="../Assets/success_message.png" style="padding: 5px; width: 60px; height: 60px; flex-shrink: 0;">
            <h1 style="padding: 15px; margin: 0; flex: 1;">
                Daily Sales Successfully Sent to Mrs. Merlin! Transaction Details are available in your account.
            </h1>
        </div>

        <div class="mb-4 flex"
            style="display: flex; align-items: center; width: 100%; overflow: hidden; height: auto; box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.1);">
            <img src="../Assets/announce.png" style="padding: 5px; width: 60px; height: 60px; flex-shrink: 0;">
            <h1 style="padding: 15px; margin: 0; flex: 1;">
                Please submit the daily sales report by 5PM. Check your email or reporting system for the necessary
                details.
            </h1>
        </div>
        <!--=================Yesterday Content Goes Here==========================-->

        <div class="Today-container flex" id="Today-container">
            <p class="mb-4 flex" style="margin-top:30px;color:red"> Yesterday<span
                    style="margin-top:10px;margin-left:10px;">
                    <img src="../Assets/chevron_green.png"></span>
            </p>
        </div>
        <div class="mb-4 flex"
            style="display: flex; align-items: center; width: 100%; overflow: hidden; height: auto; box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.1);">
            <img src="../Assets/warning.png" style="padding: 5px; width: 60px; height: 60px; flex-shrink: 0;">
            <h1 style="padding: 15px; margin: 0; flex: 1;">
                Amino Tab Product is almost Out of stock!. Notification From your Gym Management
                System
            </h1>
        </div>
        <div class="mb-4 flex"
            style="display: flex; align-items: center; width: 100%; overflow: hidden; height: auto; box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.1);">
            <img src="../Assets/warning.png" style="padding: 5px; width: 60px; height: 60px; flex-shrink: 0;">
            <h1 style="padding: 15px; margin: 0; flex: 1;">
                Sales Went Down Today to 5%
            </h1>
        </div>

        <div class="mb-4 flex"
            style="display: flex; align-items: center; width: 100%; overflow: hidden; height: auto; box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.1);">
            <img src="../Assets/success_message.png" style="padding: 5px; width: 60px; height: 60px; flex-shrink: 0;">
            <h1 style="padding: 15px; margin: 0; flex: 1;">
                Daily Sales Successfully Sent to Mrs. Merlin! Transaction Details are available in your account.
            </h1>
        </div>
    </div>
</div>
<!-- ============================Modal For Logout================================  -->
<div id="logoutModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden"
    style="z-index: 999">
    <div class="bg-white p-6 rounded-md shadow-lg w-11/12 md:w-1/3" style="z-index: 999">
        <div class="flex justify-center align-center items-center"
            style="border-bottom:2px solid green;margin-bottom:30px;">
            <p class="mb-4" style="font-size:20px;margin-top:15px;margin-right:6px;color:green;">Are you sure you want
                to logout</p>
            <img src="../Assets/logout_bg.png" style="width:30px;height:30px;">
        </div>
        <div class="button-container">
            <button onclick="hideModalLogout()" class="cancel-button">
                Cancel
            </button>
            <button onclick="performLogout()" class="logout-button">
                Logout
            </button>
        </div>
    </div>
</div>


<!--===========Modal For Adding Product===============================-->
<div id="AddProduct" class="fixed product inset-0 flex items-center justify-center bg-black bg-opacity-60 hidden z-50" style="background-color:rgba(0, 0, 0, 0.5)!important;">
    <div class="modal-content modal-addProduct bg-white p-8 rounded-lg shadow-lg w-full max-w-sm transform scale-90 transition-transform duration-300 ease-in-out hover:scale-100" style="width:550px !important;">
        <div class="flex justify-end" style="margin-top:25px;margin-right:10px;margin-left:-20px !important;">
            <button id="close-notification" onclick="CloseProduct()" class="text-gray-600 hover:text-gray-900 transition-colors duration-150 text-lg" style="font-size:35px;overflow:hidden;margin-left:-20px!important">
                &times; <!-- Unicode character for multiplication sign (X) -->
            </button>
        </div>

        <!-- Product Form -->
        <form id="productForm" method="POST" enctype="multipart/form-data" class="space-y-6">
            
            <!--===================TITLE PRODUCT ADDING =====================-->
            <div class="TitleAddingProduct flex mb-6">
                <h1 class="text-gray-600 font-bold text-lg" style="margin-bottom:20px;">ADD NEW PRODUCT</h1>
            </div>
            <!--===================TITLE PRODUCT ADDING =====================-->

            <!--============NAME ID FLEX==========-->
            <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0">
                <div class="flex-1 flex flex-col" style="margin-right:20px;margin-bottom:5px">
                    <label for="ProductName" class="block text-sm font-medium text-gray-700">Product Name <span style="color:red">*</span></label>
                    <input type="text" id="ProductName" name="ProductName" required class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-md focus:border-blue-500 focus:ring focus:ring-blue-200 p-2 pr-10" style="margin-right:20px">
                </div>

                <div class="flex-1 flex flex-col" style="margin-right:20px;margin-bottom:5px">
                    <label for="ProductId" class="block text-sm font-medium text-gray-700">Product Id <span style="color:red">*</span></label>
                    <input type="text" id="ProductId" name="ProductId" required class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-md focus:border-blue-500 focus:ring focus:ring-blue-200 p-2 pr-10">
                </div>
            </div>
            <!--========NAME ID FLEX==============-->

            <!--============UNITS PRODUCT-TYPE FLEX==========-->
            <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0">
                <!-- Dropdown for Units -->
                <div class="flex-1 flex flex-col" style="margin-right:20px;margin-bottom:5px">
                    <label for="Units" class="block text-sm font-medium text-gray-700">Units <span style="color:red">*</span></label>
                    <select id="Units" name="Units" required class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-md focus:border-blue-500 focus:ring focus:ring-blue-200 p-2 pr-10">
                        <option value="">Select Units</option>
                        <option value="By Capsule">By Capsule</option>
                        <option value="By Box">By Box</option>
                    </select>
                </div>

                <!-- Dropdown for Product Type -->
                <div class="flex-1 flex flex-col" style="margin-right:20px;margin-bottom:5px">
                    <label for="ProductType" class="block text-sm font-medium text-gray-700">Product Type <span style="color:red">*</span></label>
                    <select id="ProductType" name="ProductType" required class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-md focus:border-blue-500 focus:ring focus:ring-blue-200 p-2 pr-10">
                        <option value="">Select Product Type</option>
                        <option value="Supplements">Supplements</option>
                        <option value="Snacks">Snacks</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>
            <!--============UNITS PRODUCT-TYPE FLEX==========-->

            <!--============STOCK - PRODUCT  FLEX==========-->
            <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0">
                <div class="flex-1 flex flex-col" style="margin-right:20px;margin-bottom:5px">
                    <label for="ProductStocks" class="block text-sm font-medium text-gray-700">Stocks <span style="color:red">*</span></label>
                    <input type="text" id="ProductStocks" name="ProductStocks" required class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-md focus:border-blue-500 focus:ring focus:ring-blue-200 p-2 pr-10">
                </div>

                <div class="flex-1 flex flex-col" style="margin-right:20px;margin-bottom:5px">
                    <label for="ProductPrice" class="block text-sm font-medium text-gray-700">Price <span style="color:red">*</span></label>
                    <input type="text" id="ProductPrice" name="ProductPrice" required class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-md focus:border-blue-500 focus:ring focus:ring-blue-200 p-2 pr-10">
                </div>
            </div>
            <!--============STOCK - PRODUCT -TYPE FLEX==========-->

            <!--============UPLOAD FILE FLEX==========-->
            <div class="flex flex-col" style="width:96%;">
                <label for="UploadFile" class="block text-sm font-medium text-gray-700">Upload File <span style="color:red">*</span></label>
                <div class="flex items-center border-2 border-gray-300 rounded-md shadow-md p-2 mt-1">
                    <input type="file" id="UploadFile" name="UploadFile" class="hidden" onchange="updateFile()" required>
                    <label class="block text-sm font-medium text-gray-700 cursor-pointer" for="UploadFile">Choose file</label>
                    <img style="margin-left:370px;" src="../Assets/attachment.png" alt="Clip" class="cursor-pointer w-6 h-6 ml-auto" onclick="document.getElementById('UploadFile').click()">
                </div>
            </div>
            <!--============UPLOAD FILE FLEX==========-->

            <div class="flex justify-end">
                <button type="submit" class="full-width-button bg-blue-600 text-white font-semibold py-2 px-4 rounded-md shadow-md hover:bg-blue-700">
                    <h1 class="text-lg" style="color:white;">Add Product</h1>
                </button>
            </div>
        </form>

        <script>
            function updateFile() {
                const fileInput = document.getElementById('UploadFile');
                const fileNameDisplay = document.getElementById('showFile');
                const fileName = fileInput.files[0]?.name || '';
                fileNameDisplay.textContent = fileName ? fileName : 'No file chosen';
            }
        </script>
    </div>
</div>

<style>
.sidebar {
    transition: all 0.5s ease;
}

.content {
    margin-left: 200px;
    transition: all 0.5s ease;
    width: calc(100% - 180px);
}

.sidebar-hidden .sidebar {
    left: -200px;
}

.sidebar-hidden .content {
    margin-left: 0;
    width: 100%;
}

.notif {
    left: 0;
    transition: all 0.5s ease;
}

.sidebar-hidden .notif {
    margin-left: 0;
    width: 100%;
}

.sidebar-toggle-icon {
    transition: all 0.5s ease;
    width: 32px;
    height: 32px;
}

.sidebar-hidden .sidebar-toggle-icon {
    margin-left: -10px;
    z-index: 1001;
}

.branch-title {
    transition: all 0.5s ease;
}

.sidebar-hidden .branch-title {
    margin-left: 0;
}
</style>
<script>
function toggleSidebar1() {
    const body = document.body;
    const toggleIcon = document.querySelector('.sidebar-toggle-icon');

    body.classList.toggle('sidebar-hidden');

    if (toggleIcon.style.marginLeft === "200px") {
        toggleIcon.style.marginLeft = "0";
    } else {
        toggleIcon.style.marginLeft = "200px";

    }
}
</script>

<body class="bg-white flex" style="background-color:#EDF0F2!important">
    <div class="notif notif-icon flex items-center space-x-2 cursor-pointer bg-white"
        style="position:fixed;width:100%;cursor:default;padding:10px 0;align-items:center;border-bottom:1px solid lightgray">
        <h1 style="padding:10px"></h1>
        <img src="../Assets/bar_icon.png"
            class="w-8 h-8  text-white text-4xl top-5 left-4 cursor-pointer toggle sidebar-toggle-icon"
            alt="Toggle Sidebar" style="margin-left:200px;width:33px;height:23px;" onclick="toggleSidebar1()">
        </span>
        <h1 class="text-left branch-title"
            style="flex: 1;font-size:21px;font-weight:bold;color:#124137;text-align:left;margin-left: 30px;">
            Cebu City Branch
        </h1>

        <img src="../Assets/Notifications.png" id="notif-icon" style="margin-right:15px;width:22px">

        <div class="flex flex-col items-center" style="overflow:hidden;">
            <div class="flex items-center">
                <img src="<?php echo !empty($profileImage) ? 'data:image/jpeg;base64,' . htmlspecialchars($profileImage) : '../Assets/profile_default.png'; ?>"
                    alt="Profile" class="w-8 h-8"
                    style="width:45px;height:45px;cursor:default;border-radius:10%;z-index:1;margin-bottom:5px;">
                <span style="cursor:default;color:#151D48;font-size:16px;margin-top:-30px;margin-right:10px;">
                    <?php echo $firstName; ?>
                </span>
                <img src="../Assets/chevron_profile.png" class="chevron w-4 h-4" alt="Dropdown"
                    style="margin-left: 5px;margin-top:-25px;margin-right:20px;">
            </div>
            <span style="font-size: 15px; color: gray; margin-top: -28px;margin-left:6px; cursor: default;">Staff</span>
        </div>
    </div>
    <style>
    .notif {
        padding-left: 15px;
        padding-right: 15px;
    }

    .branch-title {
        margin-left: auto;
        margin-right: auto;
    }

    /* For smaller screens */
    @media only screen and (max-width: 768px) {
        .branch-title {
            font-size: 20px;
            text-align: center;
            margin-left: 0;
            margin-right: 0;
        }

        .notif {
            justify-content: center;
        }

        .notif-icon img {
            margin-right: 5px;
        }

        .flex.items-center img {
            width: 45px;
            height: 45px;
        }

        .flex.items-center span {
            font-size: 16px;
        }

        .chevron {
            width: 3px;
            height: 3px;
        }
    }
    </style>



    <!-- Dropdown menu -->
    <div class="dropdown-menu"
        style="position:fixed; background-color: #fff; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); width: 200px;">
        <!-- Settings -->
        <div class="flex items-center px-4 py-2 text-gray-700">
            <a href="#" id="Setting" class="flex items-center w-full" onclick="ShowSettings()">
                <div class="flex">
                    <img src="../Assets/settings.png" style="width:20px;height:20px; margin-right: 12px;">
                    <span>Settings</span>
                </div>
            </a>
        </div>
        <div class="flex items-center px-4 py-2 text-gray-700">
            <a href="#" id="logout-button" class="flex items-center w-full" data-section="logout"
                onclick="showModalLogout(event)">
                <div class="flex">
                    <img src="../Assets/logout.png" style="width:20px;height:20px; margin-right: 12px;">
                    <span>Logout</span>
                </div>
            </a>
        </div>
    </div>
    <div class="sidebar fixed top-0 shadow-md bottom-0 lg:left-0 p-2 w-64 overflow-y-auto text-center bg-white hidden lg:block sidebar-custom-shadow"
        id="sidebar" style="border-right:1px solid lightgray"
>
        <div class="text-black-100 text-xl logo-move">
            <div class="p-2.5 mt-1 flex items-center logo">
                <img src="../../Assets/logo.png" class="medical_logo" alt="Yokoks Logo">
                </span>
            </div>
        </div>
        <!-- Sidebar Items -->
        <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer sidebar-item"
            data-section="dashboard" onclick="showSection('dashboard')">
            <img src="../Assets/dashboard_main.png" class="sidebar-icon" alt="Dashboard"
                style="width: 20px; height: 20px; object-fit: contain;">
            <span class="text-[15px] font-bold" style="margin-left:10px">Dashboard</span>
        </div>
        <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer sidebar-item"
            data-section="membership" onclick="showSection('membership')">
            <img src="../Assets/membership_main.png" class="sidebar-icon" alt="Dashboard"
                style="width: 20px; height: 20px; object-fit: contain;">
            <span class="text-[15px] font-bold" style="margin-left:10px">Membership</span>
        </div>
        <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer sidebar-item"
            data-section="products" onclick="showSection('products')">
            <img src="../Assets/products_main.png" class="sidebar-icon" alt="Dashboard"
                style="width: 20px; height: 20px; object-fit: contain;">
            <span class="text-[15px] font-bold" style="margin-left:10px">Products</span>
        </div>

        <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer sidebar-item"
            data-section="sendSales" onclick="showSection('sendSales')">
            <img src="../Assets/invent.png" class="sidebar-icon" alt="Dashboard"
                style="width: 20px; height: 20px; object-fit: contain;">
            <span class="text-[15px] font-bold" style="margin-left:10px">Inventory</span>
        </div>
        <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer sidebar-item"
            data-section="Expenses" onclick="showSection('Expenses')">
            <img src="../Assets/expenses_main.png" class="sidebar-icon" alt="Dashboard"
                style="width: 20px; height: 20px; object-fit: contain;">
            <span class="text-[15px] font-bold" style="margin-left:10px">Expenses</span>
        </div>
    </div>

    <div class="content flex-1 ml-64 lg:ml-80 p-4 relative">

        <!--==============================Dashboard Section===================================================-->
        <div id="dashboard" class="section hidden p-6 dashboard-content">
            <div class="Welcome-flex">
            </div>
            <p class="font-bold analytics" style="color:#124137;font-size:25px;margin-left:18px;margin-bottom:-30px;">
                Dashboard and
                Analytics


                <!--=====================Boxes Sales Report ====================================-->
            <div class="flex flex-wrap justify-center space-x-4 mt-8" style="margin-left:-30px;margin-top:0px;">
                <!-- Box 1 -->
                <div class="box-d bg-white flex flex-col items-center justify-center shadow-lg w-full max-w-xs md:w-80 custom-shadow subtle-shadow mb-10 mr-8 "
                    style="margin-right:30px;margin-bottom:30px;border-radius:25px;">
                    <div class="flex flex-col items-center justify-start w-full p-4">
                        <div class="flex items-center justify-between w-full mb-4">
                            <p class="text-lg font-semibold" style="color:#124137;">Product Sales</p>

                        </div>
                        <div class="flex items-center" style="margin-left:-20px;margin-top:0px;">
                            <img src="../Assets/pesos.png" class="w-5 h-5"
                                style="width:30px;margin-right:10px;margin-top:9px;" alt="pesos icon">
                            <h1 id="dailySale" class="ml-2 text-lg font-bold" data-end-value="3252.20"
                                style="margin-top:12px">0.00</h1>
                            <img src="../Assets/product_sales.png" class="ml-2"
                                style="margin-left:60px;margin-top:-3px;width:75px;height:68px;" alt="sales up icon">
                        </div>
                    </div>
                </div>
  <!-- Box 4-->
                  <?php
                // Database connection
                include 'connection.php'; // Make sure this file contains your connection details
                
                // Fetch the sum of total_cost from the database
                $sql = "SELECT SUM(CAST(REPLACE(total_cost, ',', '') AS DECIMAL(10, 2))) AS totalMembershipSale FROM members";
                $result = mysqli_query($conn, $sql);
                
                // Initialize the total cost
                $totalMembershipSale = 0;
                
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $totalMembershipSale = $row['totalMembershipSale'];
                }
                
                // Format the total cost with comma separation
                $formattedTotalMembershipSale = number_format($totalMembershipSale, 2);
                ?>
                
                <!-- Display the total cost in your HTML -->
                <div class="box-d bg-white flex flex-col items-center justify-center shadow-lg w-full max-w-xs md:w-80 custom-shadow subtle-shadow mb-10 mr-8"
                    style="margin-right:30px;margin-bottom:30px;border-radius:25px;">
                    <div class="flex flex-col items-center justify-start w-full p-4">
                        <div class="flex items-center justify-between w-full mb-4">
                            <p class="text-lg font-semibold" style="color:#124137;">Membership Sales</p>
                        </div>
                        <div class="flex items-center" style="margin-left:-20px;margin-top:0px;">
                            <img src="../Assets/pesos.png" class="w-5 h-5" style="width:30px;margin-right:10px;" alt="pesos icon">
                            <h1 class="font-bold" style="font-size:20px;">
                                <?php echo $formattedTotalMembershipSale; ?>
                            </h1>
                            <img src="../Assets/member-card.png" class="ml-2"
                                style="margin-left:60px;margin-top:-3px;width:75px;height:70px;" alt="debt icon">
                        </div>
                    </div>
                </div>


                <!-- Box 5 --> 
                 
                <!-- Box 2 -->
                <div class="box-d bg-white flex flex-col items-center justify-center shadow-lg w-full max-w-xs md:w-80 custom-shadow subtle-shadow mb-10 mr-8 "
                    style="margin-right:30px;margin-bottom:30px;border-radius:25px;">
                    <div class="flex flex-col items-center justify-start w-full p-4">
                        <div class="flex items-center justify-between w-full mb-4">
                            <p class="text-lg font-semibold" style="color:#124137;">Overall Expenses</p>

                        </div>
                        <div class="flex items-center" style="margin-left:-20px;margin-top:0px;">
                            <img src="../Assets/pesos.png" class="w-5 h-5"
                                style="width:30px;margin-right:10px;margin-top:9px;" alt="pesos icon">
                            <h1 id="total-expenses-all" class="ml-2 text-lg font-bold" data-end-value="0.00"
                                style="margin-top:12px">0.00</h1>
                            <img src="../Assets/expenses_statistic.png" class="ml-2"
                                style="margin-left:60px;width:65px;height:65px;margin-top:-3px;" alt="expenses icon">
                        </div>
                    </div>
                </div>
                <!-- Box 3 -->
                <div class="box-d bg-white flex flex-col items-center justify-center shadow-lg w-full max-w-xs md:w-80 custom-shadow subtle-shadow mb-10 mr-8 "
                    style="margin-right:30px;margin-bottom:30px;border-radius:25px;">
                    <div class="flex flex-col items-center justify-start w-full p-4">
                        <div class="flex items-center justify-between w-full mb-4">
                            <p class="text-lg font-semibold" style="color:#124137;">Overall Debt</p>

                        </div>
                        <div class="flex items-center" style="margin-left:-20px;margin-top:0px;">
                            <img src="../Assets/pesos.png" class="w-5 h-5"
                                style="width:30px;margin-right:10px;margin-top:9px;" alt="pesos icon">
                            <h1 id="dailyDebt" class="ml-2 text-lg font-bold" data-end-value="1500.20"
                                style="margin-top:12px">0.00</h1>
                            <img src="../Assets/debt_icon_statistics.png" class="ml-2"
                                style="margin-left:60px;margin-top:-3px;width:65px;height:65px;" alt="debt icon">
                        </div>
                    </div>
                </div>
                <!--Box3-->
                <!-- Box 4 -->
                <div class="box-d bg-white flex flex-col items-center justify-center shadow-lg w-full max-w-xs md:w-80 custom-shadow subtle-shadow mb-10 mr-8 "
                    style="margin-right:30px;margin-bottom:30px;border-radius:25px;">
                    <div class="flex flex-col items-center justify-start w-full p-4">
                        <div class="flex items-center justify-between w-full mb-4">
                            <p class="text-lg font-semibold" style="color:#124137;">Today's Visits</p> <!-- Updated label -->
                        </div>
                        <div class="flex items-center" style="margin-left:-20px;margin-top:0px;">

                            <h1 class="font-bold" style="font-size:20px;"><?php include 'fetch_visits.php'?></h1>
                            <!-- Initial count set to 0 -->
                            <img src="../Assets/visits.png" class="ml-2"
                                style="margin-left:60px;margin-top:-3px;width:75px;height:70px;" alt="debt icon">
                        </div>
                    </div>
                </div>

              
            </div>

            <!--=====================Boxes Sales Report ====================================-->
            <!-- Container Pie  Chart and Statistics For Overall Members Population -->
            <div class="flex flex-wrap justify-center items-center my-10" style="overflow:hidden !important">
                <div class="flex flex-col items-center bg-white shadow-md rounded-lg p-6 mx-4"
                    style="overflow:hidden !important;height:420px;background-color:transparent ">
                    <h1 class="text-xl font-bold text-green-600 mb-4" style="color:#124137;">Overall Members Population
                    </h1>
                    <!-- Doughnut Chart Container -->
                    <div class="chart-container1 w-full max-w-lg" style="width:350px;overflow:hidden;">
                        <?php include 'membership_chart.php' ?>
                        <canvas class="overall" id="membershipPieChart" style="height:300px;"></canvas>
                    </div>
                </div>
                <div id="chartContainer-Expenses" style="height:500px">

                    <canvas id="chartContainer-expenses" style="width:400px;"></canvas>
                </div>
            </div>

            <!--=====================Recent Customers Table ====================================-->
            <div class="recent-customers mt-8 flex" style="border:none!important; border-radius:20px;background-color:transparent!important;">
                <table class="recent-table"
                    style="background-color:white!important;border:none!important; border-radius:20px;box-shadow:none!important;margin-right:20px;">
                    <thead style="background-color:white!important"> 
                        <tr>
                            <th colspan="3" class="" style="font-size:20px;color:#124137;text-align:center;">
                                Recent
                                Customers
                            </th>
                        </tr>
                        <tr>
                            <th class="border px-4 py-2">Membership Type</th>
                            <th class="border px-4 py-2">Customer</th>
                            <th class="border px-4 py-2">Total Cost</th>
                        </tr>
                        <td style="background-color:white!important">
                            <?php 
                            include 'recent_customer.php';
                        ?></td>
                    </thead>
                </table>
                <div
                    style="flex: 1 1 300px; max-width: 50%; height:auto; background-color: white; border-radius: 20px; box-shadow: none; overflow: hidden;">
                    <?php include 'fetch_visits_graph.php'; ?>
                </div>
            </div>
            <style>
            @media only screen and (max-width: 950px) {
                .recent-customers {
                    flex-direction: column;
                    max-width:100%;
                   
                }

              
            }
            </style>

            <!--=====================Recent Customers Table ====================================-->

        </div>

        <!--==============================Dashboard Section Endpoint===================================================-->
        <?php
           include 'connection.php';
           
            $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';


            $sql = "SELECT * FROM AddProducts";
            $result = $conn->query($sql);

            $products = [];
            $typeTotals = [
                'Supplements' => 0,
                'Snacks' => 0,
                'Other' => 0
            ];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $products[] = $row;
                    if (array_key_exists($row['ProductType'], $typeTotals)) {
                        $typeTotals[$row['ProductType']]++;
                    } else {
                        $typeTotals['Other']++;
                    }
                }
            }
            

            // Filter products based on search query
            if (!empty($searchQuery)) {
                $searchQuery = strtolower($searchQuery);
                $filteredProducts = array_filter($products, function($product) use ($searchQuery) {
                    return strpos(strtolower($product['ProductName']), $searchQuery) !== false ||
                        strpos(strtolower($product['ProductId']), $searchQuery) !== false;
                });
            } else {
                $filteredProducts = $products;
            }

            $conn->close();

            function highlight($text, $query) {
                if (!trim($query)) return $text;
                $regex = sprintf('/(%s)/i', preg_quote($query, '/'));
                return preg_replace($regex, '<span class="highlight">$1</span>', $text);
            }
            ?>

        <!-- ============================Products Section================================-->
        <div id="products" class="section hidden">
            <div class="container"
                style="background-color:transparent;border:none !important;box-shadow:none!important">
                <form action="" method="GET" class="search-form" style="height:45px;border-radius:15px;">
                    <img src="../Assets/search_icon.png" class="search-icon" alt="Search Icon">
                    <input type="text" name="search" placeholder="Search" class="search-input"
                        value="<?php echo htmlspecialchars($searchQuery); ?>">
                    <button type="submit" class="search-button">Search</button>
                </form>

                    <div class="add-member-button flex items-center">
                    <button id="openModalButton" class="flex" class="button-add-item" onclick="AddProduct()"
                        style="background-color:#009b7b"
                        class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 ml-2">
                        <img src="../Assets/plus_icon.png" style="margin-right:10px;margin-left:-10px;"> Add Product
                    </button>
                </div>
            </div>

            <!-- Product Table -->
            <div class="p-4 mt-6 bg-white rounded-md" style="border:none!important;margin-top:20px;">
                <div class="table-container" style="margin-left:-15px;border:none!important; box-shadow:none!important">
                    <!-- Table HTML -->
                    <table class="min-w-full bg-white border rounded-md " style="border:none!important">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th  class="p-3 border-b"></th>
                                <th class="p-3 border-b">Product ID</th>
                                <th class="p-3 border-b">Product Name</th>
                                <th class="p-3 border-b">Price</th>
                                <th class="p-3 border-b">Stocks</th>
                                <th class="p-3 border-b">Type</th>
                                <th class="p-3 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            <!-- Rows will be dynamically inserted here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php
            include 'fetch_staff_members.php'; 
            include 'fetch_members.php'; 

            $itemsPerPage = 10; 
            $totalMembers = count($members); 
            $totalPages = ceil($totalMembers / $itemsPerPage); 
            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
            $currentPage = max(1, min($currentPage, $totalPages)); 
            $offset = ($currentPage - 1) * $itemsPerPage;

            $paginatedMembers = array_slice($members, $offset, $itemsPerPage);
            ?>

        <div id="membership" class="section hidden p-4">
            <div class="flex justify-between mb-10 btn-add-member">
                <div class="membership-title" style="font-size: 25px; margin-right: 10px;">Memberships</div>
                <div class="search-container flex items-center ml-auto">
                    <div class="relative">
                        <input type="text" id="searchInput" oninput="filterMembers()" placeholder="Search members..."
                            class="border rounded-md p-2 pl-10 mr-2" />
                        <i class="fas fa-search absolute left-3 top-2.5"></i>
                    </div>
                    <input type="date" id="searchDate" oninput="filterMembers()" class="border rounded-md p-2 ml-2"
                        style="display:none" />
                    <select id="staffDropdown" onchange="filterMembers()"
                        class="border text-gray-600 rounded-md p-2 ml-2" style="color:gray;">
                        <option value="">added by</option>
                        <?php foreach ($staffMembers as $staff): ?>
                        <option
                            value="<?php echo htmlspecialchars($staff['first_name'] . ' ' . $staff['last_name']); ?>">
                            <?php echo htmlspecialchars($staff['first_name'] . ' ' . $staff['last_name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="add-member-button flex items-center">
                    <button id="openModalButton" class="flex" onclick="showAddMembershipModal()"
                        style="background-color:#009b7b"
                        class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 ml-2">
                        <img src="../Assets/plus_icon.png" style="margin-right:10px;margin-left:-10px;"> Add Member
                    </button>
                </div>
            </div>

            <div class="filter-buttons">
                <button id="dailyButton" onclick="filterMembership('daily')" class="filter-btn active">Daily</button>
                <button id="monthlyButton" onclick="filterMembership('monthly')" class="filter-btn">Monthly</button>
            </div>

            <div class="flex-container mt-6">
                <?php if (count($paginatedMembers) > 0): ?>
                <div class="flex-item mb-6" style="border-radius:20px !important;">
                    <table class="min-w-full divide-y divide-gray-200"
                        style="border-radius:20px !important;border: none!important" id="memberTable">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    MEMBER NAME</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    TYPE</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    START DATE</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    AMOUNT</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ADDED BY</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    STATUS</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($paginatedMembers as $member): ?>
                            <tr class="member-row" data-type="<?php echo $member['membership_type'] ?: 'N/A'; ?>"
                                data-start-date="<?php echo $member['membership_start'] ?: 'N/A'; ?>">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php echo htmlspecialchars($member['first_name']) . ' ' . htmlspecialchars($member['last_name']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php echo htmlspecialchars(ucwords(str_replace('-', ' ', $member['membership_type'] ?: 'N/A'))); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <?php if ($member['membership_start']): ?>
                                        <?php echo htmlspecialchars(date('F j, Y', strtotime($member['membership_start']))); ?>
                                        <br>
                                        <small>
                                            <?php echo htmlspecialchars(date('h:i A', strtotime($member['membership_start']))); ?>
                                        </small>
                                        <?php else: ?>
                                        <span>N/A</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap flex items-center align-center">
                                    <span class="ml-5">₱ <?php echo number_format($member['total_cost'], 2); ?></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php echo htmlspecialchars($member['added_by'] ?: 'Unknown'); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php echo $member['remaining_time']; ?>
                                    <?php if (strpos($member['remaining_time'], 'Expired') !== false): ?>
                                    <button class="renew-btn" style="background-color:orange"
                                        onclick="showRenewModal(<?php echo htmlspecialchars(json_encode($member)); ?>)">Renew</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <p id="notFoundMessage" class="mt-10 text-red-600 hidden"
                        style="color:red;margin-top:30px; margin-left:30px;">No members found.</p>

                    <div class="pagination">
                        <a class="flex"
                            style="color:gray;border-radius:8px; <?php echo $currentPage == 1 ? 'opacity:0.5;cursor: not-allowed;' : ''; ?>"
                            href="?page=<?php echo max(1, $currentPage - 1); ?>#membership">
                            <img src="../Assets/back_paginate.png" style="margin-top:3px">Back
                        </a>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a style="border:1.5px solid #CACACA;border-radius:8px;"
                            href="?page=<?php echo $i; ?>#membership"
                            class="<?php echo $currentPage == $i ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                        <?php endfor; ?>

                        <a class="flex"
                            style="color:gray;border-radius:8px; <?php echo $currentPage == $totalPages ? ' cursor: not-allowed;opacity:0.5;' : ''; ?>"
                            href="?page=<?php echo min($totalPages, $currentPage + 1); ?>#membership">
                            Next<img src="../Assets/next_paginate.png" style="margin-top:3px">
                        </a>

                        <span style="color:#5E5757;margin-top:10px;margin-left:40px;">
                            <?php echo ($offset + 1) . '-' . min($offset + $itemsPerPage, $totalMembers) . ' out of ' . $totalMembers . ' Results'; ?>
                        </span>
                    </div>
                </div>
                <?php else: ?>
                <p class='mt-4 text-gray-600 no-members'>No members found.</p>
                <?php endif; ?>
            </div>
        </div>

<!--================================= Renew Membership Modal =======================================-->
<div id="renewMemberModal" class="modal fixed inset-0 flex items-center justify-center bg-black bg-opacity-60 hidden z-50">
    <div class="modal-content-member bg-white p-8 rounded-lg shadow-lg w-full transform scale-90 transition-transform duration-300 ease-in-out hover:scale-100"
        style="width:650px !important;">
        <div class="flex justify-end">
            <button class="text-gray-600 hover:text-gray-900 transition-colors duration-150" onclick="hideRenewModal()">
                <img src="../Assets/close.png" alt="Close" class="w-6 h-6">
            </button>
        </div>
        <div class="flex">
            <div style="width:40px;height:15px;border-radius:20px;background-color:#009b7b;margin-right:15px;margin-top:8px;"></div>
            <h2 class="text-xl font-semibold mb-10 text-left" style="margin-bottom:20px;font-weight:bold;color:gray;letter-spacing:1px;">Renew Membership</h2>
        </div>
     
        <form id="renewMemberForm" class="memberForm">
            <!--============NAME FLEX==========-->
            <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0">
                <div class="flex-1 flex flex-col" style="margin-bottom:5px;margin-right:20px;">
                    <label for="renewFirstName" class="block text-sm font-medium text-gray-700">First Name<span style="color:red"> *</span></label>
                    <input type="text" id="renewFirstName" name="renewFirstName" placeholder=" " readonly
                        class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-md focus:border-blue-500 focus:ring focus:ring-blue-200 p-2 pr-10">
                </div>
                <div class="flex-1 flex flex-col" style="margin-bottom:5px;">
                    <label for="renewLastName" class="block text-sm font-medium text-gray-700">Last Name<span style="color:red"> *</span></label>
                    <input type="text" id="renewLastName" name="renewLastName" placeholder=" " readonly
                        class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-md focus:border-blue-500 focus:ring focus:ring-blue-200 p-2 pr-10">
                </div>
            </div>
            <!--============NAME FLEX==========-->
            <!--============CONTACT NUMBER FLEX==========-->
            <div class="flex flex-col" style="margin-bottom:5px;">
                <label for="renewContactNumber" class="block text-sm font-medium text-gray-700">Contact Number<span style="color:red"> *</span></label>
                <input type="text" id="renewContactNumber" name="renewContactNumber" placeholder=" " readonly
                    class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-md focus:border-blue-500 focus:ring focus:ring-blue-200 p-2 pr-10">
            </div>
            <!--============CONTACT NUMBER FLEX==========-->
            <!--============MEMBERSHIP TYPE TITLE==========-->
            <div class="flex mt-4">
                <h1 class="text-gray-600 font-bold text-lg" style="margin-top:15px;margin-bottom:10px;">Membership Type</h1>
            </div>
              <!--============MEMBERSHIP TYPE TITLE==========-->
                <div class="custom-select flex flex-col mb-4">
                     <select id="renewMembershipType" name="renewMembershipType" style="border:2px solid lightgray !important;width:100%!important;" class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-md focus:border-blue-500 focus:ring focus:ring-blue-200 p-2 pr-10">
                    <option value="daily-basic">Daily Basic</option>
                    <option value="daily-pro">Daily Pro</option>
                    <option value="monthly-basic">Monthly Basic</option>
                    <option value="monthly-pro">Monthly Pro</option>
                </select>
                </div>
                <div class="flex flex-col mb-4">
                    <div style="padding:7px;">
                        <p class="text-gray-600 font-bold" style="color:gray;font-size:14px;margin-bottom:5px;">Total Amount</p>
                        <span id="renewTotalCost">$100</span>
                        <input type="hidden" id="renewTotalCostHidden" name="renewTotalCost" value="100">
                    </div>
                </div>
                <!--============SUBMIT BUTTON==========-->
                <div class="flex justify-end mt-4">
                    <button type="submit" class="full-width-button bg-blue-600 text-white font-semibold py-2 px-4 rounded-md shadow-md hover:bg-blue-700">
                        <h1 class="text-lg" style="color:white;">Renew Membership</h1>
                    </button>
                </div>
                <!--============SUBMIT BUTTON==========-->
        </form>
    </div>
</div>



<!--================================= Add Member Modal =======================================-->
<div id="addMemberModal" class="modal fixed inset-0 flex items-center justify-center bg-black bg-opacity-60 hidden z-50">
    <div class="modal-content-member bg-white p-8 rounded-lg shadow-lg w-full transform scale-90 transition-transform duration-300 ease-in-out hover:scale-100"
        style="width:650px !important;">
        <div class="flex justify-end">
            <button class="text-gray-600 hover:text-gray-900 transition-colors duration-150" onclick="hideAddMembershipModal()">
                <img src="../Assets/close.png" alt="Close" class="w-6 h-6">
            </button>
        </div>
        
        <div class="flex">
            <div style="width:40px;height:15px;border-radius:20px;background-color:#009b7b;margin-right:15px;margin-top:8px;"></div>
            <h2 class="text-xl font-semibold mb-10 text-left" style="margin-bottom:20px;font-weight:bold;color:gray;letter-spacing:1px;">Add Member</h2>
        </div>

      
            <form id="memberForm" class="memberForm">
                <!--===================TITLE ADDING MEMBER =====================-->
                <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0">
                    <div class="flex-1 flex flex-col" style="margin-right:20px;margin-bottom:5px;">
                        <label for="firstName" class="block text-sm font-medium text-gray-700">First Name<span style="color:red"> *</span></label>
                        <input type="text" id="firstName" name="firstName" placeholder=" " required class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-md focus:border-blue-500 focus:ring focus:ring-blue-200 p-2 pr-10">
                    </div>
                    <div class="flex-1 flex flex-col" style="margin-right:20px;margin-bottom:5px;">
                        <label for="lastName" class="block text-sm font-medium text-gray-700">Last Name<span style="color:red"> *</span></label>
                        <input type="text" id="lastName" name="lastName" placeholder=" " required class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-md focus:border-blue-500 focus:ring focus:ring-blue-200 p-2 pr-10">
                    </div>
                </div>
                <!--============NAME FLEX==========-->

                <!--============CONTACT NUMBER FLEX==========-->
                <div class="flex flex-col" style="margin-bottom:5px;">
                    <label for="contactNumber" class="block text-sm font-medium text-gray-700">Contact Number<span style="color:red"> *</span></label>
                    <input type="text" id="contactNumber" name="contactNumber" placeholder=" " required class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-md focus:border-blue-500 focus:ring focus:ring-blue-200 p-2 pr-10"  style="width:97%;">
                </div>
                <!--============CONTACT NUMBER FLEX==========-->
                <!--============MEMBERSHIP TYPE SELECT==========-->
                <div class="flex flex-col mb-4">
                    <label for="membershipType" class="block text-sm font-medium text-gray-700">Membership Type <span style="color:red">*</span></label>
                    <select id="membershipType" name="membershipType" class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-md focus:border-blue-500 focus:ring focus:ring-blue-200 p-2 pr-10" style="width:97%;">
                        <option value="daily-basic">Daily Basic</option>
                        <option value="daily-pro">Daily Pro</option>
                        <option value="monthly-basic">Monthly Basic</option>
                        <option value="monthly-pro">Monthly Pro</option>
                    </select>
                </div>
                <!--============MEMBERSHIP TYPE SELECT==========-->

                <!--============TOTAL COST DISPLAY==========-->
                <div class="flex flex-col mb-4">
                    <div style="padding:7px;">
                        <p class="text-gray-600 font-bold" style="color:gray;font-size:14px;margin-bottom:5px;">Total Amount</p>
                        <span id="totalCost" class="font-bold text-lg">$100</span>
                        <input type="hidden" id="totalCostHidden" name="totalCost" value="100">
                    </div>
                </div>
                <!--============TOTAL COST DISPLAY==========-->

                <!--============SUBMIT BUTTON==========-->
                <div class="flex justify-end mt-4">
                    <button type="submit" class="full-width-button bg-blue-600 text-white font-semibold py-2 px-4 rounded-md shadow-md hover:bg-blue-700">
                        <h1 class="text-lg" style="color:white;">Add Member</h1>
                    </button>
                </div>
                <!--============SUBMIT BUTTON==========-->
            </form>
        
    </div>
</div>
<?php
// Include your connection to the database and session management
include 'connection.php'; 

// Assuming you have the user's first and last name stored in session variables
$loggedInFirstName = isset($_SESSION['firstName']) ? $_SESSION['firstName'] : 'Unknown';
$loggedInLastName = isset($_SESSION['lastName']) ? $_SESSION['lastName'] : 'User';

// Fetch products from the database
$query =  "SELECT ProductName, Price, Stocks FROM AddProducts";
$result = $conn->query($query); 

// Store products in an array for later use
$products = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Close the database connection
$conn->close();
?>

<!--=================== Send Sales Section ==============================================-->
<div id="sendSales" class="section hidden">
    <h1 class="text-2xl font-bold text-left text-gray-800 mb-6" style="margin-bottom:50px;">End Shift Inventory</h1>
               <div class="flex justify-end mb-4">
                <div class="add-member-button flex items-center">
                    <button id="exportBtn" class="flex" 
                        style="background-color:#009b7b" 
                        class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 ml-2">
                        <img src="../Assets/plus_icon.png" style="margin-right:10px;margin-left:-10px;"> Export Sales
                    </button>
                </div>
            </div>

 
    <div class="flex mt-4 space-x-6" style="border-top:1px solid lightgray" >
        <!-- Basic Information Card -->
        <div class="w-64 bg-white p-2 shadow-lg transition-transform transform hover:scale-105 border-r border-gray-300" style="border-right:1px solid lightgray">
            <div class="flex items-center mb-4" style="margin-top:20px;">
                <img src="../Assets/basic_info.png" class="w-10 h-10 mr-2" alt="Basic Info">
                <h2 class="text-lg font-semibold text-gray-700">Basic Information</h2>
            </div>
            <p class="text-gray-600 mb-2"><strong style="color:#4B4545;font-size:12px;">Inventory Date</strong> <span id="inventoryDate" class="text-gray-800 font-semibold text-sm"></span></p>
            <p class="text-gray-600 mb-2"><strong style="color:#4B4545;font-size:12px;">Products</strong> <span class="text-gray-800 font-semibold text-sm">All (<?php echo count($products); ?> products)</span></p>
            <p class="text-gray-600"><strong style="color:#4B4545;font-size:12px;">In Charge</strong> <span class="text-gray-800 font-semibold text-sm"><?php echo htmlspecialchars($loggedInFirstName) ?> <?php echo htmlspecialchars($loggedInLastName) ?></span></p>
        </div>

        <!-- Product List Card -->
        <div class="flex-grow bg-white p-6 transition-transform transform hover:scale-105">
            <div class="flex items-center mb-4">
                  <div class="flex items-center mb-4">
                    <img src="../Assets/product_list.png" class="w-10 h-10 mr-2" alt="Product List">
                    <h2 class="text-lg font-semibold text-gray-700">Product List</h2>
                </div>
                <button id="exportBtn" class="ml-auto bg-blue-500 text-white px-4 py-2 rounded">Export to Excel</button>
            </div>
            <table class="min-w-full border-collapse" style="border:none!important">
                <thead>
                    <tr class="bg-green-200">
                        <th class="border border-gray-300 px-4 py-2 text-left">No</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Product Name</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Price</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Start Quantity</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">End Quantity</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Quantity Sold</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Sales</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display each product
                    $no = 1; // Counter for product number
                    foreach ($products as $product) {
                        // Fetch start quantity from the database for the logged-in user
                        $startQuantity = $product['Stocks']; // Default fetched stocks from the database
                        $endQuantity = $startQuantity; // This will be changed by the user
                        $quantitySold = 0; // Default to 0, will update based on user input
                        $sales = 0; // Default sales will also update based on user input
                        ?>
                        <tr class="hover:bg-gray-100 transition-colors duration-200">
                            <td class="border border-gray-300 px-4 py-2"><?php echo $no; ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($product['ProductName']); ?></td>
                            <td class="border border-gray-300 px-4 py-2">₱ <?php echo htmlspecialchars($product['Price']); ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($startQuantity); ?></td>
                            <td class="border border-gray-300 px-4 py-2">
                                <input type="number" class="border border-gray-300 p-1" value="<?php echo $endQuantity; ?>" min="0" onchange="updateSales(this, <?php echo $startQuantity; ?>, <?php echo htmlspecialchars($product['Price']); ?>)" />
                            </td>
                            <td class="border border-gray-300 px-4 py-2" id="quantitySold-<?php echo $no; ?>">0</td>
                            <td class="border border-gray-300 px-4 py-2" id="sales-<?php echo $no; ?>">₱ 0.00</td>
                        </tr>
                        <?php
                        $no++;
                    }
                    ?>
                </tbody>
            </table>

          <div class="flex justify-end mt-6">
            <div class="w-1/3 bg-gradient-to-r from-teal-300 to-teal-500 p-6 rounded-lg shadow-lg flex justify-between items-center transition-transform transform hover:scale-105 relative overflow-hidden">
                <div class="absolute inset-0 bg-opacity-25 rounded-lg bg-teal-600 transform scale-105"></div>
                <h3 id="totalAmount" class="relative text-lg font-bold text-black" style="margin-right:50px;">Total Amount</h3>
                <span class="relative text-2xl font-semibold text-black" id="totalSales" style="font-size:20px;">₱ 0.00</span>
            </div>
        </div>

        </div>
    </div>
</div>

<script>
function updateSales(input, startQuantity, price) {
    const endQuantity = parseInt(input.value);
    const quantitySold = startQuantity - endQuantity;
    const sales = quantitySold * price;

    // Update the quantity sold and sales cells
    const row = input.closest('tr');
    row.querySelector('[id^="quantitySold-"]').innerText = quantitySold >= 0 ? quantitySold : 0; // Ensure non-negative
    row.querySelector('[id^="sales-"]').innerText = '₱' + sales.toFixed(2);

    // Calculate total sales
    let total = 0;
    const salesCells = document.querySelectorAll('[id^="sales-"]');
    salesCells.forEach(cell => {
        total += parseFloat(cell.innerText.replace('₱', '').replace(',', '')) || 0;
    });
    document.getElementById('totalSales').innerText = '₱' + total.toFixed(2);
}

// Function to format the date to "Month Day, Year"
function formatDate(date) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return date.toLocaleDateString('en-US', options);
}

// Set the inventory date to the current date
document.getElementById('inventoryDate').innerText = formatDate(new Date());

// Export to Excel functionality
document.getElementById('exportBtn').addEventListener('click', function() {
    window.location.href = 'export_sales.php'; // Adjust the path if needed
});
</script>
<style>
    /* Additional CSS for enhanced styling */
    #sendSales {
        background-color: white; /* Light background for the section */
        padding: 20px; /* Padding around the section */
        border-radius: 10px; /* Rounded corners for the section */
    }

    .card {
        transition: transform 0.2s; /* Smooth scaling effect */
    }

    .card:hover {
        transform: scale(1.05); /* Scale effect on hover */
    }

    table {
        border-spacing: 0; /* Remove spacing between cells */
    }

    th, td {
        white-space:nowrap;
        font-size:14.3px;
    }

    th {
        
    }

    .total-amount {
        font-size: 1.25rem; /* Larger font for total amount */
        font-weight: bold; /* Bold text for emphasis */
    }
</style>


<!--========================MEMBERS SECTION==================-->
        <?php
                include 'connection.php';
                $sql = "SELECT id,  first_name, last_name, membership_type, total_cost, paid_status FROM members";
                $result = $conn->query($sql);
        ?>
        <div id="members" class="section hidden ">
            <!-- =====Search Form -->
            <div class="search-container flex" style="margin-top:40px;margin-right:65px; justify-content: flex-end;">
                <form method="GET" action="" class="flex" style="position:relative;">
                    <input type="text" name="search" id="search" placeholder="Search by name"
                        style="width:400px; height:50px;padding:10px;border:2px solid #009b7b;border-radius:10px"
                        value="<?php echo htmlspecialchars($searchQuery); ?>">
                    <img src="../Assets/search_icon.png"
                        style="position:absolute;width:30px;height:30px;margin-left:15px;margin-top:8px;left:340px">
                </form>
            </div>
            <style>
            .payment-button-container .mark-paid-button {
                background-color: #009B7B;
                /* Green for paid */
            }

            .payment-button-container .mark-debt-button {
                background-color: #f44336;
                /* Red for debt */
            }

            .payment-button-container button:hover {
                opacity: 0.9;
                /* Slightly transparent on hover */
                transform: translateY(-2px);
                /* Lift effect on hover */
            }

            /* Modal styles */
            .modal-main {
                display: flex;
                justify-content: center;
                align-items: center;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                /* Semi-transparent background */
                z-index: 999;
                /* Ensure modal is on top */
            }

            .modal-content-main {
                background-color: white;
                /* White background for modal */
                padding: 20px;
                /* Padding for modal content */
                border-radius: 8px;
                /* Rounded corners */
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
                /* Shadow for depth */
                max-width: 400px;
                /* Max width for modal */
                width: 100%;
                /* Full width */
            }

            .close {
                cursor: pointer;
                /* Pointer cursor for close button */
                font-size: 24px;
                /* Larger font for close */
                color: #333;
                /* Dark color for contrast */
                float: right;
                /* Align close button to the right */
            }

            #modalMemberName {
                text-align: center;
                /* Centered title */
                color: #009B7B;
                /* Theme color for title */
                margin-bottom: 15px;
                /* Space below title */
            }

            #cartItemsListView {
                list-style: none;
                /* Remove default list styling */
                padding: 0;
                /* Remove padding */
            }
            </style>

            <div id="cartItemsModal" class="modal-main">
                <div class="modal-content-main">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h2 id="modalMemberName">Cart Items</h2>
                    <ul id="cartItemsListView"></ul>
                </div>
            </div>

            <table id="membersList" class="members-table"
                style="width:100%; border-collapse:collapse; margin-top:20px;">
                <thead>
                    <tr>
                        <th>Profile</th>
                        <th>Name</th>
                        <th>Membership Type</th>
                        <th>Total Cost</th>
                        <th>Paid Status</th>
                        <th>Items</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Rows will be dynamically added here -->
                </tbody>
            </table>

            <div id="pagination" class="pagination-container"></div>


            <style>
            .modal-main {
                display: none;
                position: fixed;
                z-index: 999;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgb(0, 0, 0);
                background-color: rgba(0, 0, 0, 0.4);
            }

            .modal-content-main {
                background-color: #fefefe;
                margin: 15% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 80%;
            }

            .close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close:hover,
            .close:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;

            }

            .pagination-container button {
                padding: 8px 16px;
                margin: 0 5px;
                border: 1px solid #ccc;
                background-color: #f1f1f1;
                cursor: pointer;
            }

            .pagination-container button.active {
                background-color: #4CAF50;
                color: white;
            }

            .pagination-container button:hover {
                background-color: #ddd;
            }

            .pagination-container {
                display: flex;
                justify-content: center;
                margin-top: 20px;
            }
            </style>

            <!--===========Add Item Modal==================-->
            <div class="AddItemModal hiding" id="AddItemModal">
                <div class="modal-content-add-item" style="margin-right:30px;margin-left:20px;">
                    <div class="left-aligned-content">
                        <!-- Search Input -->
                        <input type="text" class="search-item" id="searchInput" placeholder="Search products..."
                            onkeyup="filterProducts()">
                    </div>
                    <?php
                        // Function to sanitize productId for use in HTML IDs
                        function sanitizeId($id) {
                            return preg_replace('/[^a-zA-Z0-9_-]/', '_', $id);
                        }

                        function highlightSearchTerm($text, $searchTerm) {
                            $searchTerm = preg_quote($searchTerm, '/');
                            return preg_replace('/('.$searchTerm.')/iu', '<mark>$1</mark>', $text);
                        }

                        include 'connection.php';

                        // Define pagination parameters
                        $itemsPerPage = 10; // Change this to the number of items you want per page
                        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $offset = ($currentPage - 1) * $itemsPerPage;

                        // Get the total number of products
                        $totalSql = "SELECT COUNT(*) AS total FROM AddProducts";
                        $totalResult = $conn->query($totalSql);
                        $totalRow = $totalResult->fetch_assoc();
                        $totalItems = $totalRow['total'];
                        $totalPages = ceil($totalItems / $itemsPerPage);

                        // Fetch products for the current page
                        $sql = "SELECT * FROM AddProducts LIMIT $itemsPerPage OFFSET $offset";
                        $result = $conn->query($sql);

                        $searchTerm = isset($_GET['search']) ? strtolower($_GET['search']) : '';

                        if ($result->num_rows > 0) {
                            echo "<table id='productTable' class='product-table'>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>Product Name</th>";
                            echo "<th>Price</th>";
                            echo "<th>Quantity</th>";
                            echo "<th>Total</th>";
                            echo "<th>Add to Cart</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";

                            while ($row = $result->fetch_assoc()) {
                                $image = $row['image'];
                                $productName = htmlspecialchars($row['ProductName']);
                                $price = number_format((float)$row['Price'], 2, '.', '');
                                $stocks = htmlspecialchars($row['Stocks']);
                                $Id = sanitizeId(htmlspecialchars($row['id']));
                                $imgSrc = !empty($image) ? 'data:image/jpeg;base64,' . base64_encode($image) : 'path/to/default/image.jpg';

                                // Highlight search term in product name
                                $highlightedName = $productName;
                                if ($searchTerm) {
                                    $highlightedName = highlightSearchTerm($highlightedName, $searchTerm);
                                }

                                // Determine if the product is out of stock
                                $outOfStockClass = ($stocks <= 0) ? 'out-of-stock-message' : 'hidden';
                                $isOutOfStock = ($stocks <= 0) ? 'disabled' : '';

                                echo "<tr class='product-row'>";
                                // Product Image
                                echo "<td><div class='product-image-container'>
                                        <div class='$outOfStockClass' style='font-size:6px;'>Out of Stock</div>
                                        <img src='" . $imgSrc . "' alt='Product Image' class='product-image' style='width:40px;height:40px;'>
                                    </div></td>";
                                
                                // Product Name
                                echo "<td><h2>" . $highlightedName . "</h2></td>";

                                // Price
                                echo "<td>
                                        <div class='price-flex'>
                                        ₱ 
                                            <p >" . $price . "</p>
                                        </div>
                                    </td>";

                                // Quantity
                                echo "<td>
                                    <div class='quantity-container' style='display: flex; align-items: center;'>
                                        <button style='background-color: red; color: white; border: none; width: 30px; height: 30px; font-size: 18px; text-align: center; padding: 0;' onclick='updateItemQuantity(\"$Id\", -1)' $isOutOfStock>-</button>
                                        <input style='width: 50px; height: 30px; margin-top: 7px; text-align: center; border: 1px solid #ccc; margin: 0 10px;' type='text' id='quantity_$Id' class='quantity-input' value='1' readonly>
                                        <button style='background-color: green; color: white; border: none; width: 30px; height: 30px; font-size: 18px; text-align: center; padding: 0;' onclick='updateItemQuantity(\"$Id\", 1)' $isOutOfStock>+</button>
                                    </div>
                                </td>";

                                // Total Price
                                echo "<td>
                                        <div class='total-container flex'>
                                            ₱
                                            <span id='totalItem_" . $Id . "' data-price='" . $price . "' class='total-price'>" . $price . "</span>
                                        </div>
                                    </td>";

                                // Add to Cart Button
                                echo "<td style='overflow:hidden;background-color:##009b7b!important;'>
                                <button class='' style='font-size:20px;width:40px;height:40px;color: white !important;border-radius:50%;text-align:center;display:flex;justify-content:center;align-items:center;background-color:##009b7b!important;overflow:hidden;' onclick='addToCart(\"$Id\")' $isOutOfStock>
                                +
                                </button>
                                </td>";

                                echo "</tr>";
                            }

                            echo "</tbody>";
                            echo "</table>";

                            // Pagination controls
                            echo "<div class='pagination'>";
                            $pageLimit = 5; // Limit to 5 page links
                            $startPage = max(1, $currentPage - floor($pageLimit / 2));
                            $endPage = min($totalPages, $startPage + $pageLimit - 1);

                            // Adjust start page if it goes below 1
                            if ($endPage - $startPage < $pageLimit - 1) {
                                $startPage = max(1, $endPage - $pageLimit + 1);
                            }

                            // Previous button
                            if ($currentPage > 1) {
                                echo "<a href='?page=" . ($currentPage - 1) . "&search=" . htmlspecialchars($searchTerm) . "'>Previous</a> ";
                            }

                            // Page links
                            for ($i = $startPage; $i <= $endPage; $i++) {
                                if ($i == $currentPage) {
                                    echo "<strong>$i</strong> ";
                                } else {
                                    echo "<a href='?page=$i&search=" . htmlspecialchars($searchTerm) . "'>$i</a> ";
                                }
                            }

                            // Next button
                            if ($currentPage < $totalPages) {
                                echo "<a href='?page=" . ($currentPage + 1) . "&search=" . htmlspecialchars($searchTerm) . "'>Next</a>";
                            }
                            echo "</div>";

                        } else {
                            echo "<p>No products found</p>";
                        }

                        $conn->close();
                        ?>

                </div>

                <div class="cart-display" id="cartDisplay" style="display: none;">
                    <div class="close-button" onclick="closeCart()">&times;</div> <!-- Close button -->
                    <h3><span id="memberNameDisplay"></span></h3>
                    <ul id="cartItemsList">
                        <!-- Cart items will be dynamically added here -->
                    </ul>
                    <div class="overflow:hidden">
                        <strong style="font-size:20px;margin-right:20px;">Total</strong><span id="cartTotal"> P
                            0.00</span>
                    </div>
                    <div class="flex">
                        <div class="block staff-box">
                            <h1 class="text-left" style="border-bottom: 1px solid #009B7B;color:#009B7B">Staff
                            </h1>
                            <h1 style="padding:5px;"><?php echo htmlspecialchars($firstName); ?>
                                <?php echo htmlspecialchars($lastName); ?>
                            </h1>
                        </div>
                    </div>
                    <button onclick="submitCart()" class="confirm-order">Confirm Order</button>
                </div>

            </div>
            <style>
            /* Staff Indicator */
            .staff-box {
                margin-top: 20px;
                border: 1px solid #009B7B;
                padding: 2px 20px 2px 20px;
                text-align: center;
                border-radius: 20px;

                justify-content: center;
            }

            .confirm-order {
                text-align: center;
                display: flex;
                justify-content: center;
                margin: 0 auto;
            }

            button:disabled {
                background-color: #ccc;
                cursor: not-allowed;
                opacity: 0.6;
            }

            .wrap-container {
                display: flex;
                justify-content: space-between;

            }

            .cart-display {
                background-color: white;
                width: 400px;
                /* Adjust width as needed */
                padding: 20px;
                border-radius: 25px;
                margin-top: 25px;
                margin-right: 25px;
                /* Spacing between product list and cart */
                border-left: 2px solid #ddd;
                /* Optional: add a border for separation */
            }


            /* When the cart is active, show it with animation */
            .cart-display.active {
                opacity: 1;
                transform: translateY(0);
                display: block;
            }

            /* Title and Member Name */
            .cart-display h3 {
                font-size: 24px;
                /* Updated color */
                text-align: center;
                margin-bottom: 20px;
                font-family: 'Arial', sans-serif;
                letter-spacing: 1.5px;
            }

            /* Member Name Style */
            #memberNameDisplay {
                color: #009b7b;
                /* Red color for member name */
                font-weight: bold;
                text-align: center;
            }

            /* Close Button */
            .cart-close-btn {
                font-size: 20px;
                /* Size for close button */
                color: red;
                /* Red color for close button */
                cursor: pointer;
                /* Pointer on hover */
                position: absolute;
                /* Position it in the corner */
                top: 15px;
                /* Space from the top */
                right: 15px;
                /* Space from the right */
            }

            /* Cart Items List */
            #cartItemsList {
                list-style-type: none;
                padding: 0;
                margin: 20px 0;
            }

            .cart-display {
                position: relative;
                /* Position relative for absolute positioning of the close button */
            }

            .close-button {
                position: absolute;
                top: -5px;
                right: 23px;
                font-size: 30px;
                color: red;
                cursor: pointer;
                z-index: 10;

            }

            .close-button:hover {
                color: darkred;
                /* Change color on hover for better UX */
            }

            /* Individual Cart Item */
            #cartItemsList li {
                font-size: 18px;
                color: #333;
                background: #f7f7f7;
                margin: 10px 0;
                padding: 10px;
                border-radius: 10px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
                transition: transform 0.2s;
            }

            /* Hover Effect on Cart Items */
            #cartItemsList li:hover {
                transform: translateY(-5px);
            }

            /* Cart Total */
            #cartTotal {
                font-size: 19px;
                font-weight: bold;
                color: #009b7b;
                /* Updated color */
                border-radius: 10px;

                margin-top: 20px;
            }

            #cartTotal::before {
                content: "P ";
                width: 30px;
                height: 40px;
            }

            /* Submit Cart Button */
            .cart-display button {
                background-color: #009b7b;
                border: none;
                padding: 10px 20px;
                font-size: 18px;
                color: #fff;
                border-radius: 10px;
                cursor: pointer;
                transition: background-color 0.3s ease;
                margin-top: 20px;
                box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
            }

            .cart-display button:hover {
                background-color: #33BBAF;
            }

            @keyframes pop-in {
                0% {
                    transform: scale(0.9);
                    opacity: 0;
                }

                100% {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            .cart-display.active ul li {
                animation: pop-in 0.3s ease forwards;
            }
            </style>
            <script>
            function closeCart() {
                document.getElementById("cartDisplay").style.display = "none"; // Hide the cart display
            }
            </script>






            <!----==================Main Container OF THE SECTIONS ENDPOINT=================-->
        </div>
        <div class="section hidden" id="Expenses">
            <div id="infoBox" class="mb-4 flex justify-between items-center mt-6">
                <h1 class="text-lg text-[#124137] font-bold">Expenses</h1>
                <div class="flex items-center" style="margin-bottom:10px;">
                    <button onclick="window.location.href='export.php'"
                        class="export-excel text-black font-bold justify-end"
                        style="border:2px solid #009B7B; color: #009B7B;background-color:white;border-radius:10px;padding:9px 45px 9px 45px;margin-right:20px;margin-top:7px;">
                        Export to Excel
                    </button>
                    
                    
                    <div class="add-member-button flex items-center" style="margin-top:7px;">
                    <button id="openModalButton" class="flex" class="button-add-item" onclick="showModalExpenses()"
                        style="background-color:#009b7b"
                        class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 ml-2">
                        <img src="../Assets/plus_icon.png" style="margin-right:10px;margin-left:-10px;"> Add Expense
                    </button>
                </div>
                   
                </div>
            </div>

<!-- Filters -->
<div class="filter-container flex flex-col md:flex-row md:items-center mb-6 p-4 bg-white rounded-lg shadow-md border border-gray-200">
    <!-- Date Filter -->
    <div class="md:mr-4 mb-4 md:mb-0">
        <label for="startDate" class="block text-sm font-semibold text-gray-700">Filter by Date</label>
        <input type="date" id="startDate" class="mt-1 block w-full border-2 border-gray-300 rounded-md p-2 transition duration-150 ease-in-out focus:ring-2 focus:ring-blue-500" onchange="applyFilters()" />
    </div>

    <!-- Staff Filter -->
    <div class="md:mr-4 mb-4 md:mb-0">
        <label for="staffDropdown" class="block text-sm font-semibold text-gray-700">Select Staff</label>
        <select id="staffDropdown" onchange="applyFilters()" class="border text-gray-600 rounded-md p-2 ml-2 mt-1 block w-full border-2 border-gray-300 transition duration-150 ease-in-out focus:ring-2 focus:ring-blue-500">
            <option value="">All Staff</option>
            <?php foreach ($staffMembers as $staff): ?>
            <option value="<?php echo htmlspecialchars($staff['first_name'] . ' ' . $staff['last_name']); ?>">
                <?php echo htmlspecialchars($staff['first_name'] . ' ' . $staff['last_name']); ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Search Input with Icon -->
    <div class="relative mb-4 md:mb-0">
        <label for="searchInput" class="block text-sm font-semibold text-gray-700">Search Expenses</label>
        <input type="text" id="searchInput" placeholder="Search expenses..." class="mt-1 block w-full border-2 border-gray-300 rounded-md p-2 pr-10 transition duration-150 ease-in-out focus:ring-2 focus:ring-blue-500" oninput="applyFilters()" />
        <button type="button" onclick="applyFilters()" class="absolute right-2 top-2 text-gray-600 hover:text-blue-500 transition duration-150 ease-in-out">
            <img src="../Assets/search_icon.png" alt="Search" class="w-5 h-5" />
        </button>
    </div>
</div>

                <!-- Expense Table -->
                <table id="expenseTable" class="min-w-full" style="border-radius:20px;border: none!important">
                    <thead style="border-radius:20px !important">
                        <tr>
                            <th>Date</th>
                            <th>Image</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Supplier</th>
                            <th>Amount</th>
                            <th>Staff Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
     <?php
            include 'connection.php';
            // Query to calculate total expenses
            $sql = "SELECT SUM(amount) AS total_amount FROM expenses";
            $result = $conn->query($sql);
            $totalAmount = 0.00;
            
            if ($result->num_rows > 0) {
                // Fetch total amount
                $row = $result->fetch_assoc();
                $totalAmount = $row['total_amount'] ? $row['total_amount'] : 0.00;
            }
            
            $conn->close();
            ?>
<style>
        /* Custom styling for the total amount section */
        .total-amount-container {
            width: 30%; /* Adjust the width to 20% */
            background-color: #69b2ae30; /* Soft transparent green background */
            margin-top: 20px;
            padding: 20px;
            border-radius: 10px; /* Slightly more rounded corners */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Soft shadow for better contrast */
            display: flex;
            justify-content: space-between;
            align-items: center; /* Vertically align content */
        }

        .total-amount-container h3,
        .total-amount-container span {
            color: #333; /* Darker color for improved readability */
            font-weight: bold;
            overflow:hidden;
            font-size: 20px; /* Increased font size for better visibility */
        }

        .total-amount-container h3 {
            margin-right: 30px; /* Space between the label and the amount */
        }

        /* Additional media query to adjust styling for smaller screens */
        @media (max-width: 768px) {
            .total-amount-container {
                width: 50%; /* Expand width on smaller screens */
                margin: 10px auto; /* Centered with some margin */
            }
        }

        @media (max-width: 480px) {
            .total-amount-container {
                width: 80%; /* Even more space for mobile devices */
            }
        }
    </style> 
    <div class="flex justify-end">
            <div class="total-amount-container">
                <h3 id="totalAmount" class="text-lg font-bold">Total Amount</h3>
                <span><span style="margin-right: 10px;">₱</span><?php echo number_format($totalAmount, 2); ?></span>
            </div>
        </div>
            <!-- Pagination Controls -->
            <div class="pagination" id="pagination">
                <button id="prevBtn" class="flex" onclick="changePage(-1)" disabled> <img
                        src="../Assets/back_paginate.png" style="margin-top:3px">Back</button>

                <span id="paginationNumbers"></span>

                <button id="nextBtn" class="flex" onclick="changePage(1)" disabled> Next <img
                        src="../Assets/next_paginate.png" style="margin-top:3px"></button>

                <span id="rangeInfo" style="margin-top:15px;margin-left:30px;color:#424141"></span>
                <!-- Data Range Info -->
            </div>

            <!-- Modal Container -->
            <div id="modal-expenses" class="modal-expenses hidden">
                <div id="modal-content-expenses" class="modal-content-expenses p-6 w-4/5 mx-auto relative">
                    <h2 class="text-2xl font-bold mb-6" style="margin-bottom:25px;">Add New Expense</h2>

                    <form id="expenseForm" class="space-y-6" enctype="multipart/form-data" method="POST">
                        <div class="block w-full">
                            <label for="description" class="block text-sm font-medium text-gray-700">Expense
                                Name <span style="color:red">*</span></label>
                            <input type="text" id="description" name="description" required
                                class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-md focus:border-blue-500 focus:ring focus:ring-blue-200 p-2"
                                style="font-size:18px">
                        </div>
                        <label for="imageUpload" style="margin-top:20px;"
                            class="block text-sm font-medium text-gray-700">Image <span
                                style="color:red">*</span></label>
                        <div class="flex w-full border-2 border-gray-300 rounded-md shadow-md mt-6 p-2">
                            <label for="imageUpload" id="fileLabel" class="block text-sm font-medium text-gray-700 mr-2"
                                style="white-space:nowrap;width:200px;margin-top:5px;cursor:pointer">Choose
                                file</label>
                            <div class="flex items-center border border-gray-300 rounded-md shadow-md p-2 w-full">
                                <input type="file" id="imageUpload" name="imageUpload" accept="image/*" class="hidden"
                                    onchange="displayFileName(this)">
                                <img src="../Assets/attachment.png" alt="Clip" class="cursor-pointer w-6 h-6 ml-2"
                                    onclick="document.getElementById('imageUpload').click()" style="margin-left:270px;">
                                <span id="fileName" class="ml-2 text-gray-700 hidden">No file chosen</span>
                            </div>
                        </div>

                        <script>
                        function displayFileName(input) {
                            const fileName = input.files[0]?.name;
                            if (fileName) {
                                document.getElementById('fileLabel').textContent =
                                    fileName;
                                document.getElementById('fileName').classList.add(
                                    'hidden');
                            }
                        }
                        </script>

                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Type <span
                                    style="color:red">*</span></label>
                            <input type="text" id="type" name="type" required
                                class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-md focus:border-blue-500 focus:ring focus:ring-blue-200 p-2">
                        </div>

                        <div class="flex justify-between">
                            <div class="w-full mr-10 pr-2" style="margin-right:10px;">
                                <label for="supplier" class="block text-sm font-medium text-gray-700">Supplier
                                    <span style="color:red">*</span></label>
                                <input type="text" id="supplier" name="supplier" required
                                    class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-md focus:border-blue-500 focus:ring focus:ring-blue-200 p-2">
                            </div>

                            <div class="w-full ml-10">
                                <label for="amount" class="block text-sm font-medium text-gray-700">Amount <span
                                        style="color:red">*</span></label>
                                <input type="number" id="amount" name="amount" step="0.01" required
                                    class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-md focus:border-blue-500 focus:ring focus:ring-blue-200 p-2">
                            </div>
                        </div>

                        <div class="flex justify-center mt-4">
                            <button type="button" id="cancelButton1" class="cancel-button1"
                                onclick="closeModalExpenses()">Cancel</button>
                            <button type="submit" id="addButton1" class="add-button1">Add</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- Modal for verify Password -->
        <div id="modal-verify-password" class="modal-expenses" style="display:none;">
            <div class="modal-background" onclick="closeVerifyModal()"></div>
            <div class="modal-content-view-expense1">
                <img src="../Assets/verify.png" class="text-center justify-center align-center">
                <h3 class="modal-title" style="font-size:20px">Verify Password</h3>
                <input type="password" id="verification-password" placeholder="Enter your password" class="input"
                    required />
                <div id="error-message" style="color: red; display: none;">Invalid password. Please try again.
                </div>
                <div class="flex">
                    <button class="button is-primary confirm-delete-btn"
                        style="flex: 1; white-space: nowrap; margin-right: 10px;"
                        onclick="closeVerifyModal()">Cancel</button>
                    <button class="button is-primary confirm-delete-btn" id="confirm-delete-btn"
                        style="flex: 1; white-space: nowrap;" onclick="confirmDelete()">Confirm</button>
                </div>
            </div>
        </div>


        <!-- Modal for viewing expense Data -->
        <div id="modal-view-expense1" class="modal-expenses" style="display:none;">
            <div class="modal-background" onclick="closeModal()"></div>
            <div class="modal-content-view-expense1">
                <img id="modalImage" alt="Expense Image" class="modal-image" />
                <div class="modal-details">
                    <div class="modal-title" id="modalTitle"></div>
                    <div class="modal-date" id="modalDate"></div>
                    <div class="modal-type" id="modalType"></div>
                    <div class="modal-supplier" id="modalSupplier"></div>
                    <div class="modal-amount" id="modalAmount"></div>
                </div>
                <button class="button is-primary" onclick="closeView()">Close</button>
            </div>
        </div>
        <script>
        function closeView() {
            document.getElementById('modal-view-expense1').style.display = "none";
        }
        </script>
        <style>
        .confirm-delete-btn {
            background-color: lightcoral;
            /* Keep the background color */
            white-space: nowrap;
            /* Prevent text wrapping */
            font-size: 12px;
            /* Set font size */
            width: 200px;
            /* Make button full width */
            display: block;
            /* Ensure it behaves like a block element */
            margin-top: 10px;
            /* Add some spacing if needed */
        }

        #confirm-delete-btn {
            font-weight: bold;

        }

        #confirm-delete-btn:hover {
            font-weight: bold;
            background-color: red;
            transition: .5s;

        }

        .modal-content-view-expense1 {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            margin: 5% auto;
            max-width: 500px;
            /* Keep the same max-width */
            width: 90%;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            animation: slideIn 0.5s;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .modal-title {
            color: #009B7C;
            font-size: 1.5rem;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .button {
            margin-top: 10px;
        }

        .modal-image {
            border-radius: 12px;
            max-width: 100%;
            height: auto;
            margin-bottom: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .modal-details {
            background-color: #f9f9f9;
            padding: 15px;
            text-align: left;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .modal-date,
        .modal-type,
        .modal-supplier,
        .modal-amount {
            color: #333;
            font-size: 1rem;
            margin: 5px 0;
        }

        .button.is-primary {
            background-color: #009B7C;
            /* Button color */
            color: #fff;
            padding: 10px 80px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 15px;
            overflow: hidden;
        }

        .button.is-primary:hover {
            background-color: #007B5F;
            /* Darker color on hover */
        }
        </style>

        <script>
        function showModalExpenses() {
            const modal = document.getElementById('modal-expenses');
            modal.classList.remove('hidden');
            modal.style.display = "flex";
        }

        function closeModalExpenses() {
            const modal = document.getElementById('modal-expenses');
            modal.classList.add('hidden');
            modal.style.display = "none";
        }
        </script>
        <style>
        .cancel-button1,
        .add-button1 {
            width: 120px;
            margin-top: 50px;
            height: 40px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-size: 16px;
            padding: 12px;
            border-radius: 8px;
            transition: background-color 0.3s;
            cursor: pointer;
        }

        .cancel-button1 {
            background-color: white;
            color: black;
            border: 1.2px solid #A2A1A8;
            margin-right: 20px;
        }

        .cancel-button1:hover {
            background-color: #A2A1A8;
            color: #007d62;
        }

        .add-button1 {
            background-color: #009B7B;
            color: white;
        }

        .add-button1:hover {
            background-color: #007d62;
        }
        </style>

        <!--==========================EXPENSES SECTION =============================-->
        <!--=============Loading Animation-->
        <div id="loadingSpinner" class="relative hidden" style="background-color:transparent!important">
            <div style="background-color:white;padding:5px;border-radius:50% !important;box-shadow:rgba(0,0,0,0.1)!important;">
            <img src="../Assets/alternate_loading.gif" class="loading" alt="Loading Spinner" style="width:50px !important;height:50px!important;" >
            </div>
        </div>
        <!--=============Loading Animation-->
        <script src="../JS/dashboard.js"></script>
        <script src="../JS/pagination.js"></script>
        <script src="../JS/logout.js"></script>
        <script src="../JS/sales.js"></script>
        <script src="../JS/stocks.js"></script>
        <script src="../JS/product.js"></script>
        <script src="../JS/add_member.js"></script>
        <script src="../JS/expenses.js"></script>
        <script src="../JS/members.js"></script>
        <script src="../JS/showSettings.js"></script>
        <script src="../JS/profile.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="../JS/update_file_product.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/1.9.3/countUp.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.0.2/index.min.js"></script>
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/dist/index.global.min.js'></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/progressbar.js@1.1.0/dist/progressbar.min.js"></script>

</body>

</html>