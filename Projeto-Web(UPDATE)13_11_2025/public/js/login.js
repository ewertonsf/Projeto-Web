function loginAdmin() {
  const email = document.getElementById('email').value;
  const senha = document.getElementById('senha').value;

  const formData = new FormData();
  formData.append('email', email);
  formData.append('senha', senha);

//   console.log(email, senha);

  fetch('../app/controller/controllerLogin.php', {
    method: 'POST',
    body: formData
  })
  .then(resp => resp.json()) 
  .then(data => {
    if (data.success) {
      setTimeout(() => window.location.href = 'admin/admin.html', 1000);
    }
  })
  .catch(err => {
    console.error('Erro:', err);
    mensagem.textContent = "Erro na conexão com o servidor!";
  });
}
