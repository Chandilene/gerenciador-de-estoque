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
