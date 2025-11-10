function previewImagem(event) {
  var imagemPreview = document.getElementById("imagemPreview");
  var input = event.target;
  var textoPlaceholder = document.getElementById("textoPlaceholder");

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      // Define o src da imagem com os dados do arquivo (Base64)
      imagemPreview.src = e.target.result;

      // Exibe a imagem e esconde o texto
      imagemPreview.style.display = "block";
      textoPlaceholder.style.display = "none";
    };

    // Inicia a leitura
    reader.readAsDataURL(input.files[0]);
  } else {
    // Se o campo foi limpo ou a seleção cancelada
    imagemPreview.src = "#";
    imagemPreview.style.display = "none";
    textoPlaceholder.style.display = "block";
  }
}

// EDITAAAAAAAAAAAR -------------------------
function previewImagem(event) {
  const [file] = event.target.files;
  const preview = document.getElementById('imagemPreview');
  const placeholder = document.getElementById('textoPlaceholder');

  if (file) {
      preview.src = URL.createObjectURL(file);
      preview.style.display = 'block';
      placeholder.style.display = 'none';
  } else if (!preview.getAttribute('src') || preview.getAttribute('src') === '#') {
      preview.style.display = 'none';
      placeholder.style.display = 'block';
  }
}
// Função de inicialização para configurar o estado inicial (imagem atual vs. placeholder)
// Esta função é executada assim que o DOM estiver carregado.
document.addEventListener("DOMContentLoaded", () => {
  var imagemPreview = document.getElementById("imagemPreview");
  var textoPlaceholder = document.getElementById("textoPlaceholder");

  // Verifica se o PHP preencheu o atributo 'src' com uma URL válida (diferente de '#')
  if (
    imagemPreview &&
    imagemPreview.getAttribute("src") &&
    imagemPreview.getAttribute("src") !== "#"
  ) {
    // Se houver imagem (modo edição), exibe a imagem e oculta o placeholder.
    imagemPreview.style.display = "block";
    textoPlaceholder.style.display = "none";
  } else if (textoPlaceholder) {
    // Se não houver imagem (modo cadastro ou edição sem foto), garante que o placeholder apareça.
    imagemPreview.style.display = "none";
    textoPlaceholder.style.display = "block";
  }
});
