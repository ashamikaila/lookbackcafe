// Newsletter Management JavaScript

function previewNewsletter() {
    const subject = document.getElementById('subject').value;
    const message = document.getElementById('message').value;
    
    if (!subject || !message) {
        alert('Please fill in both subject and message fields.');
        return;
    }
    
    document.getElementById('previewSubject').textContent = subject;
    document.getElementById('previewMessage').innerHTML = message.replace(/\n/g, '<br>');
    
    document.getElementById('previewModal').style.display = 'flex';
}

function closePreview() {
    document.getElementById('previewModal').style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('previewModal');
    if (event.target === modal) {
        closePreview();
    }
}