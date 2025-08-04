function toggleDropdown() {
    document.getElementById("myDropdown").classList.toggle("show");
}

window.onclick = function (e) {
    if (!e.target.matches('.dropbtn')) {
        let dropdowns = document.getElementsByClassName("dropdown-content");
        for (let i = 0; i < dropdowns.length; i++) {
            dropdowns[i].classList.remove('show');
        }
    }
};

function filterStatus(status) {
    const rows = document.querySelectorAll("#renewTable tbody tr");
    rows.forEach(row => {
        const cell = row.querySelector(".status").innerText.trim();
        row.style.display = (status === 'all' || cell === status) ? '' : 'none';
    });
}

function exportPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    doc.text("Renewal Tracker", 20, 10);
    doc.autoTable({ html: '#renewTable' });
    doc.save("renewals.pdf");
}

function exportExcel() {
    const table = document.getElementById("renewTable");
    const wb = XLSX.utils.table_to_book(table);
    XLSX.writeFile(wb, "renewals.xlsx");
}

function openRenewalForm() {
    window.location.href = "renewform.html";
}

document.getElementById("fileUpload").addEventListener("change", function (e) {
    const file = e.target.files[0];
    const label = document.getElementById("fileLabel");
    label.textContent = file ? file.name : "Import File";

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, { type: 'array' });
            const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
            const jsonData = XLSX.utils.sheet_to_json(firstSheet, { header: 1 });

            const tbody = document.querySelector("#renewTable tbody");
            tbody.innerHTML = "";
            jsonData.slice(1).forEach(row => {
                if (row.length > 0) {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `
                        <td><h5>${row[0]}</h5></td>
                        <td><p>${row[1]}</p></td>
                        <td><p>${row[2]}</p></td>
                        <td><p class="status">${row[3]}</p></td>
                        <td><a href="#" onclick="openRenewalForm()">Renew</a></td>`;
                    tbody.appendChild(tr);
                }
            });
        };
        reader.readAsArrayBuffer(file);
    }
});
