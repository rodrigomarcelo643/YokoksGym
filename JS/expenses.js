function backHistory() {
  document.getElementById("infoBox").classList.remove("hidden");
  document.getElementById("expenseFormContainer").classList.add("hidden");
}

document.addEventListener("DOMContentLoaded", (event) => {
  const expenseForm = document.getElementById("expenseForm");
  const modalexpenseForm = document.getElementById("modal-expenses");

  expenseForm.addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = new FormData(expenseForm);

    fetch("../p/add_expense.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.text())
      .then((data) => {
        if (data.includes("success")) {
          modalexpenseForm.style.display = "none";
          ShowSuccessExpenses();
          setTimeout(() => {
            HideSuccessExpenses();
          }, 4000);
          expenseForm.reset(); // Reset the form after successful submission
          loadChart();
        } else {
          console.error("Error adding expense:", data);
          alert("Error adding expense: " + data); // Include the error message
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("An error occurred while adding the expense.");
      });
  });
  let chart;

  function createGradient(ctx, value, maxValue) {
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    const ratio = value / maxValue;

    if (ratio > 0.75) {
      gradient.addColorStop(0, "red");
      gradient.addColorStop(1, "rgba(255, 0, 0, 0.5)");
    } else if (ratio > 0.25) {
      gradient.addColorStop(0, "rgba(255, 165, 0, 1)");
      gradient.addColorStop(1, "rgba(255, 165, 0, 0.5)");
    } else {
      gradient.addColorStop(0, "#009b7b");
      gradient.addColorStop(1, "rgba(0, 155, 123, 0.5)");
    }

    return gradient;
  }

  function loadChart() {
    fetch("../p/get_expenses.php")
      .then((response) => response.json())
      .then((data) => {
        console.log(data); // Debug: Check data format

        if (Array.isArray(data)) {
          const labels = data.map((item) => item.date);
          const amounts = data.map((item) => parseFloat(item.total_amount));

          const ctx = document
            .getElementById("chartContainer-expenses")
            .getContext("2d");

          const chartConfig = {
            type: "bar",
            data: {
              labels: labels,
              datasets: [
                {
                  label: "Daily Expenses",
                  data: amounts,
                  backgroundColor: amounts.map((amount) =>
                    createGradient(ctx, amount, Math.max(...amounts))
                  ),
                  borderColor: "transparent",
                  borderWidth: 0,
                  borderRadius: 6,
                },
              ],
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              scales: {
                y: {
                  beginAtZero: true,
                },
              },
              plugins: {
                title: {
                  display: true,
                  text: `Last Updated: ${new Date().toLocaleString()}`, // Display last updated time
                },
                tooltip: {
                  callbacks: {
                    label: function (context) {
                      let label = context.dataset.label || "";
                      if (label) {
                        label += ": ";
                      }
                      if (context.parsed.y !== null) {
                        label += context.parsed.y.toFixed(2); // Format amount
                      }
                      return label;
                    },
                  },
                },
                legend: {
                  display: true,
                },
              },
              layout: {
                padding: 20,
              },
            },
          };

          // Create or update the chart instance
          if (chart) {
            chart.data.labels = labels;
            chart.data.datasets[0].data = amounts;
            chart.update();
          } else {
            chart = new Chart(ctx, chartConfig);
          }
        } else {
          console.error("Unexpected data format:", data);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  }

  // Load chart on page load
  loadChart();
  // Show success function
  function ShowSuccessExpenses() {
    const successExpense = document.getElementById("successModalAddedExpenses");
    successExpense.style.display = "block";
  }

  function HideSuccessExpenses() {
    const successExpense = document.getElementById("successModalAddedExpenses");
    successExpense.style.display = "none";
  }

  // Fetch total expenses count
  fetch("all_expenses.php")
    .then((response) => response.json())
    .then((data) => {
      const totalExpenses = data.total_amount;
      const formattedAmount = parseFloat(totalExpenses).toFixed(2);
      // Set the data-end-value attribute for the countUp function
      const element = document.getElementById("total-expenses-all");
      element.setAttribute("data-end-value", formattedAmount);
      countUp("total-expenses-all", 2000); // Adjust duration as needed
    })
    .catch((error) => {
      console.error("Error fetching total expenses:", error);
    });

  function countUp(elementId, duration) {
    const element = document.getElementById(elementId);
    const endValue = parseFloat(element.getAttribute("data-end-value"));
    const startValue = 0;
    const startTime = performance.now();

    function updateCount(timestamp) {
      const elapsed = timestamp - startTime;
      const progress = Math.min(elapsed / duration, 1);
      const currentValue = Math.floor(
        progress * (endValue - startValue) + startValue
      );
      element.textContent = currentValue.toLocaleString("en-US", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      });

      if (progress < 1) {
        requestAnimationFrame(updateCount);
      }
    }

    requestAnimationFrame(updateCount);
  }

  // Fetch today's members and expenses
  fetch("../p/fetch_today_members.php")
    .then((response) => response.json())
    .then((data) => {
      // Fetch member count from the response
      const memberCount =
        data.length > 0 && data[0].count ? parseInt(data[0].count) : 0;

      // Display member count directly in the DOM
      document.getElementById("daily-members-text").textContent = memberCount;

      // Counting animation for total members using CountUp.js
      const countUp = new CountUp("daily-members-text", 0, memberCount, 0, 2);
      if (!countUp.error) {
        countUp.start(); // Start the counting animation
      } else {
        console.error(countUp.error); // Handle CountUp.js errors
      }

      // Calculate and display percentage change for daily members
      const previousMemberCount = 50; // Replace with actual previous member count from your data source
      let memberPercentageChange = 0;

      if (previousMemberCount !== undefined && memberCount !== undefined) {
        if (previousMemberCount === 0 && memberCount > 0) {
          memberPercentageChange = 100; // Full increase from 0
        } else if (previousMemberCount === 0 && memberCount === 0) {
          memberPercentageChange = 0; // Both previous and current counts are 0
        } else {
          memberPercentageChange =
            ((memberCount - previousMemberCount) / previousMemberCount) * 100;
        }
      }

      const memberChangeElement = document.getElementById(
        "daily-members-change"
      );
      const memberChangeSymbol = memberPercentageChange > 0 ? "↑" : "↓";
      const memberChangeImage =
        memberPercentageChange > 0
          ? "../Assets/up-arrow.png"
          : "../Assets/down-arrow.png"; // Images for arrows

      // Determine the color and format the percentage display
      let memberChangeColor =
        memberPercentageChange > 0 ? "text-green" : "text-red "; // Change color based on increase or decrease
      let memberFormattedPercentage = `${Math.abs(
        memberPercentageChange
      ).toFixed(2)}%`; // Absolute value for display

      if (
        memberChangeSymbol === "↓" &&
        memberCount === 0 &&
        previousMemberCount === 0
      ) {
        memberFormattedPercentage = "0%"; // Show 0% if both are 0
      }

      if (memberChangeSymbol === "↑" && memberCount > 0) {
        memberFormattedPercentage = `+${memberFormattedPercentage}`; // Show positive percentage for increase
      } else {
        memberFormattedPercentage = `-${memberFormattedPercentage}`; // Show negative percentage for decrease
      }

      // Set the percentage change HTML for daily members
      memberChangeElement.innerHTML = `
    <span class="${memberChangeColor}">${memberFormattedPercentage}</span>
    <img src="${memberChangeImage}" alt="${memberChangeSymbol}" class="w-4 h-4 ml-1" />
  `;
    })
    .catch((error) => {
      console.error("Error fetching member data:", error); // Handle fetch errors
    });

  // Fetch today's renewed members
  fetch("../p/renewed_select.php") // Ensure this PHP script returns today's renewed members count
    .then((response) => response.json())
    .then((data) => {
      if (data.today_sales !== undefined) {
        const todayRenewedMembers = data.today_sales;

        // Display renewed members count directly in the DOM
        document.getElementById("today-renewed-members-text").textContent =
          todayRenewedMembers;

        // Counting animation for today's renewed members
        const countUpRenewed = new CountUp(
          "today-renewed-members-text",
          0,
          todayRenewedMembers,
          0,
          2
        );
        countUpRenewed.start();

        // Calculate and display percentage change for renewed members
        const previousRenewedMembers = 20; // Replace with actual previous renewed count from your data source
        let renewedPercentageChange = 0;

        if (
          previousRenewedMembers !== undefined &&
          todayRenewedMembers !== undefined
        ) {
          if (previousRenewedMembers === 0 && todayRenewedMembers > 0) {
            renewedPercentageChange = 100; // Full increase from 0
          } else if (
            previousRenewedMembers === 0 &&
            todayRenewedMembers === 0
          ) {
            renewedPercentageChange = 0; // Both previous and current counts are 0
          } else {
            renewedPercentageChange =
              ((todayRenewedMembers - previousRenewedMembers) /
                previousRenewedMembers) *
              100;
          }
        }

        const renewedChangeElement = document.getElementById(
          "renewed-members-change"
        );
        const renewedChangeSymbol = renewedPercentageChange > 0 ? "↑" : "↓";
        const renewedChangeImage =
          renewedPercentageChange > 0
            ? "../Assets/up-arrow.png"
            : "../Assets/down-arrow.png"; // Images for arrows

        // Determine the color and format the percentage display
        let renewedChangeColor =
          renewedPercentageChange > 0 ? "text-green" : "text-red"; // Change color based on increase or decrease
        let renewedFormattedPercentage = `${Math.abs(
          renewedPercentageChange
        ).toFixed(2)}%`; // Absolute value for display

        if (
          renewedChangeSymbol === "↓" &&
          todayRenewedMembers === 0 &&
          previousRenewedMembers === 0
        ) {
          renewedFormattedPercentage = "0%"; // Show 0% if both are 0
        }

        if (renewedChangeSymbol === "↑" && todayRenewedMembers > 0) {
          renewedFormattedPercentage = `+${renewedFormattedPercentage}`; // Show positive percentage for increase
        } else {
          renewedFormattedPercentage = `-${renewedFormattedPercentage}`; // Show negative percentage for decrease
        }

        // Set the percentage change HTML for renewed members
        renewedChangeElement.innerHTML = `
      <span class="${renewedChangeColor}">${renewedFormattedPercentage}</span>
      <img src="${renewedChangeImage}" alt="${renewedChangeSymbol}" class="w-4 h-4 ml-1" />
    `;
      } else {
        console.error("Error fetching data:", data.error);
      }
    })
    .catch((error) => {
      console.error("Error fetching renewed member data:", error); // Handle fetch errors
    });
});
let allExpenses = []; // This will hold the full list of expenses
let currentPage = 1; // Start at page 1
const itemsPerPage = 10; // Number of items per page

// Fetch and load expenses
function loadExpenses() {
  fetch("../p/get_expenses_list.php")
    .then((response) => response.json())
    .then((data) => {
      allExpenses = data;
      applyFilters(); // Apply filters and pagination
    })
    .catch((error) => console.error("Error loading expenses:", error));
}

// Filter and apply pagination to the table
function applyFilters() {
  const selectedDate = document.getElementById("startDate").value;
  const staffName = document
    .getElementById("staffDropdown")
    .value.toLowerCase();
  const searchQuery = document
    .getElementById("searchInput")
    .value.toLowerCase();

  // Filter expenses based on the filters
  let filteredExpenses = allExpenses;

  if (selectedDate) {
    filteredExpenses = filteredExpenses.filter(
      (expense) =>
        new Date(expense.date).toLocaleDateString() ===
        new Date(selectedDate).toLocaleDateString()
    );
  }

  if (staffName) {
    filteredExpenses = filteredExpenses.filter((expense) =>
      (expense.full_name || "").toLowerCase().includes(staffName)
    );
  }

  if (searchQuery) {
    filteredExpenses = filteredExpenses.filter((expense) =>
      (expense.description || "").toLowerCase().includes(searchQuery)
    );
  }

  paginateExpenses(filteredExpenses);
}

// Pagination logic
function paginateExpenses(expenses) {
  const startIndex = (currentPage - 1) * itemsPerPage;
  const endIndex = startIndex + itemsPerPage;
  const paginatedExpenses = expenses.slice(startIndex, endIndex);

  // Update the table
  const tableBody = document.querySelector("#expenseTable tbody");
  tableBody.innerHTML = "";

  if (paginatedExpenses.length > 0) {
    paginatedExpenses.forEach((expense) => {
      const row = document.createElement("tr");
      row.innerHTML = `
                <td class="border border-gray-300 px-4 py-2">${
                  expense.date
                }</td>
                <td class="border border-gray-300 px-4 py-2">${
                  expense.image
                    ? `<img src="${expense.image}" alt="Expense Image" class="h-12 w-12" style="max-width:50px; max-height:50px;"/>`
                    : "No Image"
                }</td>
                <td class="border border-gray-300 px-4 py-2">${
                  expense.description
                }</td>
                <td class="border border-gray-300 px-4 py-2">${
                  expense.type
                }</td>
                <td class="border border-gray-300 px-4 py-2">${
                  expense.supplier || "N/A"
                }</td>
                <td  style="white-space:nowrap!important" class="border border-gray-300 px-4 py-2">₱   ${parseFloat(
                  expense.amount
                ).toFixed(2)}</td>
                <td class="border border-gray-300 px-4 py-2">${
                  expense.full_name
                }</td>
                <td class="border border-gray-300 px-4 py-2">
                    <div class="flex">
                      <img src="../Assets/view_expense.png" style='cursor:pointer; margin-right:6px; width:40px; height:40px;' onclick="ViewDetails(${JSON.stringify(
                        expense
                      ).replace(/"/g, "&quot;")})">
                        <img src="../Assets/delete_icon.png" style="cursor:pointer;width:35px; height:35px;" onclick="deleteExpense(${
                          expense.id
                        })" class="text-red-600 hover:text-red-800"></img>
                    </div>
                </td>`;
      tableBody.appendChild(row);
    });
  } else {
    const row = document.createElement("tr");
    row.innerHTML = `<td colspan="8" class="border border-gray-300 px-4 py-2 text-center">No expenses found.</td>`;
    tableBody.appendChild(row);
  }

  updatePaginationControls(expenses.length);
}

// Update pagination controls (page numbers, back/next buttons)
function updatePaginationControls(totalItems) {
  const totalPages = Math.ceil(totalItems / itemsPerPage);
  const paginationNumbers = document.getElementById("paginationNumbers");
  paginationNumbers.innerHTML = "";

  // Generate page numbers
  for (let i = 1; i <= totalPages; i++) {
    const pageButton = document.createElement("button");
    pageButton.innerText = i;
    pageButton.classList.add("page-btn");
    pageButton.style =
      i === currentPage
        ? "font-weight:bold; background-color:#009B7B;color:white;"
        : "background-color:white;border:1px solid #CACACA;color:#646464";
    pageButton.onclick = () => {
      currentPage = i;
      applyFilters();
    };
    paginationNumbers.appendChild(pageButton);
  }

  // Show/hide buttons based on the current page
  document.getElementById("prevBtn").disabled = currentPage === 1;
  document.getElementById("nextBtn").disabled = currentPage === totalPages;

  // Update the range info (e.g., "1-10 of 50")
  const rangeInfo = document.getElementById("rangeInfo");
  const start = (currentPage - 1) * itemsPerPage + 1;
  const end = Math.min(currentPage * itemsPerPage, totalItems);
  rangeInfo.innerText = `${start}-${end} of ${totalItems} Results`;
}

// Change page (Back/Next buttons)
function changePage(delta) {
  currentPage += delta;
  applyFilters();
}

// Clear filters and reload all expenses
function clearFilters() {
  document.getElementById("startDate").value = "";
  document.getElementById("staffDropdown").value = "";
  document.getElementById("searchInput").value = "";
  loadExpenses();
}

// Initialize expenses on page load
window.onload = loadExpenses;


// Function to open the password verification modal
function openVerifyPasswordModal(id) {
  // Store the expense ID in a variable accessible in confirmDelete
  window.expenseToDelete = id;
  document.getElementById("modal-verify-password").style.display = "block";
  document.getElementById("error-message").style.display = "none"; // Hide error message initially
}

// Function to close the password verification modal
function closeVerifyModal() {
  document.getElementById("modal-verify-password").style.display = "none";
  document.getElementById("verification-password").value = ""; // Clear the password field
  document.getElementById("error-message").style.display = "none"; // Hide error message
}

// Function to confirm deletion after verifying the password
function confirmDelete() {
  const password = document.getElementById("verification-password").value;
  if (password) {
    // Verify the password first
    fetch(`../p/verify_delete_expense.php`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ password }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          // If password is correct, directly delete the expense
          fetch(`../p/delete_expense.php?id=${window.expenseToDelete}`, {
            method: "POST", // Change to POST
          })
            .then((response) => response.json())
            .then((data) => {
              if (data.success) {
                alert("Expense deleted successfully.");
                loadExpenses(); // Refresh the expense list
                closeVerifyModal(); // Close the verification modal
              } else {
                alert("Error deleting expense: " + data.message);
              }
            })
            .catch((error) => {
              console.error("Error deleting expense:", error);
              alert("An error occurred while deleting the expense.");
            });
        } else {
          // Show error message below the input
          document.getElementById("error-message").style.display = "block";
        }
      })
      .catch((error) => {
        console.error("Error verifying password:", error);
      });
  }
}

// Function to trigger the deletion process
function deleteExpense(id) {
  openVerifyPasswordModal(id);
}

// Load expenses on page load
document.addEventListener("DOMContentLoaded", loadExpenses);

//================View EXPENSE DETAILS =========
function ViewDetails(expense) {
  // Populate modal fields with expense details
  document.getElementById("modalTitle").innerText = expense.description;
  document.getElementById("modalDate").innerText = `Date: ${expense.date}`;
  document.getElementById("modalType").innerText = `Type: ${expense.type}`;
  document.getElementById("modalSupplier").innerText = `Supplier: ${
    expense.supplier || "N/A"
  }`;
  document.getElementById("modalAmount").innerText = `Amount: ₱ ${parseFloat(
    expense.amount
  ).toFixed(2)}`;

  // Check if an image exists
  if (expense.image) {
    document.getElementById("modalImage").src = expense.image;
    document.getElementById("modalImage").style.display = "block"; // Show image
  } else {
    document.getElementById("modalImage").style.display = "none"; // Hide image if not available
  }

  // Show the modal
  document.getElementById("modal-view-expense1").style.display = "block";
}

function closeModal() {
  document.getElementById("modal-view-expense1").style.display = "none";
}

//============Load daily expenses data
