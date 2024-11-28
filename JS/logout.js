const modal = document.getElementById("notification-modal");
const notifIcon = document.getElementById("notif-icon");
const closeNotificationButton = document.getElementById("close-notification");

notifIcon.addEventListener("click", function () {
  modal.classList.remove("hidden");
});

// Close the notification modal
closeNotificationButton.addEventListener("click", function () {
  modal.classList.add("hidden");
});

window.addEventListener("click", function (event) {
  if (event.target === modal) {
    modal.classList.add("hidden");
  }
});
