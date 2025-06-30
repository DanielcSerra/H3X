let tempoRestante = 2 * 24 * 60 * 60;

function atualizarContador() {
  if (tempoRestante <= 0) {
    document.getElementById("contador_mobile").innerHTML = "Tempo esgotado";
    document.getElementById("contador_pc").innerHTML = "Tempo esgotado";
    clearInterval(contador);
    return;
  }

  const dias = Math.floor(tempoRestante / (24 * 60 * 60));
  const horas = Math.floor((tempoRestante % (24 * 60 * 60)) / (60 * 60));
  const minutos = Math.floor((tempoRestante % (60 * 60)) / 60);
  const segundos = tempoRestante % 60;

  document.getElementById("contador_mobile").innerHTML = `${String(
    dias
  ).padStart(2, "0")}D : ${String(horas).padStart(2, "0")}H : ${String(
    minutos
  ).padStart(2, "0")}M : ${String(segundos).padStart(2, "0")}S`;

  document.getElementById("contador_pc").innerHTML = `${String(dias).padStart(
    2,
    "0"
  )}D : ${String(horas).padStart(2, "0")}H : ${String(minutos).padStart(
    2,
    "0"
  )}M : ${String(segundos).padStart(2, "0")}S`;

  tempoRestante--;
}

const contador = setInterval(atualizarContador, 1000);

atualizarContador();
