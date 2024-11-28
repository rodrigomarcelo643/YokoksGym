function filterMembers() {
  const searchInput = document
    .getElementById("searchInput")
    .value.toLowerCase();
  const selectedDate = document.getElementById("searchDate").value;
  const selectedStaff = document
    .getElementById("staffDropdown")
    .value.toLowerCase();
  const rows = document.querySelectorAll(".member-row");
  let found = false;

  rows.forEach((row) => {
    const nameCell = row.cells[0];
    const memberName = nameCell.textContent.toLowerCase();
    const membershipStart = row.getAttribute("data-start-date");
    const addedBy = row.cells[4].textContent.toLowerCase();
    const matchesSearch =
      memberName.includes(searchInput) || addedBy.includes(searchInput);
    const matchesDate = selectedDate === "" || membershipStart === selectedDate;
    const matchesStaff =
      selectedStaff === "" || addedBy.includes(selectedStaff);

    if (matchesSearch && matchesDate && matchesStaff) {
      row.style.display = "";
      highlightMatch(row, searchInput);
      found = true;
    } else {
      row.style.display = "none";
    }
  });

  const notFoundMessage = document.getElementById("notFoundMessage");
  if (found) {
    notFoundMessage.classList.add("hidden");
  } else {
    notFoundMessage.classList.remove("hidden");
  }

  if (searchInput === "" && selectedStaff === "") {
    const staffDropdown = document.getElementById("staffDropdown");
    staffDropdown.selectedIndex = 0;
  }
}

function highlightMatch(row, searchTerm) {
  const nameCell = row.cells[0];
  const memberName = nameCell.textContent;
  const regex = new RegExp(`(${searchTerm})`, "gi");
  const highlightedName = memberName.replace(
    regex,
    '<span class="highlight">$1</span>'
  );
  nameCell.innerHTML = highlightedName;
}

function filterMembership(type) {
  const rows = document.querySelectorAll(".member-row");
  const dailyButton = document.getElementById("dailyButton");
  const monthlyButton = document.getElementById("monthlyButton");

  rows.forEach((row) => {
    const membershipType = row.getAttribute("data-type");
    if (type === "daily" && membershipType.includes("daily")) {
      row.style.display = "";
    } else if (type === "monthly" && membershipType.includes("monthly")) {
      row.style.display = "";
    } else {
      row.style.display = "none";
    }
  });

  dailyButton.classList.toggle("active", type === "daily");
  monthlyButton.classList.toggle("active", type === "monthly");
}
