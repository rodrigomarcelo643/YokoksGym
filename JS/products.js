// Function to show the AddProduct modal
function AddProduct() {
  const productElement = document.getElementById("AddProduct");
  productElement.style.display = "block";
  // Force transition
  void productElement.offsetWidth;
  productElement.classList.add("show");
}

// Function to close the AddProduct modal
function CloseProduct() {
  const productElement = document.getElementById("AddProduct");
  productElement.classList.remove("show");

  // Remove transition and hide the modal
  productElement.addEventListener("transitionend", function handler() {
    if (!productElement.classList.contains("show")) {
      productElement.style.display = "none";
      productElement.removeEventListener("transitionend", handler);
    }
  });
}

// Form Submission of Product
document
  .getElementById("productForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    let formData = new FormData(this);

    fetch("../p/submit_product.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.text())
      .then((result) => {
        showModal(result);
        document.getElementById("productForm").reset();
        CloseProduct();
        console.log("success");
      })
      .catch((error) => console.error("Error:", error));
    console.log("error");
  });

// Function to show a modal with a message
function showModal(message) {
  const modal = document.getElementById("successModal");
  const closeBtn = document.querySelector(".modal .close");

  // Set the message
  document.querySelector(".modal-content p").textContent = message;

  // Show the modal
  modal.style.display = "block";

  // Hide the modal after the progress bar completes its transition
  const progress = document.getElementById("progress");
  const handler = function () {
    modal.style.display = "none";
    progress.removeEventListener("animationend", handler);
  };
  progress.addEventListener("animationend", handler);

  // Close modal when the user clicks on <span> (x)
  closeBtn.onclick = function () {
    modal.style.display = "none";
    progress.removeEventListener("animationend", handler);
  };

  // Close modal when the user clicks anywhere outside of the modal
  window.onclick = function (event) {
    if (event.target === modal) {
      modal.style.display = "none";
      progress.removeEventListener("animationend", handler);
    }
  };
}

