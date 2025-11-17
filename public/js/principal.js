document.addEventListener("DOMContentLoaded", () => {
    carregarJogadores();
});

function formatarDataBrasileira(data) {
    const partes = data.split("-");
    return `${partes[2]}/${partes[1]}/${partes[0]}`;
}

function carregarJogadores() {

    fetch('../app/controller/controllerCardsJogadores.php')
        .then(res => res.json())
        .then(resultado => {

            const container = document.getElementById("cardsJogadores");
            container.innerHTML = ""; // limpa antes de carregar

            if (!resultado.success || resultado.data.length === 0) {
                container.innerHTML = "<p class='nenhum-jogador'>Nenhum jogador cadastrado.</p>";
                return;
            }

            resultado.data.forEach(jogador => {
                container.innerHTML += `
                    <div class="card-jogador">
                        <img src="../app/uploads/${jogador.foto}">
                        <h3>${jogador.nome}</h3>
                        <p><strong>Email:</strong> ${jogador.email}</p>
                        <p><strong>Posição:</strong> ${jogador.posicao}</p>
                        <p><strong>Categoria:</strong> ${jogador.categoria}</p>
                        <p><strong>Telefone:</strong> ${jogador.telefone}</p>
                        <p><strong>data de nascimento:</strong> ${formatarDataBrasileira(jogador.data_nascimento)}</p>
                        <p><strong>Cidade:</strong> ${jogador.cidade}</p>
                        <p><strong>Estado:</strong> ${jogador.estado}</p>
                    </div>
                `;
            });

        })
        .catch(err => {
            console.error("Erro ao carregar jogadores:", err);
            document.getElementById("cardsJogadores").innerHTML =
                "<p>Erro ao carregar jogadores.</p>";
        });
}
