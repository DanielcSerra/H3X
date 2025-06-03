document.addEventListener("DOMContentLoaded", function () {
  const ctx = document.getElementById("utilizadoresChart").getContext("2d");
  const utilizadoresChart = new Chart(ctx, {
    type: "pie",
    data: {
      labels: ["Administrador", "Funcionário", "Cliente"],
      datasets: [
        {
          label: "Utilizadores",
          data: window.utilizadoresData,
          backgroundColor: ["#0d6efd", "#ffc107", "#198754"],
        },
      ],
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        tooltip: { enabled: true },
      },
    },
  });

  const legendContainer = document.getElementById("legendContainer");
  legendContainer.style.display = "flex";
  legendContainer.style.flexDirection = "column";
  legendContainer.style.gap = "10px";

  utilizadoresChart.data.labels.forEach((label, index) => {
    const color = utilizadoresChart.data.datasets[0].backgroundColor[index];
    const value = utilizadoresChart.data.datasets[0].data[index];

    const legendItem = document.createElement("div");
    legendItem.style.display = "flex";
    legendItem.style.alignItems = "center";
    legendItem.style.gap = "8px";

    const colorBox = document.createElement("span");
    colorBox.style.backgroundColor = color;
    colorBox.style.width = "20px";
    colorBox.style.height = "20px";
    colorBox.style.borderRadius = "4px";
    colorBox.style.display = "inline-block";

    const text = document.createElement("span");
    text.textContent = `${label}: ${value}`;

    legendItem.appendChild(colorBox);
    legendItem.appendChild(text);
    legendContainer.appendChild(legendItem);
  });

  const ctxPostsSemana = document
    .getElementById("postsSemanaChart")
    .getContext("2d");
  const postsSemanaChart = new Chart(ctxPostsSemana, {
    type: "bar",
    data: {
      labels: window.semanasLabels,
      datasets: [
        {
          label: "Posts Criados",
          data: window.postsPorSemana,
          backgroundColor: "rgba(25, 135, 84, 0.7)",
          borderRadius: 6,
          borderSkipped: false,
        },
      ],
    },
    options: {
      responsive: true,
      scales: {
        x: {
          ticks: {
            maxRotation: 90,
            minRotation: 45,
            font: { size: 12 },
          },
        },
        y: {
          beginAtZero: true,
          ticks: { stepSize: 1, font: { size: 12 } },
          grid: { color: "#e9ecef" },
        },
      },
      plugins: {
        legend: { display: false },
        tooltip: {
          enabled: true,
          backgroundColor: "#343a40",
          titleFont: { weight: "bold" },
          bodyFont: { size: 14 },
        },
      },
    },
  });
});
