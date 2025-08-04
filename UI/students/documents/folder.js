function goToFolder(folderId) {
  window.location.href = `folder-content.html?folder=${folderId}`;
}

document.getElementById("uploadBtn").addEventListener("click", () => {
  document.getElementById("fileInput").click();
});

document.addEventListener('DOMContentLoaded', function () {
  const uploadBtn = document.getElementById('uploadBtn');
  const fileInput = document.getElementById('fileInput');
  const dropzone = document.getElementById('dropzone');

  // Show/hide dropzone
  uploadBtn.addEventListener('click', () => {
    fileInput.click();
  });

  // File input change handler
  fileInput.addEventListener('change', handleFileSelect);

  // Drag and drop functionality
  ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropzone.addEventListener(eventName, preventDefaults, false);
  });

  function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
  }

  ['dragenter', 'dragover'].forEach(eventName => {
    dropzone.addEventListener(eventName, highlight, false);
  });

  ['dragleave', 'drop'].forEach(eventName => {
    dropzone.addEventListener(eventName, unhighlight, false);
  });

  function highlight() {
    dropzone.classList.add('dropzone-active');
  }

  function unhighlight() {
    dropzone.classList.remove('dropzone-active');
  }

  dropzone.addEventListener('drop', handleDrop, false);
  dropzone.addEventListener('click', () => {
    fileInput.click();
  });

  function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    fileInput.files = files;
    handleFileSelect({ target: fileInput });
  }

  function handleFileSelect(event) {
    const files = event.target.files;
    if (files.length > 0) {
      alert(`Selected ${files.length} file(s) for upload. In a real implementation, these files would be uploaded to the server.`);
      console.log('Files selected:', files);

      // Reset the input
      event.target.value = '';
    }
  }

  // Toggle dropzone on drag enter/leave document
  document.addEventListener('dragenter', (e) => {
    if (e.target === document.documentElement) {
      dropzone.classList.remove('hidden');
    }
  });

  dropzone.addEventListener('dragleave', (e) => {
    if (!dropzone.contains(e.relatedTarget)) {
      dropzone.classList.add('hidden');
    }
  });

  dropzone.addEventListener('drop', (e) => {
    dropzone.classList.add('hidden');
  });
});