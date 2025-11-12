document.addEventListener("DOMContentLoaded", function () {
  // Agora selecionamos todos os botões que têm a classe 'toggle-password'
  const toggleButtons = document.querySelectorAll(".toggle-password");

  toggleButtons.forEach((button) => {
    button.addEventListener("click", function () {
      // Usamos o atributo 'data-target' para descobrir qual input controlar
      const targetId = this.getAttribute("data-target");
      const senhaInput = document.getElementById(targetId);
      const iconeOlho = this.querySelector("i"); // Seleciona o ícone DENTRO deste botão

      // 1. Determina o novo tipo
      const type =
        senhaInput.getAttribute("type") === "password" ? "text" : "password";

      // 2. Alterna o tipo do input
      senhaInput.setAttribute("type", type);

      // 3. Alterna o ícone (o código de alternância de classe é mais limpo)
      iconeOlho.classList.toggle("bi-eye-slash");
      iconeOlho.classList.toggle("bi-eye");
    });
  });
});
