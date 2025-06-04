const toggles = document.querySelectorAll(".sidebar .nav-link[data-target]");

toggles.forEach((toggle) => {
  toggle.addEventListener("click", (e) => {
    e.stopPropagation();
    const targetId = toggle.getAttribute("data-target");
    const dropdown = document.getElementById(targetId);
    const arrow = toggle.querySelector(".arrow-icon");

    document.querySelectorAll(".dropdown-container").forEach((el) => {
      if (el !== dropdown) el.classList.remove("show");
    });
    document.querySelectorAll(".arrow-icon").forEach((icon) => {
      if (icon !== arrow) icon.classList.remove("rotate");
    });

    dropdown.classList.toggle("show");
    arrow.classList.toggle("rotate");
  });
});

const sidebar = document.getElementById("sidebar");
sidebar.addEventListener("mouseleave", () => {
  document
    .querySelectorAll(".dropdown-container")
    .forEach((el) => el.classList.remove("show"));
  document
    .querySelectorAll(".arrow-icon")
    .forEach((icon) => icon.classList.remove("rotate"));
});

setTimeout(function () {
  var alerts = document.querySelectorAll(".fade-out");
  for (var i = 0; i < alerts.length; i++) {
    alerts[i].style.display = "none";
  }
}, 3000);

$(document).ready(function () {
  $("#utilizadoresTable").DataTable({
    order: [[0, "asc"]],
    columnDefs: [
      { targets: 1, type: "string" },
      { targets: [1, 9], searchable: false },
      { targets: [1, 9], orderable: false },
    ],
    language: {
      url: "https://cdn.datatables.net/plug-ins/2.3.0/i18n/pt-PT.json",
    },
  });
});

$(document).ready(function () {
  $("#svipTable").DataTable({
    order: [[0, "asc"]],
    columnDefs: [
      { targets: 1, type: "string" },
      { targets: [2, 3], searchable: false },
      { targets: [2, 3], orderable: false },
    ],
    language: {
      url: "https://cdn.datatables.net/plug-ins/2.3.0/i18n/pt-PT.json",
    },
  });
});

$(document).ready(function () {
  $("#postsTable").DataTable({
    order: [[0, "asc"]],
    columnDefs: [
      { targets: 1, type: "string" },
      { targets: [7, 8], searchable: false },
      { targets: [7, 8], orderable: false },
    ],
    language: {
      url: "https://cdn.datatables.net/plug-ins/2.3.0/i18n/pt-PT.json",
    },
  });
});

$(document).ready(function () {
  $("#galeriaTable").DataTable({
    order: [[0, "asc"]],
    columnDefs: [
      { targets: 1, type: "string" },
      { targets: [2, 6], searchable: false },
      { targets: [2, 6], orderable: false },
    ],
    language: {
      url: "https://cdn.datatables.net/plug-ins/2.3.0/i18n/pt-PT.json",
    },
  });
});

$(document).ready(function () {
  $("#faqTable").DataTable({
    order: [[1, "asc"]],
    columnDefs: [
      { targets: 1, type: "string" },
      { targets: [3], searchable: false },
      { targets: [3], orderable: false },
    ],
    language: {
      url: "https://cdn.datatables.net/plug-ins/2.3.0/i18n/pt-PT.json",
    },
  });
});

$(document).ready(function () {
  $("#eventosTable").DataTable({
    order: [[0, "asc"]],
    columnDefs: [
      { targets: 1, type: "string" },
      { targets: [4, 5], searchable: false },
      { targets: [4, 5], orderable: false },
    ],
    language: {
      url: "https://cdn.datatables.net/plug-ins/2.3.0/i18n/pt-PT.json",
    },
  });
});

$(document).ready(function () {
  $("#comentariosTable").DataTable({
    order: [[0, "asc"]],
    columnDefs: [
      { targets: 1, type: "string" },
      { targets: [5], searchable: false },
      { targets: [5], orderable: false },
    ],
    language: {
      url: "https://cdn.datatables.net/plug-ins/2.3.0/i18n/pt-PT.json",
    },
  });
});

$(document).ready(function () {
  $("#cpostTable").DataTable({
    order: [[0, "asc"]],
    columnDefs: [
      { targets: 1, type: "string" },
      { targets: [2], searchable: false },
      { targets: [2], orderable: false },
    ],
    language: {
      url: "https://cdn.datatables.net/plug-ins/2.3.0/i18n/pt-PT.json",
    },
  });
});

$(document).ready(function () {
  $("#contactosTable").DataTable({
    order: [[1, "asc"]],
    columnDefs: [
      { targets: [6], searchable: false },
      { targets: [6], orderable: false },
    ],
    language: {
      url: "https://cdn.datatables.net/plug-ins/2.3.0/i18n/pt-PT.json",
    },
  });
});
