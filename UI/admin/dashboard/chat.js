document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchInput");
    const userTemplate = document.querySelector("[data-user-template]");
    const userCardsContainer = document.querySelector(".user-cards");
    let users = [];

    if (userTemplate && userCardsContainer) {
        fetch("https://jsonplaceholder.typicode.com/users")
            .then(res => res.json())
            .then(data => {
                users = data.map(user => {
                    const card = userTemplate.content.cloneNode(true).children[0];
                    card.querySelector(".header").textContent = user.name;
                    card.querySelector(".body").textContent = user.email;
                    userCardsContainer.append(card);
                    return { name: user.name, email: user.email, element: card };
                });
            });
    }

    if (searchInput) {
        searchInput.addEventListener("input", e => {
            const value = e.target.value.toLowerCase();
            users.forEach(user => {
                const isVisible =
                    user.name.toLowerCase().includes(value) ||
                    user.email.toLowerCase().includes(value);
                user.element.classList.toggle("hide", !isVisible);
            });
        });
    }
});
