const menuToggle = document.getElementById("menuToggle");
const fullscreenMenu = document.getElementById("fullscreenMenu");

menuToggle.addEventListener("click", () => {
  fullscreenMenu.classList.toggle("show");
  menuToggle.classList.toggle("open");

  const icon = menuToggle.querySelector("i");

  if (fullscreenMenu.classList.contains("show")) {
    icon.classList.remove("ri-menu-line");
    icon.classList.add("ri-close-line");

    document.body.classList.add("menu-open");
  } else {
    icon.classList.remove("ri-close-line");
    icon.classList.add("ri-menu-line");

    document.body.classList.remove("menu-open");
  }
});

document.querySelectorAll(".fullscreen-menu a").forEach((link) => {
  link.addEventListener("click", () => {
    fullscreenMenu.classList.remove("show");
    menuToggle.classList.remove("open");

    const icon = menuToggle.querySelector("i");
    icon.classList.remove("ri-close-line");
    icon.classList.add("ri-menu-line");

    document.body.classList.remove("menu-open");
  });
});
