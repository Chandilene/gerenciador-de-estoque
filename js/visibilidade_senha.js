document.addEventListener("DOMContentLoaded", function () {
  const toggleSenha = document.getElementById("toggleSenha");
  const senhaInput = document.getElementById("senha"); // Usando o ID 'inputSenha'
  const iconeOlho = document.getElementById("iconeOlho");

  toggleSenha.addEventListener("click", function () {
    // 1. Determina o novo tipo
    const type =
      senhaInput.getAttribute("type") === "password" ? "text" : "password";

    // 2. Alterna o tipo do input
    senhaInput.setAttribute("type", type);

    // 3. Alterna o ícone
    if (type === "text") {
      iconeOlho.classList.remove("bi-eye-slash");
      iconeOlho.classList.add("bi-eye");
    } else {
      iconeOlho.classList.remove("bi-eye");
      iconeOlho.classList.add("bi-eye-slash");
    }
  });
});
