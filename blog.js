let indiceAtual0 = 0;
let indiceAtual1 = 0;
let indiceAtual2 = 0;

function obterLarguraSlide() {
  return window.innerWidth > 980 ? 600 : 300;
}

function moverCarrossel(direcao = 1) {
  const carrossel = document.getElementById('carrossel');
  const totalSlides = carrossel.children.length;
  const largura = obterLarguraSlide();

  indiceAtual0 = (indiceAtual0 + direcao + totalSlides) % totalSlides;
  carrossel.style.transform = `translateX(-${indiceAtual0 * largura}px)`;
}

function moverCarrossel1(direcao = 1) {
  const carrossel = document.getElementById('carrossel1');
  const totalSlides = carrossel.children.length;
  const largura = obterLarguraSlide();

  indiceAtual1 = (indiceAtual1 + direcao + totalSlides) % totalSlides;
  carrossel.style.transform = `translateX(-${indiceAtual1 * largura}px)`;
}

function moverCarrossel2(direcao = 1) {
  const carrossel = document.getElementById('carrossel2');
  const totalSlides = carrossel.children.length;
  const largura = obterLarguraSlide();

  indiceAtual2 = (indiceAtual2 + direcao + totalSlides) % totalSlides;
  carrossel.style.transform = `translateX(-${indiceAtual2 * largura}px)`;
}

document.addEventListener("DOMContentLoaded", function () {
  const menuToggle = document.getElementById("menu-toggle");
  const menuDropdown = document.getElementById("menu-dropdown");
  const home = document.getElementById("home");

  home.addEventListener("click", function () {
    window.location.href = 'blog.html';
  });

  menuToggle.addEventListener("click", function () {
    menuDropdown.style.display =
      menuDropdown.style.display === "flex" ? "none" : "flex";
  });

  document.addEventListener("click", function (e) {
    if (!menuToggle.contains(e.target) && !menuDropdown.contains(e.target)) {
      menuDropdown.style.display = "none";
    }
  });

  // Carrossel automático a cada 3 segundos
  setInterval(() => {
    moverCarrossel();
    moverCarrossel1();
    moverCarrossel2();
  }, 3000);

  // Recalcular ao redimensionar a tela para manter a responsividade
  window.addEventListener("resize", () => {
    moverCarrossel(0);
    moverCarrossel1(0);
    moverCarrossel2(0);
  });
});
