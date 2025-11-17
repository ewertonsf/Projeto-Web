document.addEventListener('DOMContentLoaded', function() {
    listarJogadores();
});

function listarJogadores() {
    fetch('../../app/controller/controllerListarJogadores.php')
        .then(response => response.json())
        .then(data => {
            
            if (data.success && data.jogadores.length > 0) {
                const tbody = document.getElementById('lista-jogadores-tbody');
                tbody.innerHTML = '';

                data.jogadores.forEach(jogador => {
                    const tr = document.createElement('tr');
                    
                    tr.innerHTML = `
                        <td>${jogador.id}</td>
                        <td>${jogador.nome}</td>
                        <td>${jogador.email}</td>
                        <td>${jogador.posicao || 'N/D'}</td>
                        <td>${jogador.categoria || 'N/D'}</td>
                        <td class="acoes">
                            <button class="btn-acao editar" title="Editar"><i class="fa-solid fa-pencil"></i></button>
                            <button class="btn-acao deletar" title="Deletar"><i class="fa-solid fa-trash"></i></button>
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