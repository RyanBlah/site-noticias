<?php
// Recebe os dados do formulário
$titulo = $_POST['titulo'];
$imagem = $_POST['imagem'];
$texto = $_POST['texto'];

// Gera um nome de arquivo seguro
$tituloArquivo = preg_replace('/[^a-zA-Z0-9-_]/', '_', $titulo);
$nomeArquivo = "posts/" . $tituloArquivo . time() . ".html";

// Salva o arquivo dentro da pasta "noticias"
file_put_contents($nomeArquivo, $html);

// Escapa o conteúdo do texto
$textoSeguro = nl2br(htmlspecialchars($texto));

// ETAPA 2 - Adiciona novo slide no blog.html

// Define o trecho do novo item do carrossel
$tituloFormatado = htmlspecialchars($titulo); // Para evitar quebras
$novoSlide = "
  <a style=\"text-decoration: none;\" href=\"$nomeArquivo\"><div class=\"carrossel-item item\"style=\"background-image: url($imagem);\"><div class=\"efeito\"><div class=\"texto\"><h4>$tituloFormatado</h4><h5>autor: Ryan</h5></div></div></div></a>";

// Caminho do blog.html
$blogPath = "blog.html";

// Lê o conteúdo atual do blog
$blogHtml = file_get_contents($blogPath);



// Verifica se encontrou
$marcador = '<!-- NOVOS SLIDES AQUI -->';
if (strpos($blogHtml, $marcador) !== false) {
    // Insere o novo slide logo após o marcador
    $blogAtualizado = str_replace($marcador, $novoSlide . "\n  " . $marcador, $blogHtml);
    file_put_contents($blogPath, $blogAtualizado);
} else {
    echo "<p>Não foi possível encontrar o local para inserir o slide.</p>";
}


// HTML com HEREDOC
$html = <<<HTML
<!DOCTYPE html>
<html lang='pt-BR'>
<head>
  <meta charset='UTF-8'>
  <title>$titulo</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Noticia+Text:ital,wght@0,400;0,700;1,400;1,700&family=Share+Tech+Mono&display=swap');

    :root{
      --cor-primeira: #09122C;
      --cor-segunda: #872341;
      --cor-terceira: #BE3144;
      --cor-quarta: #E17564;
      --post-hover: #8a2634;
    }

    body {
      font-family: "Noticia Text", serif;
      font-weight: 400;
      font-style: normal;
      background-color: #E17564;
      color: #FFFFFF;
      margin: 0 auto;
      line-height: 1.6;
    }

    header {
      background-color: var(--cor-primeira);
      display: flex;
      justify-content: space-between;
      box-shadow: 0 4px 8px #000000;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 1000;
    }

    section {
      margin-top: 160px;
    }

    .noticia {
      max-width: 600px;
      margin: 40px auto;
      background-color: #872341;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.8);
    }

    .noticia h1 {
      color: #FFFFFF;
    }

    .noticia img {
      width: 100%;
      border-radius: 10px;
      margin: 20px 0;
      box-shadow: 0 4px 8px rgba(0,0,0,0.8);
    }

    .autor {
      font-size: 0.9em;
      color: #FFFFFF;
      margin-bottom: 10px;
    }

    .menu {
      width: 80px;
      height: 60px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      cursor: pointer;
      margin: 10px;
      padding: 1px;
    }

    .menu span {
      height: 12px;
      width: 100%;
      background-color: #BE3144;
      border-radius: 2px;
    }

    .menu:hover span {
      background-color: #8a2634;
    }

    .menu:active span {
      background-color: #E17564;
    }

    .titulo {
      margin: 0 auto;
      text-align: center;
      font-size: 60px;
    }

    .menu-container {
      position: relative;
    }

    .menu-dropdown {
      position: absolute;
      top: 100px;
      left: 0;
      display: none;
      flex-direction: column;
      gap: 10px;
      background-color: rgba(0, 0, 0, 0.6);
      padding: 10px;
      border-radius: 10px;
      z-index: 10;
    }

    .menu-btn {
      background-color: transparent;
      border: 2px solid white;
      color: white;
      padding: 10px 20px;
      font-size: 28px;
      border-radius: 5px;
      cursor: pointer;
      transition: 0.3s;
    }

    .menu-btn:hover {
      background-color: var(--post-hover);
      border-color: var(--cor-quarta);
    }

    @media screen and (min-width: 990px) {
      .menu-btn {
        padding: 5px 10px;
        font-size: 14px;
      }
      section {
        margin-top: 80px;
      }
      .menu {
        width: 40px;
        height: 30px;
        margin: 10px;
      }
      .menu span {
        height: 6px;
      }
      .titulo {
        font-size: 30px;
      }
      .menu-dropdown {
        top: 50px;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="menu-container">
      <div class="menu" id="menu-toggle">
        <span></span>
        <span></span>
        <span></span>
      </div>
      <div class="menu-dropdown" id="menu-dropdown">
        <button id="home" class="menu-btn">Início</button>
        <button class="menu-btn">Sobre</button>
        <button class="menu-btn">Contato</button>
      </div>
    </div>
    <h1 class="titulo">noticias</h1>
  </header>

  <section>
    <div class="noticia">
      <h1>$titulo</h1>
      <p class="autor">Autor: Ryan</p>
      <img src="$imagem" alt="Imagem da notícia">
      <p>$textoSeguro</p>
    </div>
  </section>
</body>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.getElementById("menu-toggle");
    const menuDropdown = document.getElementById("menu-dropdown");
    const home = document.getElementById("home");

    home.addEventListener("click", function(){
     window.location.href='http://127.0.0.1:3000/blog.html';
    }
);

    menuToggle.addEventListener("click", function () {
        menuDropdown.style.display =
            menuDropdown.style.display === "flex" ? "none" : "flex";
    });

    // Opcional: clique fora do menu fecha ele
    document.addEventListener("click", function (e) {
        if (!menuToggle.contains(e.target) && !menuDropdown.contains(e.target)) {
            menuDropdown.style.display = "none";
        }
    });
});
</script>
</html>
HTML;

// Salvar o arquivo
if (file_put_contents($nomeArquivo, $html)) {
    echo "<p>Notícia criada com sucesso! <a href='$nomeArquivo' target='_blank'>Ver notícia</a></p>";
} else {
    echo "<p>Erro ao salvar a notícia. Verifique permissões da pasta.</p>";
}

?>
