<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Admin Panel</title>
    <link href="" rel="stylesheet" type="text/css">
    <link href="../src/output.css" rel="stylesheet">

</head>

<body>

    <!--Navigation Sidebar -->
    <nav>
        <div class="nav-container">
            <ul>
                <a class="dashboard" onclick="showSection('Dashboard')">
                    <li>
                        <img src="../Assets/dashboard.png">
                        <span>Dashboard</span>
                    </li>
                </a>
                <a class="Products" onclick="showSection('Products')">
                    <li>
                        <img src="../Assets/dashboard.png">
                        <span>Products</span>
                    </li>
                </a>
                <a class="Reports" onclick="showSection('Reports')">
                    <li>
                        <img src="../Assets/dashboard.png">
                        <span>Reports</span>
                    </li>
                </a>
                <a class="branches" onclick="showSection('Branches')">
                    <li>
                        <img src="../Assets/dashboard.png">
                        <span>Branches</span>
                    </li>
                </a>
            </ul>
        </div>
    </nav>


    <button onclick="showAddingStaff()">Click to Show the Addign Staff</button>
    <!--=======CHOOSING BRANCH SECTION ==============-->


    <div class="ChooseBranch flex w-full ">
        <!--======= Branches ==========-->
        <div class="talisayBranch">Talisay Branch</div>
        <div class="consolationBranch">Consolation Branch</div>
        <div class="cebuCityBranch">Cebu Citys Branch</div>
        <!--======= Branches ==========-->
    </div>
    <!--=======CHOOSING BRANCH SECTION ==============-->

    <!--============Adding Section for the Staff  ==========-->
    <div class="bg-white shadow-md w-full mt-5 hidden" id="StaffForm">
        <div>
            <form id="AddStaff bg-white shadow-md " method="POST" action="authenticate.php">
                <!--Username -->
                <div class="input-container block ">
                    <label>First Name </label>
                    <input type="text" placeholder="" name="firstName">
                </div>
                <!--Password-->
                <div class="input-container block ">
                    <label>LastName </label>
                    <input type="text" placeholder="" name="lastName">
                </div>
                <!--Username -->
                <div class="input-container block ">
                    <label>Staff Username </label>
                    <input type="text" placeholder="" name="staffUsername">
                </div>
                <!--Password-->
                <div class="input-container block ">
                    <label>Staff Password </label>
                    <input type="password" placeholder="" name="staffPassword">
                </div>
                <!--Email-->
                <div class="input-container block ">
                    <label>Staff Email </label>
                    <input type="email" placeholder="" name="staffEmail">
                </div>
                <!--BUTTON FOR ADDING STAFF-->
                <button>
                    Add Staff
                </button>

            </form>
        </div>
    </div>
    <!--============Adding Section for the Staff  ==========-->



    <!--Adding Admin -->

    <div class="bg-white shadow-md w-full mt-5" id="StaffForm">
        <div>
            <form id="adminForm" method="POST" action="add_admin.php">
                <div class="input-container block">
                    <label>First Name </label>
                    <input type="text" placeholder="" name="AdminfirstName" required>
                </div>
                <div class="input-container block">
                    <label>Last Name </label>
                    <input type="text" placeholder="" name="AdminlastName" required>
                </div>
                <div class="input-container block">
                    <label>Admin Address </label>
                    <input type="text" placeholder="" name="address" required>
                </div>
                <div class="input-container block">
                    <label>Contact No </label>
                    <input type="text" placeholder="" name="contact_number" required>
                </div>
                <div class="input-container block">
                    <label>Admin Username </label>
                    <input type="text" placeholder="" name="username" required>
                </div>
                <div class="input-container block">
                    <label>Admin Password </label>
                    <input type="password" placeholder="" name="password" required>
                </div>
                <div class="input-container block">
                    <label>Admin Email </label>
                    <input type="email" placeholder="" name="email" required>
                </div>
                <button type="submit">
                    Add Admin
                </button>
            </form>
            <div id="error-message" style="color: red;"></div>

        </div>
    </div>


    <!--=============Script Tags=================-->
    <script src="../O-js/add_staff.js"></script>
</body>

</html>