// Show and hide the add membership modal
function showAddMembershipModal() {
  const showElement = document.getElementById("addMemberModal");
  showElement.style.display = "block";
}

function hideAddMembershipModal() {
  const hideElement = document.getElementById("addMemberModal");
  hideElement.style.display = "none";
}

// Handle DOMContentLoaded event
document.addEventListener("DOMContentLoaded", function () {
  const membershipTypeSelect = document.getElementById("membershipType");
  const totalCostElement = document.getElementById("totalCost");
  const totalCostHidden = document.getElementById("totalCostHidden");

  const membershipCosts = {
    "daily-basic": 100,
    "daily-pro": 110,
    "monthly-basic": 1000,
    "monthly-pro": 1100,
  };

  // Update total cost based on membership type selection
  function updateTotalCost() {
    const selectedValue = membershipTypeSelect.value;
    const totalCost = membershipCosts[selectedValue] || 100;

    totalCostElement.innerHTML = `
      <span class="total-cost-container">
        <img src="../Assets/pesos.png" alt="Pesos" class="peso-icon" style="width:28px;height:28px;"/>
        <span class="cost-number" style="font-size:19px;">${totalCost}.00</span>
      </span>`;
    totalCostHidden.value = totalCost;
  }

  membershipTypeSelect.addEventListener("change", updateTotalCost);
  updateTotalCost();
});

// Hide the member form
function hideMemberForm() {
  const formMember = document.getElementById("addMemberModal");
  formMember.style.display = "none";
}

// Handle form submission for adding a member
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("memberForm");

  form.addEventListener("submit", async (event) => {
    event.preventDefault();

    const formData = new FormData(form);

    try {
      const response = await fetch("../p/insert_member.php", {
        method: "POST",
        body: formData,
      });

      const result = await response.text(); // Adjust if expecting JSON
      hideMemberForm();
      showModalAddMember(result);
      console.log("Success MEMBER ADDED");
      setTimeout(function () {
        hideModalAddMember();
      }, 4000);

      form.reset();
    } catch (error) {
      console.error("Error:", error);
      alert("There was an error submitting the form.");
    }
  });
});

// Hide the success modal for adding a member
function hideModalAddMember() {
  const modalSuccessMember = document.getElementById("successModal1");
  modalSuccessMember.style.display = "none";
}

// Show the success modal for adding a member
function showModalAddMember(message) {
  const modal = document.getElementById("successModal1");
  const closeBtn = document.querySelector("#successModal1 .close");
  const progress = document.getElementById("progress");

  modal.style.display = "block";

  const hideModal = () => {
    modal.style.display = "none";
    progress.removeEventListener("animationend", hideModal);
  };

  progress.addEventListener("animationend", hideModal);

  closeBtn.onclick = () => {
    modal.style.display = "none";
    progress.removeEventListener("animationend", hideModal);
  };

  window.onclick = (event) => {
    if (event.target === modal) {
      modal.style.display = "none";
      progress.removeEventListener("animationend", hideModal);
    }
  };
}

// Custom select design
const customSelect = document.querySelector(".custom-select");
const selectElement = customSelect.querySelector("select");

selectElement.addEventListener("focus", () => {
  customSelect.classList.add("open");
});

selectElement.addEventListener("blur", () => {
  customSelect.classList.remove("open");
});

// Show and hide the renewal modal
function showRenewModal(member) {
  const modal = document.getElementById("renewMemberModal");
  modal.style.display = "block";

  document.getElementById("renewFirstName").value = member.first_name;
  document.getElementById("renewLastName").value = member.last_name;
  document.getElementById("renewContactNumber").value = member.contact_number;

  const membershipTypeSelect = document.getElementById("renewMembershipType");
  membershipTypeSelect.value = member.membership_type;

  updateRenewTotalCost();
}

function hideRenewModal() {
  const modal = document.getElementById("renewMemberModal");
  modal.style.display = "none";
}

// Show success modal for renewing a member
function SuccessRenew() {
  const renew = document.getElementById("successModalRenew");
  renew.style.display = "block";
}

// Hide success modal for renewing a member
function HideSuccessRenew() {
  const renew = document.getElementById("successModalRenew");
  renew.style.display = "none";
}

// Update total cost for renewal
document
  .getElementById("renewMembershipType")
  .addEventListener("change", updateRenewTotalCost);

function updateRenewTotalCost() {
  const membershipTypeSelect = document.getElementById("renewMembershipType");
  const totalCostElement = document.getElementById("renewTotalCost");
  const totalCostHidden = document.getElementById("renewTotalCostHidden");

  const membershipCosts = {
    "daily-basic": 100,
    "daily-pro": 110,
    "monthly-basic": 1000,
    "monthly-pro": 1100,
  };

  const selectedValue = membershipTypeSelect.value;
  const totalCost = membershipCosts[selectedValue] || 100;

  totalCostElement.innerHTML = `
    <span class="total-cost-container">
      <img src="../Assets/pesos.png" alt="Pesos" class="peso-icon" style="width:28px;height:28px;"/>
      <span class="cost-number" style="font-size:19px;">${totalCost}.00</span>
    </span>`;
  totalCostHidden.value = totalCost;
}

// Handle form submission for renewing a member
document
  .getElementById("renewMemberForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch("../p/renew_member.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Network response was not ok " + response.statusText);
        }
        return response.json();
      })
      .then((data) => {
        if (data.error) {
          alert("Error: " + data.error);
        } else {
          hideRenewModal();
          SuccessRenew();
          setTimeout(function () {
            HideSuccessRenew();
          }, 4000);
        }
      })
      .catch((error) => console.error("Error:", error));
  });
