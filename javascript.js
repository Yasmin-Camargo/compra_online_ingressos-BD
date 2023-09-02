// Verifica qual item esta selecionado nos filtros, oculta outros e mostra o correspondente
document.addEventListener("DOMContentLoaded", function () {
    const filterSelect = document.getElementById("filter");
    const eventsContainer = document.getElementById("events-container");

    filterSelect.addEventListener("change", function () {
        const selectedOption = filterSelect.value;  // Obtém o valor atualmente selecionado no fitro

        if (selectedOption === "todos") {   // Verifica se a opção selecionada é "todos"
            eventsContainer.style.display = "block";    // Se for "todos", mostra a div "eventsContainer"
        } else {
            eventsContainer.style.display = "none";     // Se não for "todos", oculta a div "eventsContainer"
        }
    });
});
