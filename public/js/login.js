function loginAdmin() {
  const email = document.getElementById('email').value;
  const senha = document.getElementById('senha').value;

  if (!email || !senha) {
    alert('Preencha todos os campos!');
    return;
  }

  const formData = new FormData();
  formData.append('email', email);
  formData.append('senha', senha);

  fetch('../app/controller/controllerLogin.php', {
    method: 'POST',
    body: formData
  })
  .then(resp => resp.json())
  .then(data => {
    if (data.success) {
      alert('Login efetuado! Redirecionando...');
      setTimeout(() => {
        window.location.href = 'admin/admin.php';
      }, 1000);
    } else {
      alert(data.message || "Email ou senha incorretos!");
    }
  })
  .catch(err => {
    console.error('Erro:', err);
    alert("Erro na conexão com o servidor!");
  });
}
