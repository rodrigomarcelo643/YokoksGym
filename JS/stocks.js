document.addEventListener("DOMContentLoaded", function () {
  // Initialize the stock history chart
  fetch("fetch_stock_history.php")
    .then((response) => response.json())
    .then((data) => {
      const labels = data.map((entry) =>
        new Date(entry.change_date).toLocaleDateString()
      );
      const changeAmounts = data.map((entry) => entry.change_amount);
      console.log("Chart Has been Displayed ");
      const ctx = document.getElementById("stockHistoryChart").getContext("2d");
      new Chart(ctx, {
        type: "line",
        data: {
          labels: labels,
          datasets: [
            {
              label: "Edited Products",
              data: changeAmounts,
              borderColor: "green",
              backgroundColor: "rgba(75, 192, 192, 0.2)",
              fill: true,
              tension: 0.3,
            },
          ],
        },
        options: {
          responsive: true,
          scales: {
            x: {
              title: {
                display: true,
                text: "Date",
              },
            },
            y: {
              title: {
                display: true,
                text: "No of Productss",
              },
            },
          },
        },
      });
    })
    .catch((error) => console.error("Error fetching stock history:", error));

  //========================== Viewing Modal Stocks History Being Edited
  document
    .getElementById("viewStockHistory")
    .addEventListener("click", function () {
      fetch("../p/fetch_stock_history.php")
        .then((response) => response.json())
        .then((data) => {
          const historyContainer = document.getElementById("historyContainer");
          historyContainer.innerHTML = ""; // Clear previous content

          data.forEach((entry) => {
            const date = new Date(entry.change_date);
            const historyItem = document.createElement("div");
            historyItem.classList.add("history-item");
            historyItem.innerHTML = `
                <div class="item-h">
                <strong>Product Name:</strong> ${entry.product_name} <br>
                </div>
                <div class="item-h">
                <strong>Change Amount:</strong> ${entry.change_amount} <br>
                     </div>
                 <div class="item-h">
                 
                <strong>Reason:</strong> ${entry.reason} <br>
                     </div>
                 <div class="item-h">
                <strong>Date:</strong> ${date.toLocaleDateString()}<br>
                     </div>
                 <div class="item-h">
                <strong>Time: </strong>  ${date.toLocaleTimeString()}<br>
                     </div>
            `;
            historyContainer.appendChild(historyItem);

            //Debugging Sa success Nga pag Show sa history
            console.log("The Edit History Has been Showed");
          });

          document.getElementById("stockHistoryModal").style.display = "block";
        })
        .catch((error) =>
          console.error("Error fetching stock history for modal:", error)
        );
    });

  // Close modal functionality
  document.querySelector(".close").addEventListener("click", function () {
    document.getElementById("stockHistoryModal").style.display = "none";
  });

  window.onclick = function (event) {
    if (event.target === document.getElementById("stockHistoryModal")) {
      document.getElementById("stockHistoryModal").style.display = "none";
      console.log(" SUCCESSFULLY HIDE THE EDIT HISTORY MODAL ===========");
    }
  };
});
