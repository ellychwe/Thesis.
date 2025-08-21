document.addEventListener("DOMContentLoaded", () => {
    const notifications = document.getElementById("notifications");
    const notifDropdown = document.getElementById("notifDropdown");
    const notifCount = document.getElementById("notifCount");
    const notifList = document.getElementById("notifList");

    const messages = document.getElementById("messages");
    const msgCount = document.getElementById("msgCount"); // add <span id="msgCount"> if needed

    const profilePic = document.getElementById("profilePic");
    const profileDropdown = document.getElementById("profileDropdown");
    const logoutTop = document.getElementById("logoutTop");

    // ✅ Load counts & notifications from PHP
    function loadTopbarData() {
        fetch("topbar_data.php")
            .then(res => res.json())
            .then(data => {
                // Update counts
                notifCount.textContent = data.notifications > 0 ? data.notifications : "";
                if (msgCount) msgCount.textContent = data.messages > 0 ? data.messages : "";

                // Update notification list
                notifList.innerHTML = "";
                if (data.notifList.length > 0) {
                    data.notifList.forEach(n => {
                        let li = document.createElement("li");
                        li.textContent = `${n.message} (${n.created_at})`;
                        li.classList.add(n.is_read == 0 ? "unread" : "read");
                        notifList.appendChild(li);
                    });
                } else {
                    notifList.innerHTML = "<li>No notifications</li>";
                }
            })
            .catch(err => console.error("Error loading topbar data:", err));
    }

    // Run immediately & refresh every 10s
    loadTopbarData();
    setInterval(loadTopbarData, 10000);

    // ✅ Toggle notifications dropdown
    if (notifications && notifDropdown) {
        notifications.addEventListener("click", (e) => {
            e.stopPropagation();
            notifDropdown.classList.toggle("show");
            notifCount.textContent = ""; // Clear badge when opened
        });

        document.addEventListener("click", (e) => {
            if (!notifDropdown.contains(e.target) && !notifications.contains(e.target)) {
                notifDropdown.classList.remove("show");
            }
        });
    }

    // ✅ Toggle profile dropdown
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

    // ✅ Logout confirmation
    if (logoutTop) {
        logoutTop.addEventListener("click", (e) => {
            e.preventDefault();
            if (confirm("Are you sure you want to log out?")) {
                window.location.href = "../../login.html";
            }
        });
    }
});
