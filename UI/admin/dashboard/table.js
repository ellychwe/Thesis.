
document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchInput");
    const table = document.querySelector(".board table");

    if (!table) return;

    // 🔎 Search filter
    if (searchInput) {
        searchInput.addEventListener("keyup", () => {
            const filter = searchInput.value.toLowerCase();
            const rows = table.querySelectorAll("tbody tr");

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? "" : "none";
            });
        });
    }

    // ⬆️⬇️ Sort table when clicking headers
    const headers = table.querySelectorAll("thead td");
    headers.forEach((header, index) => {
        header.addEventListener("click", () => {
            sortTable(table, index);
        });
    });

    // 📝 Handle "Edit" button clicks
    table.addEventListener("click", (e) => {
        if (e.target && e.target.tagName === "A" && e.target.textContent === "Edit") {
            e.preventDefault();
            const row = e.target.closest("tr");
            const id = row.querySelector(".id h5").textContent;
            const name = row.querySelector(".people p").textContent;

            alert(`Edit clicked for ${name} (ID: ${id})`);
            // 👉 Here you can redirect to an edit page, e.g.
            // window.location.href = `/scholarship/edit.php?id=${id}`;
        }
    });
});

function sortTable(table, columnIndex) {
    const tbody = table.tBodies[0];
    const rows = Array.from(tbody.querySelectorAll("tr"));

    const isAsc = table.getAttribute("data-sort-dir") !== "asc";
    table.setAttribute("data-sort-dir", isAsc ? "asc" : "desc");

    rows.sort((a, b) => {
        const aText = a.cells[columnIndex].textContent.trim().toLowerCase();
        const bText = b.cells[columnIndex].textContent.trim().toLowerCase();

        if (aText < bText) return isAsc ? -1 : 1;
        if (aText > bText) return isAsc ? 1 : -1;
        return 0;
    });

    rows.forEach(row => tbody.appendChild(row));
}
