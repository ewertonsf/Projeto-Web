function cadastroJogadores() {
    const jogador_id = document.getElementById('jogador_id').value;
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
    const senha = document.getElementById('senha').value;
    

    console.log("Nome:", nome);
    console.log("Data de nascimento:", data_nascimento);
    console.log("CPF:", cpf);
    console.log("E-mail:", email);
    console.log("Telefone:", telefone);
    console.log("Posição:", posicao);
    console.log("Categoria:", categoria);
    console.log("Cidade:", cidade);
    console.log("Estado:", estado);
    console.log("Foto:", foto ? foto.name : "Nenhum arquivo selecionado");

    const formData = new FormData();

    if (jogador_id) {
        formData.append('id', jogador_id);
    }

    formData.append('action', jogador_id ? 'update' : 'create');

    formData.append('nome', nome);
    formData.append('data_nascimento', data_nascimento);
    formData.append('cpf', cpf);
    formData.append('email', email);
    formData.append('telefone', telefone);
    formData.append('posicao', posicao);
    formData.append('categoria', categoria);
    formData.append('cidade', cidade);
    formData.append('estado', estado);
    formData.append('senha', senha);
    if (foto) formData.append('foto', foto);

    fetch('/Projeto-Web/app/controller/controllerCadastro.php', {
    method: 'POST',
    body: formData
})
    .then(response => {
    
        return response.text();
    })
    .then(text => {
        
        console.log('Resposta RAW do PHP (Erro de JSON):', text);

       
        try {
            const data = JSON.parse(text);
            
            
            console.log('Resposta do servidor:', data);
            if (data.success) {
                alert('Jogador cadastrado com sucesso!');
                document.getElementById('formCadastro').reset();
            } else {
                alert('Erro: ' + (data.message || 'Tente novamente.'));
            }

        } catch (e) {
           
            alert('Erro de Execução no PHP. Verifique o console para a mensagem de erro completa.');
            console.error('Falha ao processar JSON. Resposta do PHP (RAW):', text);
        }
    })
    .catch(error => {
        console.error('Erro na requisição:', error);
        alert('Erro de Rede/Fetch. Verifique o console.');
    });
}



function carregarJogadorParaEdicao(idJogador) {
    
    console.log(`Buscando dados do Jogador ID: ${idJogador}...`);

    
    const dadosJogadorFicticio = {
        id: idJogador,
        nome: "Pedro Álvares Cabral",
        data_nascimento: "1995-04-22",
        cpf: "123.456.789-00",
        email: "pedro.cabral@mar.com",
        telefone: "5511987654321",
        posicao: "Meio-campo",
        categoria: "Sênior",
        cidade: "São Paulo",
        estado: "SP"
        
    };
   
    
    // 2. Preenchimento do formulário
    document.getElementById('jogador_id').value = dadosJogadorFicticio.id;
    document.getElementById('nome').value = dadosJogadorFicticio.nome;
    document.getElementById('data_nascimento').value = dadosJogadorFicticio.data_nascimento;
    document.getElementById('cpf').value = dadosJogadorFicticio.cpf;
    document.getElementById('email').value = dadosJogadorFicticio.email;
    document.getElementById('telefone').value = dadosJogadorFicticio.telefone;
    document.getElementById('posicao').value = dadosJogadorFicticio.posicao;
    document.getElementById('categoria').value = dadosJogadorFicticio.categoria;
    document.getElementById('cidade').value = dadosJogadorFicticio.cidade;
    document.getElementById('estado').value = dadosJogadorFicticio.estado;

    // 3. Ajuste visual (muda o texto do botão)
    const btn = document.querySelector('.cadastro-btn');
    btn.textContent = 'Atualizar Cadastro';
    
    document.querySelector('h2').textContent = 'Edição de Jogador';
    document.querySelector('p').textContent = 'Altere os dados necessários e salve.';

    console.log(`Formulário preenchido com dados do Jogador ID: ${idJogador}.`);
}

document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const idEdicao = urlParams.get('edit_id');

    if (idEdicao) {
        carregarJogadorParaEdicao(idEdicao);
    }
});