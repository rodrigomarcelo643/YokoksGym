function showSection(sectionId, initialLoad = false) {
  const sections = document.querySelectorAll(".section");
  const sidebarItems = document.querySelectorAll(".sidebar-item");
  const sidebarIcons = {
    dashboard: "../Assets/dash_active.png",
    products: "../Assets/products_main_active.png",
    membership: "../Assets/membership_main_active.png",
    sendSales: "../Assets/inventory_a.png",
    members: "../Assets/billing_main_active.png",
    Expenses: "../Assets/expenses_main_active.png",
  };
  const defaultIcons = {
    dashboard: "../Assets/dashboard_main.png",
    products: "../Assets/products_main.png",
    membership: "../Assets/membership_main.png",
    sendSales: "../Assets/invent.png",
    members: "../Assets/billing_main.png",
    Expenses: "../Assets/expenses_main.png",
  };

  const sectionToShow = document.getElementById(sectionId);

  // If the section is already visible, exit the function early
  if (sectionToShow && !sectionToShow.classList.contains("hidden")) {
    return; // Exit early if the section is already active
  }

  showLoadingSpinner();

  const loadTime = getEstimatedLoadTime();

  setTimeout(() => {
    sections.forEach((section) => {
      section.classList.add("hidden");
    });

    sidebarItems.forEach((item) => {
      item.classList.remove("bg-green-500", "text-black");
      // Revert the icons to the default icon for inactive items
      const icon = item.querySelector(".sidebar-icon");
      if (icon) {
        const section = item.getAttribute("data-section");
        icon.src = defaultIcons[section];
      }
    });

    if (sectionToShow) {
      sectionToShow.classList.remove("hidden");
      sectionToShow.classList.add("show");
    }

    const activeSidebarItem = document.querySelector(
      `[data-section="${sectionId}"]`
    );
    if (activeSidebarItem) {
      activeSidebarItem.classList.add("bg-green-500", "text-black");

      // Change the icon of the active item
      const activeIcon = activeSidebarItem.querySelector(".sidebar-icon");
      if (activeIcon) {
        activeIcon.src = sidebarIcons[sectionId];
      }
    }

    // Save the active section ID in localStorage
    localStorage.setItem("activeSection", sectionId);

    // Update the URL hash to reflect the active section
    window.location.hash = sectionId;

    hideLoadingSpinner();
  }, loadTime);
}

// Function to initialize the active section on page load
function initializeActiveSection() {
  const activeSection = localStorage.getItem("activeSection");

  // Check if there's a hash in the URL
  const hash = window.location.hash.substring(1); // Remove the '#' from the hash

  // Use the hash if it exists; otherwise, use the stored section or default
  if (hash) {
    showSection(hash, true);
  } else if (activeSection) {
    showSection(activeSection, true);
  } else {
    // Optionally, show a default section if none is saved
    showSection("dashboard", true); // Change "dashboard" to your default section
  }
}

// Call the initialization function when the page loads
window.onload = initializeActiveSection;

// ==========================Function to get estimated load time based on network conditions
function getEstimatedLoadTime() {
  const connectionType = navigator.connection
    ? navigator.connection.effectiveType
    : "4g";
  switch (connectionType) {
    case "slow-2g":
      return 3000;
    case "2g":
      return 2500;
    case "3g":
      return 1500;
    case "4g":
      return 1000;
    default:
      return 700;
  }
}

// =================================Function to show the loading spinner
function showLoadingSpinner() {
  document.getElementById("loadingSpinner").classList.add("show");
}

// ========================Function to hide the loading spinner
function hideLoadingSpinner() {
  document.getElementById("loadingSpinner").classList.remove("show");
}

// ============================Function to toggle the sidebar visibility
function toggleSidebar() {
  const sidebar = document.getElementById("sidebar");
  sidebar.classList.toggle("hidden");
}

// ================================Function to toggle the dropdown menu
function toggleDropdown() {
  const dropdown = document.getElementById("dropdown-chevron");
  const chevron = document.getElementById("chevron");
  const isHidden = dropdown.classList.contains("hidden");

  if (isHidden) {
    dropdown.classList.remove("hidden");
    chevron.classList.add("rotate-180");
  } else {
    dropdown.classList.add("hidden");
    chevron.classList.remove("rotate-180");
  }
}

//======================================== Function to select an option from the dropdown
function selectOption(option) {
  const selectedOption = document.getElementById("selected-option");
  selectedOption.textContent = option;
  toggleDropdown();
}

//================================== Function to update the file name display
function updateFileName() {
  const fileInput = document.getElementById("UploadFile");
  const fileNameSpan = document.getElementById("fileName");
  if (fileInput.files.length > 0) {
    fileNameSpan.textContent = fileInput.files[0].name;
  } else {
    fileNameSpan.textContent = "Choose File";
  }
}

// ===================================Function to show the logout confirmation modal
function showModalLogout() {
  document.getElementById("logoutModal").classList.add("show");
}

//============================================= Function to hide the logout confirmation modal
function hideModalLogout() {
  document.getElementById("logoutModal").classList.remove("show");
}

// =======================================Function to perform logout
function performLogout() {
  hideModalLogout();
  showLoadingSpinner();

  const logoutTime = getEstimatedLoadTime();

  setTimeout(() => {
    fetch("../p/logout.php", {
      method: "POST",
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          window.location.replace("../p/L.php");
          console.log("Success Logged Out");
        } else {
          console.error("Logout failed:", data.message || "Unknown error");
        }
      })
      .catch((error) => console.error("Error during logout:", error))
      .finally(() => hideLoadingSpinner());
  }, logoutTime);
}

