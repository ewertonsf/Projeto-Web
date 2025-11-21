document.addEventListener('DOMContentLoaded', function() {
    listarJogadores();
});

function formatarDataBrasileira(data) {
    if (!data) return '';
    const dataSomente = data.split(' ')[0]; // pega só "YYYY-MM-DD"
    const partes = dataSomente.split("-");
    return `${partes[2]}/${partes[1]}/${partes[0]}`;
}


function listarJogadores() {
    fetch('../../app/controller/controllerListarJogadores.php')
        .then(response => response.json())
        .then(data => {
            
            if (data.success && data.jogadores.length > 0) {
                const tbody = document.getElementById('lista-jogadores-tbody');
                tbody.innerHTML = '';

                console.log(data);

                data.jogadores.forEach(jogador => {
                    const tr = document.createElement('tr');
                    
                    tr.innerHTML = `
                        <td>${jogador.id}</td>
                        <td><img class="" src="../../app/uploads/${jogador.foto}"></td>
                        <td>${jogador.nome}</td>
                        <td>${jogador.email}</td>
                        <td>${jogador.telefone}</td>
                        <td>${formatarDataBrasileira(jogador.data_nascimento)}</td>
                        <td>${jogador.posicao || 'N/D'}</td>
                        <td>${jogador.categoria || 'N/D'}</td>
                        <td>${formatarDataBrasileira(jogador.data_inscricao)}</td>
                        <td class="acoes">
                            <button class="btn-acao editar" title="Editar" onclick="abrirModalEditar(${jogador.id})"><i class="fa-solid fa-pencil"></i></button>
                            <button class="btn-acao deletar" title="Deletar" onclick="deletarJogador(${jogador.id})">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    `;
                    
                    tbody.appendChild(tr);
                });
            } else if (data.success && data.jogadores.length === 0) {
                document.querySelector('.tabela-container').innerHTML = `
                    <div class="caixa-vazia">
                        <div class="icon"><i class="fa-solid fa-users-slash"></i></div>
                        <p>Nenhum usuário cadastrado</p>
                    </div>
                `;
            } else {
                alert('Erro ao carregar jogadores: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
            alert('Erro de conexão ao buscar jogadores.');
        });
}

function deletarJogador(id) {

    if (!confirm("Tem certeza que deseja deletar este jogador?")) {
        return;
    }

    const formData = new FormData();
    formData.append("id", id);

    fetch('../../app/controller/controllerDelete.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Jogador deletado com sucesso!");
            listarJogadores();
        } else {
            alert("Erro ao deletar: " + data.message);
        }
    })
    .catch(error => console.error("Erro:", error));
}

function abrirModalEditar(idJogador) {
    const modal = document.getElementById("modal-editar");
    const form = document.getElementById("formEditar");

    modal.classList.add("show");

    form.reset();

    document.getElementById("edit_jogador_id").value = idJogador;

    const formData = new FormData();
    formData.append("id", idJogador);
    formData.append('action', 'buscar');

    fetch('../../app/controller/controllerEdit.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById("edit_nome").value = data.jogador.nome;
                document.getElementById("edit_data_nascimento").value = data.jogador.data_nascimento;
                document.getElementById("edit_cpf").value = data.jogador.cpf;
                document.getElementById("edit_email").value = data.jogador.email;
                document.getElementById("edit_telefone").value = data.jogador.telefone;
                document.getElementById("edit_posicao").value = data.jogador.posicao;
                document.getElementById("edit_categoria").value = data.jogador.categoria;
                document.getElementById("edit_cidade").value = data.jogador.cidade;
                document.getElementById("edit_estado").value = data.jogador.estado;
            } else {
                alert("Erro ao carregar dados do jogador.");
            }
        })
        .catch(err => console.error("Erro no fetch:", err));
}

function fecharModalEditar() {
    const modal = document.getElementById("modal-editar");
    modal.classList.remove("show");

    document.getElementById("formEditar").reset();
}

function salvarEdicao() {
    const formData = new FormData();

    formData.append('action', 'editar');
    formData.append('id', document.getElementById('edit_jogador_id').value);
    formData.append('nome', document.getElementById('edit_nome').value);
    formData.append('data_nascimento', document.getElementById('edit_data_nascimento').value);
    formData.append('cpf', document.getElementById('edit_cpf').value);
    formData.append('email', document.getElementById('edit_email').value);
    formData.append('telefone', document.getElementById('edit_telefone').value);
    formData.append('posicao', document.getElementById('edit_posicao').value);
    formData.append('categoria', document.getElementById('edit_categoria').value);
    formData.append('cidade', document.getElementById('edit_cidade').value);
    formData.append('estado', document.getElementById('edit_estado').value);


    const fotoInput = document.getElementById('edit_foto');
    if (fotoInput && fotoInput.files.length > 0) {
        formData.append('foto', fotoInput.files[0]);
    }

    fetch("../../app/controller/controllerEdit.php", {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            fecharModalEditar();
            listarJogadores();
        } else {
            alert(data.message);
        }
    })
    .catch(err => console.error("Erro ao salvar edição:", err));
}



