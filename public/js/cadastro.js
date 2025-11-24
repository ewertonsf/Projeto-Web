function cadastroJogadores() {
    const nome = document.getElementById('nome').value;
    const data_nascimento = document.getElementById('data_nascimento').value;
    const cpf = document.getElementById('cpf').value;
    const email = document.getElementById('email').value;
    const telefone = document.getElementById('telefone').value;
    const posicao = document.getElementById('posicao').value;
    const categoria = document.getElementById('categoria').value;
    const cidade = document.getElementById('cidade').value;
    const estado = document.getElementById('estado').value;
    const foto = document.getElementById('foto').files[0];

    if (!nome || !data_nascimento || !cpf || !email || !telefone || !posicao || !categoria || !cidade || !estado || !foto) {
        alert('Por favor, preencha todos os campos obrigatórios!');
        return;
    }

    const formData = new FormData();
    formData.append('nome', nome);
    formData.append('data_nascimento', data_nascimento);
    formData.append('cpf', cpf);
    formData.append('email', email);
    formData.append('telefone', telefone);
    formData.append('posicao', posicao);
    formData.append('categoria', categoria);
    formData.append('cidade', cidade);
    formData.append('estado', estado);
    if (foto) formData.append('foto', foto);

    fetch('../app/controller/controllerCadastro.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('Resposta do servidor:', data);
        if (data.success) {
            alert('Jogador cadastrado com sucesso!');
            document.getElementById('formCadastro').reset();
            window.location.href = 'index.html';
        } else {
            alert('Erro: ' + (data.message || 'Tente novamente.'));
        }
    })
    .catch(error => {
        console.error('Erro na requisição:', error);
    });
}