document
  .getElementById("loginForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    var submitButton = document.getElementById("submitButton");
    var buttonText = document.getElementById("buttonText");
    var spinnerContainer = document.getElementById("spinnerContainer");
    var spinnerOverlay = document.getElementById("spinnerOverlay");

    //============== Clear previous error messages
    document.getElementById("usernameError").textContent = "";
    document.getElementById("passwordError").textContent = "";

    // ====================Disable the submit button and show spinner
    submitButton.classList.add("submitting");
    buttonText.textContent = "Signing In...";
    submitButton.disabled = true;
    spinnerContainer.classList.remove("hidden");
    submitButton.style.backgroundColor = "#009B7B";

    var formData = new FormData(this);
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../p/login.php", true);
    xhr.setRequestHeader("Accept", "application/json");

    xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 300) {
        var response = JSON.parse(xhr.responseText);
        if (response.status === "success") {
          spinnerOverlay.style.display = "flex";
          setTimeout(function () {
            window.location.href = "../p/d.php";
          }, 1000);
        } else {
          handleError(response);
        }
      } else {
        handleError({ username: "An error occurred. Please try again." });
      }
    };

    xhr.onerror = function () {
      handleError({
        username: "Network error. Please check your internet connection.",
      });
    };

    xhr.send(formData);

    function handleError(response) {
      if (response.username) {
        document.getElementById("usernameError").textContent =
          response.username;
      }
      if (response.password) {
        document.getElementById("passwordError").textContent =
          response.password;
      }
      resetFormState();
    }

    function resetFormState() {
      buttonText.textContent = "Sign In";
      submitButton.disabled = false;
      submitButton.classList.remove("submitting");
      submitButton.style.backgroundColor = "#009B7B";
      spinnerContainer.classList.add("hidden");
    }
  });

