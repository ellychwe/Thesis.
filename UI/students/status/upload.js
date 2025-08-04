document.getElementById("openModalBtn").addEventListener("click", () => {
  document.getElementById("uploadModal").style.display = "block";
});

document.getElementById("closeModalBtn").addEventListener("click", () => {
  document.getElementById("uploadModal").style.display = "none";
});

window.onclick = function (event) {
  const modal = document.getElementById("uploadModal");
  if (event.target === modal) {
    modal.style.display = "none";
  }
};

// Show selected file name
document.getElementById("fileInput").addEventListener("change", function () {
  const fileName = this.files[0] ? this.files[0].name : "";
  document.getElementById("fileNamePreview").textContent = fileName;
});

// Upload handler
document.getElementById("uploadForm").addEventListener("submit", function (e) {
  e.preventDefault();
  const formData = new FormData(this);

  fetch("/upload/tdp-suc-form", {
    method: "POST",
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    alert("Upload successful!");
    document.getElementById("uploadModal").style.display = "none";
    // Optionally reload or update DOM
  })
  .catch(error => {
    alert("Upload failed.");
    console.error(error);
  });
});

