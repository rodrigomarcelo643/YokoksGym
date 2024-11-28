function showProfileDetails() {
  document.getElementById("default-view").style.display = "none";
  document.getElementById("profile-details-view").style.display = "block";
  document.getElementById("account-info-view").style.display = "none";
  document.getElementById("change-password-view").style.display = "none";
}

function showAccountInfo() {
  document.getElementById("default-view").style.display = "none";
  document.getElementById("profile-details-view").style.display = "none";
  document.getElementById("account-info-view").style.display = "block";
  document.getElementById("change-password-view").style.display = "none";
}

function showChangePassword() {
  document.getElementById("default-view").style.display = "none";
  document.getElementById("profile-details-view").style.display = "none";
  document.getElementById("account-info-view").style.display = "none";
  document.getElementById("change-password-view").style.display = "block";
}

function showDefaultView() {
  document.getElementById("default-view").style.display = "block";
  document.getElementById("profile-details-view").style.display = "none";
  document.getElementById("account-info-view").style.display = "none";
  document.getElementById("change-password-view").style.display = "none";
}

function HideSettings() {
  document.getElementById("ShowSettings").style.display = "none";
}

//==========Chaning password
document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("change-password-form")
    .addEventListener("submit", function (event) {
      event.preventDefault();

      const formData = new FormData(this);

      fetch("change_password.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          const messageDiv = document.getElementById("change-password-message");
          messageDiv.textContent = data.message;
          if (data.status === "success") {
            messageDiv.style.color = "green";
            this.reset();
          } else {
            messageDiv.style.color = "red";
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          const messageDiv = document.getElementById("change-password-message");
          messageDiv.textContent = "An unexpected error occurred.";
          messageDiv.style.color = "red";
        });
    });
});

//=========Profile Update
function previewImage(event) {
  const reader = new FileReader();
  reader.onload = function () {
    const output = document.getElementById("profile-img");
    output.src = reader.result;
  };
  reader.readAsDataURL(event.target.files[0]);
}

document
  .getElementById("profile-edit-form")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch("update_profile.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        const messagesDiv = document.getElementById("form-messages");
        messagesDiv.textContent = "";
        if (data.status === "success") {
          messagesDiv.style.color = "green";
          messagesDiv.textContent = data.message;
        } else {
          messagesDiv.style.color = "red";
          messagesDiv.textContent = data.message;
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  });
