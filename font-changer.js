document.addEventListener('DOMContentLoaded', function() {
    loadSavedFont();
});

function changeFont() {
    const fileInput = document.getElementById('font-upload');
    const file = fileInput.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const fontData = e.target.result;
            applyAndSaveFont(fontData);
            uploadFontToDatabase(file.name, fontData);
        };
        reader.readAsArrayBuffer(file);
    } else {
        alert('Please select a TTF file first.');
    }
}

function applyAndSaveFont(fontData) {
    const fontFace = new FontFace('CustomFont', fontData);

    fontFace.load().then(function(loadedFace) {
        document.fonts.add(loadedFace);
        document.body.style.fontFamily = 'CustomFont, sans-serif';
        
        // Save font data to local storage
        localStorage.setItem('customFont', arrayBufferToBase64(fontData));
    }).catch(function(error) {
        console.error('Error loading font:', error);
        alert('Error loading font. Please try another TTF file.');
    });
}

function loadSavedFont() {
    const savedFontData = localStorage.getItem('customFont');
    if (savedFontData) {
        const fontData = base64ToArrayBuffer(savedFontData);
        applyAndSaveFont(fontData);
    }
}

function resetFont() {
    localStorage.removeItem('customFont');
    location.reload();
}

function arrayBufferToBase64(buffer) {
    let binary = '';
    const bytes = new Uint8Array(buffer);
    for (let i = 0; i < bytes.byteLength; i++) {
        binary += String.fromCharCode(bytes[i]);
    }
    return window.btoa(binary);
}

function base64ToArrayBuffer(base64) {
    const binaryString = window.atob(base64);
    const len = binaryString.length;
    const bytes = new Uint8Array(len);
    for (let i = 0; i < len; i++) {
        bytes[i] = binaryString.charCodeAt(i);
    }
    return bytes.buffer;
}

function uploadFontToDatabase(fileName, fontData) {
    const base64Font = arrayBufferToBase64(fontData);

    // Realiza la solicitud al servidor
    fetch('guardar_fuente.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            name: fileName,
            fontBlob: base64Font
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Font uploaded and saved successfully!');
            } else {
                alert('Failed to upload font to database.');
            }
        })
        .catch(error => {
            console.error('Error uploading font:', error);
            alert('An error occurred while uploading the font.');
        });
}