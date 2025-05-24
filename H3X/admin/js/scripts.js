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
    pageLength: 10,
    lengthMenu: [5, 10, 25, 50, 100],
    language: {
      search: "Pesquisar:",
      lengthMenu: "Mostrar _MENU_ registros por página",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
      paginate: {
        first: "Primeiro",
        last: "Último",
        next: "Próximo",
        previous: "Anterior",
      },
      zeroRecords: "Nenhum registro encontrado",
      infoEmpty: "Mostrando 0 a 0 de 0 registros",
      infoFiltered: "(filtrado de _MAX_ registros no total)",
    },
  });
});