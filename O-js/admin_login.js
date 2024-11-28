function performLogoutAdmin() {
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
          window.location.replace("../O/login_admin.php");
          console.log("Success Logged Out");
        } else {
          console.error("Logout failed:", data.message || "Unknown error");
        }
      })
      .catch((error) => console.error("Error during logout:", error))
      .finally(() => hideLoadingSpinner());
  }, logoutTime);
}
