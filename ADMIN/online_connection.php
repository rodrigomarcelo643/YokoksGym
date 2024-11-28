<!--================================= Renew Membership Modal =======================================-->
        <div id="renewMemberModal" class="modal fixed inset-0 flex items-center justify-center bg-black bg-opacity-60 hidden z-50">
            <div class="modal-content-member bg-white p-8 rounded-lg shadow-lg w-full transform scale-90 transition-transform duration-300 ease-in-out hover:scale-100" style="width:650px !important;">
                <div class="flex justify-end">
                    <button class="text-gray-600 hover:text-gray-900 transition-colors duration-150" onclick="hideRenewModal()">
                        <img src="../Assets/close.png" alt="Close" class="w-6 h-6">
                    </button>
                </div>
        
                <!--===================TITLE RENEWING MEMBERSHIP =====================-->
                <div class="TitleAddingProduct flex mb-6">
                    <h1 class="text-gray-600 font-bold text-lg" style="margin-bottom:20px;">RENEW MEMBERSHIP</h1>
                </div>
                <!--===================TITLE RENEWING MEMBERSHIP =====================-->
        
                <!--============NAME FLEX==========-->
                <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0">
                    <div class="flex-1 flex flex-col" style="margin-right:20px;margin-bottom:5px;">
                        <label for="renewFirstName" class="block text-sm font-medium text-gray-700">First Name<span style="color:red"> *</span></label>
                        <input type="text" id="renewFirstName" name="renewFirstName" placeholder=" " readonly
                            class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-md focus:border-blue-500 focus:ring focus:ring-blue-200 p-2 pr-10">
                    </div>
                    <div class="flex-1 flex flex-col" style="margin-right:20px;margin-bottom:5px;">
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
            <!--============MEMBERSHIP TYPE SELECT==========-->
            <div class="flex flex-col mb-4" class="custom-select">
                <label for="renewMembershipType" class="block text-sm font-medium text-gray-700">Membership Type <span style="color:red">*</span></label>
                <select id="renewMembershipType" name="renewMembershipType"
                    class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-md focus:border-blue-500 focus:ring focus:ring-blue-200 p-2 pr-10">
                    <option value="daily-basic">Daily Basic</option>
                    <option value="daily-pro">Daily Pro</option>
                    <option value="monthly-basic">Monthly Basic</option>
                    <option value="monthly-pro">Monthly Pro</option>
                </select>
            </div>
            <!--============MEMBERSHIP TYPE SELECT==========-->
            
            <!--============TOTAL COST DISPLAY==========-->
            <div class="flex flex-col mb-4">
                <label class="block text-sm font-medium text-gray-700">Total Amount</label>
                <div class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-md p-4">
                    <p class="text-gray-600 font-bold" style="color:gray;font-size:14px;">Total Amount</p>
                    <span id="renewTotalCost" class="font-bold text-lg">$100</span>
                    <input type="hidden" id="renewTotalCostHidden" name="renewTotalCost" value="100">
                </div>
            </div>
            <!--============TOTAL COST DISPLAY==========-->
            
            
                    <!--============SUBMIT BUTTON==========-->
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="full-width-button bg-blue-600 text-white font-semibold py-2 px-4 rounded-md shadow-md hover:bg-blue-700">
                            <h1 class="text-lg" style="color:white;">Renew Membership</h1>
                        </button>
                    </div>
                    <!--============SUBMIT BUTTON==========-->
                </div>
        </div>


        <!--================================= Add Member Modal =======================================-->
        <div id="addMemberModal" class="modal fixed inset-0 flex items-center justify-center bg-black bg-opacity-60 hidden z-50">
            <div class="modal-content-member bg-white p-8 rounded-lg shadow-lg w-full transform scale-90 transition-transform duration-300 ease-in-out hover:scale-100" style="width:650px !important;">
                <div class="flex justify-end">
                    <button class="text-gray-600 hover:text-gray-900 transition-colors duration-150" onclick="hideAddMembershipModal()">
                        <img src="../Assets/close.png" alt="Close" class="w-6 h-6">
                    </button>
                </div>
                <form id="memberForm" class="memberForm">
                <!--===================TITLE ADDING MEMBER =====================-->
                <div class="TitleAddingProduct flex mb-6">
                    <h1 class="text-gray-600 font-bold text-lg" style="margin-bottom:20px;">ADD MEMBER</h1>
                </div>
                <!--===================TITLE ADDING MEMBER =====================-->
        
                <!--============NAME FLEX==========-->
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
                    <input type="text" id="contactNumber" name="contactNumber" placeholder=" " required class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-md focus:border-blue-500 focus:ring focus:ring-blue-200 p-2 pr-10">
                </div>
                <!--============CONTACT NUMBER FLEX==========-->
        
                <!--============MEMBERSHIP TYPE TITLE==========-->
                <div class="flex mt-4">
                    <h1 class="text-gray-600 font-bold text-lg" style="margin-top:15px;margin-bottom:10px;">Membership Type</h1>
                </div>
                <!--============MEMBERSHIP TYPE TITLE==========-->
        
                <!--============MEMBERSHIP TYPE SELECT==========-->
                <div class="flex flex-col mb-4">
                    <label for="membershipType" class="block text-sm font-medium text-gray-700">Membership Type <span style="color:red">*</span></label>
                    <select id="membershipType" name="membershipType" class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-md focus:border-blue-500 focus:ring focus:ring-blue-200 p-2 pr-10">
                        <option value="daily-basic">Daily Basic</option>
                        <option value="daily-pro">Daily Pro</option>
                        <option value="monthly-basic">Monthly Basic</option>
                        <option value="monthly-pro">Monthly Pro</option>
                    </select>
                </div>
                <!--============MEMBERSHIP TYPE SELECT==========-->
        
                <!--============TOTAL COST DISPLAY==========-->
                <div class="flex flex-col mb-4">
                    <label class="block text-sm font-medium text-gray-700">Total Amount</label>
                    <div class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-md p-4">
                        <p class="text-gray-600 font-bold" style="color:gray;font-size:14px;">Total Amount</p>
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