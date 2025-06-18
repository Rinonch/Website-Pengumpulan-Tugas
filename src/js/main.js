document.addEventListener('DOMContentLoaded', function() {
    const uploadForm = document.getElementById('uploadForm');
    const fileInput = document.getElementById('fileInput');
    const fileList = document.getElementById('fileList');

    // Form submission event
    if (uploadForm) {
        uploadForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const files = fileInput.files;
            if (files.length > 0) {
                displayFiles(files);
            } else {
                alert('Please select a file to upload.');
            }
        });
    }

    // Function to display uploaded files
    function displayFiles(files) {
        fileList.innerHTML = '';
        for (let i = 0; i < files.length; i++) {
            const listItem = document.createElement('li');
            listItem.textContent = files[i].name;
            fileList.appendChild(listItem);
        }
    }
});