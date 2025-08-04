function toggleDropdown() {
    document.getElementById("myDropdown").classList.toggle("show");
}

window.addEventListener("click", function (event) {
    if (!event.target.closest('.dropdown')) {
        document.querySelectorAll(".dropdown-content").forEach(function (drop) {
            drop.classList.remove("show");
        });
    }
});

function filterStatus(type) {
    const rows = document.querySelectorAll("#scholarshipTable tbody tr");
    rows.forEach(row => {
        const scholarship = row.querySelector(".scholarship h5").innerText;
        row.style.display = (type === "all" || scholarship === type) ? "" : "none";
    });
    document.getElementById("myDropdown").classList.remove("show");
}

function exportToExcel() {
    const table = document.getElementById("scholarshipTable");
    const wb = XLSX.utils.table_to_book(table, { sheet: "Scholarship Results" });
    XLSX.writeFile(wb, "Scholarship_Results.xlsx");
}

function exportToPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    doc.text("Scholarship Results", 14, 15);
    doc.autoTable({ html: '#scholarshipTable', startY: 20 });
    doc.save("Scholarship_Results.pdf");
}