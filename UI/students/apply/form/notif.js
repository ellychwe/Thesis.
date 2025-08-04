document.getElementById('scholarshipForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent real submission

    // Optional: Do validation or Ajax here

    // Show popup
    document.getElementById('successModal').style.display = 'block';
});

// Close modal on X click
document.querySelector('.close').onclick = function () {
    document.getElementById('successModal').style.display = 'none';
    // Optional: Redirect after closing
    window.location.href = "dashboard.html";
}

// Close modal on outside click
window.onclick = function(event) {
    const modal = document.getElementById('successModal');
    if (event.target === modal) {
        modal.style.display = 'none';
        window.location.href = "/frontend/students/dashboard/dashboard.html";
    }
}
