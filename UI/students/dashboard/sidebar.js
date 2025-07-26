document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.getElementById("sidebar");
    const toggleBtn = document.getElementById("toggleBtn");
    const links = document.querySelectorAll(".sidebar ul li a");
    const logoutBtn = document.getElementById("logout");

    // ✅ Toggle Sidebar
    if (toggleBtn) {
        toggleBtn.addEventListener("click", () => {
            sidebar.classList.toggle("collapsed");
        });
    }

    // ✅ Active Link Highlight (store in localStorage)
    links.forEach(link => {
        link.addEventListener("click", function () {
            links.forEach(l => l.classList.remove("active"));
            this.classList.add("active");
            localStorage.setItem("activeLink", this.getAttribute("href"));
        });
    });

    // ✅ Restore Active Link on Reload
    const activeLink = localStorage.getItem("activeLink");
    if (activeLink) {
        links.forEach(link => {
            if (link.getAttribute("href") === activeLink) {
                link.classList.add("active");
            }
        });
    }

    // ✅ Logout Confirmation
    if (logoutBtn) {
        logoutBtn.addEventListener("click", (e) => {
            e.preventDefault();
            if (confirm("Are you sure you want to log out?")) {
                window.location.href = "frontend/login.html"; // Adjust path
            }
        });
    } else {
        console.error("Logout button not found!");
    }
});
