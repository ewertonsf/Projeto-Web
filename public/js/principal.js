document.addEventListener("DOMContentLoaded", () => {
    carregarJogadores();
});

function carregarJogadores() {

    fetch('../app/controller/controllerCardsJogadores.php')
        .then(res => res.json())
        .then(resultado => {

            const container = document.getElementById("cardsJogadores");
            container.innerHTML = ""; // limpa antes de carregar

            if (!resultado.success || resultado.data.length === 0) {
                container.innerHTML = "<p>Nenhum jogador cadastrado.</p>";
                return;
            }

            resultado.data.forEach(jogador => {
                container.innerHTML += `
                    <div class="card-jogador">
                        <h3>${jogador.nome}</h3>
                        <img src="/../app/uploads/${jogador.foto}">
                        <p><strong>data de nascimento:</strong> ${jogador.data_nascimento}</p>
                        <p><strong>CPF:</strong> ${jogador.cpf}</p>
                        <p><strong>Email:</strong> ${jogador.email}</p>
                        <p><strong>Telfone:</strong> ${jogador.telefone}</p>
                        <p><strong>Posição:</strong> ${jogador.posicao}</p>
                        <p><strong>Categoria:</strong> ${jogador.telefone}</p>
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
