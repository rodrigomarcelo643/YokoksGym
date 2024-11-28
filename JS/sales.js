// Function to animate the counting up of the sales total
function animateValue(id, start, end, duration) {
  let startTimestamp = null;

  const step = (timestamp) => {
    if (!startTimestamp) startTimestamp = timestamp;
    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
    // Calculate the current value based on progress
    const currentValue = Math.floor(progress * (end - start) + start);
    document.getElementById(id).innerText = currentValue.toFixed(2); // Update the displayed value
    if (progress < 1) {
      window.requestAnimationFrame(step); // Continue the animation
    }
  };

  window.requestAnimationFrame(step);
}

// Fetch the total sales amount
fetch("../p/get_total_sales.php")
  .then((response) => response.json())
  .then((data) => {
    if (data.success) {
      const totalSales = data.total_sales;
      // Animate counting up to the total sales value
      animateValue("dailySale", 0, totalSales, 2000); // Duration in milliseconds
    } else {
      console.error(data.message); // Handle error
    }
  })
  .catch((error) => console.error("Error fetching total sales:", error));

//========================GET TOTAL DEBT ==================================
// Function to animate the counting up of the debt total
function animateValue(id, start, end, duration) {
  let startTimestamp = null;

  const step = (timestamp) => {
    if (!startTimestamp) startTimestamp = timestamp;
    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
    // Calculate the current value based on progress
    const currentValue = Math.floor(progress * (end - start) + start);
    document.getElementById(id).innerText = currentValue.toFixed(2); // Update the displayed value
    if (progress < 1) {
      window.requestAnimationFrame(step); // Continue the animation
    }
  };

  window.requestAnimationFrame(step);
}

// Fetch the total debt amount
fetch("../p/get_total_debt.php")
  .then((response) => response.json())
  .then((data) => {
    if (data.success) {
      const totalDebt = data.total_debt;
      // Animate counting up to the total debt value
      animateValue("dailyDebt", 0, totalDebt, 2000); // Duration in milliseconds
    } else {
      console.error(data.message); // Handle error
    }
  })
  .catch((error) => console.error("Error fetching total debt:", error));

//==========Daily Gross Sales=========
document.addEventListener("DOMContentLoaded", function () {
  fetch("../p/getSalesData.php") // Ensure the correct path to your PHP file
    .then((response) => response.json())
    .then((data) => {
      // Update the HTML elements with the data
      document.getElementById("daily-gross-sales").innerText = data.gross_sales;
      document.getElementById("daily-sales-reports").innerText =
        data.daily_sales;
    })
    .catch((error) => console.error("Error fetching sales data:", error));
});

//========
document.addEventListener("DOMContentLoaded", function () {
  fetch("../p/getNetData.php") // Ensure the correct path to your PHP file
    .then((response) => response.json())
    .then((data) => {
      // Update the HTML elements with the data
      document.getElementById("daily-sales-reports").innerText =
        data.net_daily_sales;
    })
    .catch((error) => console.error("Error fetching sales data:", error));
});

//=======Membership total Report ====
function loadDailyMembershipCost() {
  fetch("../p/membership_report.php") // Adjust this path to your PHP file
    .then((response) => response.json())
    .then((data) => {
      const dailyMembershipReport = document.getElementById(
        "daily-members-report"
      );
      if (data.total_daily_cost) {
        dailyMembershipReport.textContent = `${parseFloat(
          data.total_daily_cost
        ).toFixed(2)}`;
      } else {
        dailyMembershipReport.textContent = "0.00";
      }
    })
    .catch((error) => {
      console.error("Error fetching daily membership cost:", error);
    });
}

// Call this function when the page loads
window.onload = loadDailyMembershipCost;
