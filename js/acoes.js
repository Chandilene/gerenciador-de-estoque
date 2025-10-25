document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("confirmDeleteModal");
  const confirmBtn = document.getElementById("confirmDeleteBtn");
  const produtoNomeSpan = document.getElementById("produtoNome");

  let targetFormId = ""; // Variável para armazenar o ID do formulário a ser submetido

  // 1. Lógica acionada quando o modal está prestes a ser mostrado
  if (modal) {
    modal.addEventListener("show.bs.modal", function (event) {
      // Botão que acionou o modal (o botão "Excluir" na tabela)
      const button = event.relatedTarget;

      // Pega os dados armazenados nos atributos 'data-' do botão
      const produtoId = button.getAttribute("data-produto-id");
      const produtoNome = button.getAttribute("data-produto-nome");

      // Atualiza o texto do modal com o nome do produto
      produtoNomeSpan.textContent = produtoNome;

      // Armazena o ID do formulário que será submetido
      targetFormId = `form-excluir-${produtoId}`;
    });
  }

  // 2. Lógica acionada quando o botão "Excluir" (dentro do modal) é clicado
  if (confirmBtn) {
    confirmBtn.addEventListener("click", function () {
      if (targetFormId) {
        // Encontra e submete o formulário escondido
        const form = document.getElementById(targetFormId);
        if (form) {
          form.submit();
        }
      }
    });
  }
});