// ===================================Function to check screen size and adjust sidebar visibility
function checkScreenSize() {
  const sidebar = document.getElementById("sidebar");

  if (window.innerWidth >= 1024) {
    // Ensure the sidebar is visible on larger screens
    sidebar.classList.remove("hidden");
  } else if (!document.body.classList.contains("sidebar-hidden")) {
  }
}

// ======================================Function to initialize the page
function initialize() {
  //========= Get the section from the URL hash, or default to "dashboard"
  const hash = window.location.hash.substring(1);
  const defaultSection = "dashboard"; // Define your default section here
  const activeSection = hash || defaultSection;
  showSection(activeSection);

  checkScreenSize();
}

// ======================================Attach event listeners
window.addEventListener("resize", checkScreenSize);
window.addEventListener("load", initialize);

// ==========================Function to handle sidebar item clicks
function handleSidebarItemClick(event) {
  const sectionId = event.target.getAttribute("data-section");
  if (sectionId) {
    //=================== Update URL hash and show the section
    window.location.hash = sectionId;
    showSection(sectionId);
  }
}

//=============== Add event listeners to sidebar items
document.querySelectorAll(".sidebar-item").forEach((item) => {
  item.addEventListener("click", handleSidebarItemClick);
});
//==================FETCHING FOR THE FIXED DAILY EXPENSES

document.addEventListener("DOMContentLoaded", function () {
  fetch("../p/track_expenses.php")
    .then((response) => response.json())
    .then((data) => {
      if (data.total_amount !== null) {
        const totalAmount = parseFloat(data.total_amount).toFixed(2);

        document.getElementById("total-expenses").textContent = totalAmount;
      }
    })
    .catch((error) => {
      console.error("Error fetching data:", error);
    });
});

function calculatePercentageChange(totalAmount) {
  return totalAmount > 1000 ? 30 : 10;
}

//=============================================Counting Animation for Each Data===
function countUp(elementId, duration, previousValue) {
  const element = document.getElementById(elementId);
  const endValue = parseFloat(element.getAttribute("data-end-value")) || 0; // Ensure a fallback to 0 if data is missing
  const startValue = 0;
  const startTime = performance.now();

  function updateCount(timestamp) {
    const elapsed = timestamp - startTime;
    const progress = Math.min(elapsed / duration, 1);
    const currentValue = progress * (endValue - startValue) + startValue;

    // Create the inner HTML for the total expenses
    element.innerHTML = `
          <div style="display: flex; align-items: center;">
              <img src="../Assets/pesos.png" alt="₱" style="width: 20px; height: auto; vertical-align: middle; margin-right: 5px;" />
              ${currentValue.toLocaleString("en-US", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
              })}
          </div>
      `;

    // Handle percentage change calculation if previous value exists
    let percentageChange = 0;
    if (previousValue) {
      if (previousValue !== 0) {
        percentageChange = ((endValue - previousValue) / previousValue) * 100;
      } else if (endValue > 0) {
        percentageChange = 100; // Full increase from 0
      }
    }

    const percentageChangeElement = document.getElementById(
      `${elementId}-change`
    );
    const changeSymbol = percentageChange > 0 ? "↑" : "↓";
    const changeImage =
      percentageChange > 0
        ? "../Assets/up-arrow.png"
        : "../Assets/down-arrow.png"; // Images for arrows

    // Determine the color and format the percentage display
    let changeColor = "text-green"; // Default to green
    let formattedPercentage = `+ ${Math.abs(percentageChange).toFixed(2)}%`; // Absolute value for display

    if (changeSymbol === "↑") {
      // When arrow is up (indicating decrease)
      changeColor = "text-red"; // Change color to red
      formattedPercentage = `-${Math.abs(percentageChange).toFixed(2)}%`; // Show as negative
    } else if (changeSymbol === "↓") {
      // When arrow is down (indicating increase)
      changeColor = "text-green"; // Change color to green
      formattedPercentage = `${Math.abs(percentageChange).toFixed(2)}%`; // Show as positive
    }

    // Set the percentage change HTML
    percentageChangeElement.innerHTML = `
          <span class="${changeColor}">${formattedPercentage}</span>
          <img src="${changeImage}" alt="${changeSymbol}" class="w-4 h-4 ml-1" />
      `;

    if (progress < 1) {
      requestAnimationFrame(updateCount);
    }
  }

  requestAnimationFrame(updateCount);
}

async function fetchData() {
  try {
    const response = await fetch("../p/track_expenses.php");
    const data = await response.json();

    // Get the previous value (from DB or other source) for comparison
    const previousTotalExpenses = 900; // Replace this with the actual previous data source

    // Set the data-end-value attribute for animated count
    const totalAmount = data.total_amount ? parseFloat(data.total_amount) : 0; // Default to 0 if no data

    document
      .getElementById("total-expenses")
      .setAttribute("data-end-value", totalAmount);

    // Call countUp with the previous value to calculate the change
    countUp("total-expenses", 2000, previousTotalExpenses);
    countUp("dailySales", 2000); // Assuming no comparison for daily sales
    countUp("dailyDebt", 2000); // Assuming no comparison for daily debt
  } catch (error) {
    console.error("Error fetching data:", error);
  }
}

window.onload = fetchData;