// Search Handling
document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.querySelector('input[name="search"]');
  const tableBody = document.querySelector("tbody");

  function fetchProducts(query = "") {
    fetch(`../p/search_product.php?search=${encodeURIComponent(query)}`)
      .then((response) => response.json())
      .then((data) => {
        tableBody.innerHTML = "";
        if (data.length > 0) {
          data.forEach((product) => {
            const stockText =
              product.Stocks > 0 ? product.Stocks : "Out of Stock";
            const stockStyle = product.Stocks > 0 ? "" : "color: red;";

            const row = document.createElement("tr");
            row.innerHTML = `
                     
                        <td class="" data-label="Product ID">${highlight(
                          product.ProductId,
                          query
                        )}</td>
                        <td class=" " data-label="Name">${highlight(
                          product.ProductName,
                          query
                        )}</td>
                        <td class="p-3 " data-label="Units">${highlight(
                          product.ProductUnits,
                          query
                        )}</td>
                        <td class="p-3 " data-label="Price">${
                          product.Price
                        }</td>
                        <td class="p-3 " data-label="Stocks">
                            <span style="${stockStyle}">${stockText}</span>
                        </td>
                        <td class="p-3 " data-label="Type">${
                          product.ProductType
                        }</td>
                        <td class="p-3 flex gap-2 relative" data-label="Actions">
                            <button class="Btn edit" data-id="${product.id}">
                                <svg class="svg" viewBox="0 0 512 512">
                                    <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path>
                                </svg>
                            </button>
                            <button class="button delete" style="margin-top:0px;" data-id="${
                              product.id
                            }">
                                <svg viewBox="0 0 448 512" class="svgIcon">
                                    <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                                </svg>
                            </button>
                        </td>
                    `;
            tableBody.appendChild(row);
          });

          document.querySelectorAll(".edit").forEach((button) => {
            button.addEventListener("click", handleEditClick);
          });
          document.querySelectorAll(".delete").forEach((button) => {
            button.addEventListener("click", handleDeleteClick);
          });
          document.querySelectorAll(".action-button1").forEach((button) => {
            button.addEventListener("click", function () {
              const actionMenu = this.nextElementSibling;
              actionMenu.classList.toggle("hidden");
            });
          });
        } else {
          tableBody.innerHTML =
            '<tr><td colspan="8" class="text-center text-gray-600">No products found.</td></tr>';
        }
      })
      .catch((error) => console.error("Error fetching products:", error));
  }

  searchInput.addEventListener("input", function () {
    const query = searchInput.value;
    fetchProducts(query);
  });

  fetchProducts();

  function highlight(text, query) {
    if (!query.trim()) return text;
    const regex = new RegExp(`(${query})`, "ig");
    return text.replace(regex, '<span class="highlight">$1</span>');
  }

  function handleEditClick(event) {
    event.preventDefault();
    const productId = this.dataset.id;

    fetch(`../p/get_product.php?id=${productId}`)
      .then((response) => response.json())
      .then((product) => {
        if (product.error) {
          Swal.fire("Error", product.error, "error");
          return;
        }

        // Create a new form with initial stock value and no reason field
        Swal.fire({
          title: "",
          html: `
                <form id="editProductForm" method="POST">
                    <input type="hidden" name="id" value="${product.id}">
                    <div class="form-group">
                        <label for="productName">Name</label>
                        <input type="text" id="productName" name="ProductName" value="${product.ProductName}" class="swal2-input">
                    </div>
                    <div class="form-group">
                        <label for="Units">Units</label>
                        <input type="text" id="productUnits" name="Units" value="${product.ProductUnits}" class="swal2-input">
                    </div>
                    <div class="form-group">
                        <label for="productId">Product ID</label>
                        <input type="text" id="productId" name="ProductId" value="${product.ProductId}" class="swal2-input">
                    </div>
                    <div class="form-group">
                        <label for="productPrice">Price</label>
                        <input type="number" id="productPrice" name="Price" value="${product.Price}" class="swal2-input">
                    </div>
                    <div class="form-group">
                        <label for="productStocks">Stocks</label>
                        <input type="number" id="productStocks" name="Stocks" value="${product.Stocks}" class="swal2-input">
                    </div>
                    <div id="stockReasonContainer" class="form-group hidden">
                        <label for="stockReason">Reason for Stock Edit</label>
                        <textarea id="stockReason" name="stockReason" class="swal2-textarea" placeholder="Enter the reason for editing stocks"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="productType">Type</label>
                        <input type="text" id="productType" name="ProductType" value="${product.ProductType}" class="swal2-input">
                    </div>
                </form>
            `,
          showCancelButton: true,
          confirmButtonText: "Save",
          cancelButtonText: "Cancel",
          didOpen: () => {
            const form = document.getElementById("editProductForm");
            const originalStocks = parseInt(product.Stocks, 10);
            const stockInput = document.getElementById("productStocks");
            const stockReasonContainer = document.getElementById(
              "stockReasonContainer"
            );

            stockInput.addEventListener("input", () => {
              const currentStocks = parseInt(stockInput.value, 10);
              if (currentStocks !== originalStocks) {
                stockReasonContainer.classList.remove("hidden");
              } else {
                stockReasonContainer.classList.add("hidden");
              }
            });
          },
          preConfirm: () => {
            const formData = new FormData(
              document.getElementById("editProductForm")
            );
            return fetch("../p/update_product.php", {
              method: "POST",
              body: formData,
            })
              .then((response) => response.json())
              .then((result) => {
                if (result.success) {
                  Swal.fire({
                    title: "Success",
                    text: "Product is Updated.",
                    imageUrl: "../Assets/success_message.png",
                    imageWidth: 66,
                    imageHeight: 66,
                    imageAlt: "Custom success image",
                    customClass: {
                      container: "custom-swal-container",
                    },
                  }).then(() => fetchProducts());
                } else {
                  Swal.fire("Error", result.error, "error");
                }
              })
              .catch((error) => {
                Swal.fire(
                  "Error",
                  "An error occurred while updating the product.",
                  "error"
                );
                console.error("Fetch error:", error);
              });
          },
        });
      })
      .catch((error) => {
        Swal.fire(
          "Error",
          "An error occurred while fetching product data.",
          "error"
        );
        console.error("Fetch error:", error);
      });
  }

  function handleDeleteClick(event) {
    event.preventDefault();
    const productId = this.dataset.id;

    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel!",
    }).then((result) => {
      if (result.isConfirmed) {
        fetch(`../p/delete_product.php?id=${productId}`, {
          method: "DELETE",
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              Swal.fire("Deleted!", "The product has been deleted.", "success");
              fetchProducts(); // Refresh the product list
            } else {
              Swal.fire("Error", data.error, "error");
            }
          })
          .catch((error) => {
            console.error("Error:", error);
            Swal.fire(
              "Error!",
              "There was an issue deleting the product.",
              "error"
            );
          });
      }
    });
  }
});
//===============Summary of products Coutn

document.addEventListener("DOMContentLoaded", function () {
  const chevron = document.querySelector(".chevron");
  const dropdownMenu = document.querySelector(".dropdown-menu");

  chevron.addEventListener("click", function () {
    dropdownMenu.classList.toggle("show");
  });

  document.addEventListener("click", function (event) {
    if (
      !chevron.contains(event.target) &&
      !dropdownMenu.contains(event.target)
    ) {
      dropdownMenu.classList.remove("show");
    }
  });
});
function closeEditDelete(event) {
  const actionMenu = event.target.closest(".action-menu1");
  if (actionMenu) {
    actionMenu.classList.add("hidden");
  }
}
function updateFile() {
  const fileInput = document.getElementById("UploadFile");
  const fileDisplay = document.getElementById("showFile");
  const file = fileInput.files[0];

  if (file) {
    // Clear previous content
    fileDisplay.innerHTML = "";

    // Display image if file is an image
    if (file.type.startsWith("image/")) {
      const img = document.createElement("img");
      img.src = URL.createObjectURL(file);
      img.onload = () => URL.revokeObjectURL(img.src); // Clean up memory
      fileDisplay.appendChild(img);
    } else {
      fileDisplay.textContent = file.name; // Display file name
    }
  } else {
    fileDisplay.textContent = "No file chosen";
  }
}

// Event listener to hide action menu when clicking outside
function setupClickOutsideListener() {
  document.addEventListener("click", function (event) {
    if (
      !event.target.closest(".action-menu1") &&
      !event.target.closest(".action-button1")
    ) {
      document.querySelectorAll(".action-menu1").forEach((menu) => {
        menu.classList.add("hidden");
      });
    }
  });
}

//========================QUANTITY FOR THE ADD ITEMS MODAL=====
