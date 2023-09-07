// Verifica qual item está selecionado nos filtros: todos ou favorita
document.addEventListener("DOMContentLoaded", function () {
    const filterSelect = document.getElementById("filter");
    const eventsContainer = document.getElementById("events-container");    // Seleciona a div todos os eventos
    const favoritosContainer = document.getElementById("favoritos-container"); // Seleciona a div favoritos

    filterSelect.addEventListener("change", function () {
        const selectedOption = filterSelect.value;  // Obtém o valor atualmente selecionado no filtro

        if (selectedOption === "todos") {   // Verifica se a opção selecionada é "todos"
            eventsContainer.style.display = "block";    // Se for "todos", mostra a div "eventsContainer"
            favoritosContainer.style.display = "none";  // Oculta a div "favoritosContainer"
        } else if (selectedOption === "favoritos") { // Verifica se a opção selecionada é "favoritos"
            eventsContainer.style.display = "none";     // Oculta a div "eventsContainer"
            favoritosContainer.style.display = "block"; // Se for "favoritos", mostra a div "favoritosContainer"
        }
    });
});

// Na página do usuário oculta informações quando clica em editar
function editInfoUsuario() {
    const informacoesUsuario = document.querySelector('.InformacoesUsuario');
    const editarInfo = document.querySelector('#editar-info');

    // Alterna a exibição entre as divs
    informacoesUsuario.style.display = 'none';
    editarInfo.style.display = 'block';
}


