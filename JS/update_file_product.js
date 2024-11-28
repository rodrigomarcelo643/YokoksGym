function updateFileName() {
  const fileInput = document.getElementById("UploadFile");
  const fileNameDisplay = document.getElementById("showFile");

  if (fileInput.files.length > 0) {
    const file = fileInput.files[0];
    if (file.type.startsWith("image/")) {
      const reader = new FileReader();
      reader.onload = function (e) {
        fileNameDisplay.innerHTML = `<img src="${e.target.result}" alt="${file.name}">`;
      };
      reader.readAsDataURL(file);
    } else {
      fileNameDisplay.innerHTML = `<span>${file.name}</span>`;
    }
  } else {
    fileNameDisplay.innerHTML = "";
  }
}

//============inPUT===
document.querySelectorAll(".input-container input").forEach((input) => {
  input.addEventListener("input", function () {
    this.dispatchEvent(new Event("change")); // Trigger change event to update label position
  });
});
