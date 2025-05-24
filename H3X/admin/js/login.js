function toggleForms() {
  const loginForm = document.getElementById("login-form");
  const registerForm = document.getElementById("register-form");
  const title = document.getElementById("form-title");

  if (loginForm.classList.contains("visible")) {
    loginForm.classList.replace("visible", "hidden");
    registerForm.classList.replace("hidden", "visible");
    title.textContent = "Criar Conta";
  } else {
    registerForm.classList.replace("visible", "hidden");
    loginForm.classList.replace("hidden", "visible");
    title.textContent = "Iniciar Sessão";
  }
}

window.addEventListener("DOMContentLoaded", () => {
  document.getElementById("login-form").classList.add("visible");
  document.getElementById("register-form").classList.add("hidden");
});

setTimeout(function () {
  var alerts = document.querySelectorAll(".fade-out");
  for (var i = 0; i < alerts.length; i++) {
    alerts[i].style.display = "none";
  }
}, 3000);
