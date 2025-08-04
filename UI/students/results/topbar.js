document.addEventListener("DOMContentLoaded", () => {
    const notifications = document.getElementById("notifications");
    const messages = document.getElementById("messages");
    const profilePic = document.getElementById("profilePic");
    const profileDropdown = document.getElementById("profileDropdown");
    const logoutTop = document.getElementById("logoutTop");
    const notifDropdown = document.getElementById("notifDropdown");
    const notifList = document.getElementById("notifList");
    const notifCount = document.getElementById("notifCount");
    const searchInput = document.getElementById("searchInput");
    const userTemplate = document.querySelector("[data-user-template]");
    const userCardsContainer = document.querySelector(".user-cards");

    let notificationsData = [];
    let users = [];

    // ✅ 1. Toggle Notifications Dropdown
    if (notifications && notifDropdown) {
        notifications.addEventListener("click", (e) => {
            e.stopPropagation();
            notifDropdown.classList.toggle("show");
            notifCount.textContent = ""; // Clear badge
        });

        document.addEventListener("click", (e) => {
            if (!notifDropdown.contains(e.target) && !notifications.contains(e.target)) {
                notifDropdown.classList.remove("show");
            }
        });
    }

    // ✅ 2. Profile Dropdown Toggle
    if (profilePic && profileDropdown) {
        profilePic.addEventListener("click", (e) => {
            e.stopPropagation();
            profileDropdown.classList.toggle("show");
        });

        document.addEventListener("click", (e) => {
            if (!profileDropdown.contains(e.target) && !profilePic.contains(e.target)) {
                profileDropdown.classList.remove("show");
            }
        });
    }

    // ✅ 3. Logout Confirmation
    if (logoutTop) {
        logoutTop.addEventListener("click", (e) => {
            e.preventDefault();
            if (confirm("Are you sure you want to log out?")) {
                window.location.href = "../../login.html";
            }
        });
    }

    // ✅ 4. Notification Logic
    function addNotification(message) {
        notificationsData.unshift(message);
        renderNotifications();
        notifCount.textContent = notificationsData.length;
    }

    function renderNotifications() {
        notifList.innerHTML = notificationsData.map(n => `<li>${n}</li>`).join("");
    }

    setInterval(() => {
        const newNotif = `📢 Update at ${new Date().toLocaleTimeString()}`;
        addNotification(newNotif);
    }, 5000);

    // ✅ 5. Fetch Users & Render
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

    // ✅ 6. Live Search Filter
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
