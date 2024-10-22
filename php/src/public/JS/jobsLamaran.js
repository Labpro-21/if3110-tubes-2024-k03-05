function handleSubmit(event) {
  event.preventDefault();

  const form = document.getElementById('applicantForm');
  const name = form.name.value.trim();
  const email = form.email.value.trim();
  const cvFile = form.cv.files[0];
  const videoFile = form.video.files[0];

  if (!name || !email || !cvFile || !videoFile) {
    showResponse('Please fill all fields and upload the required files.', 'error');
    return;
  }

  if (!cvFile.name.endsWith('.pdf')) {
    showResponse('Please upload a valid PDF for your CV.', 'error');
    return;
  }

  const formData = new FormData(this);
  const xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
    if (this.readyState === 4) {
      if (this.status === 200) {
        console.log('Response:', this.responseText);
        alert('Application submitted successfully!');
      } else {
        console.error('Error:', this.statusText);
        alert('Failed to submit application.');
      }
    }
  };

  xhttp.open("POST", "/submitApplication", true); // Adjust the endpoint URL as needed
  xhttp.send(formData);
}

// Display selected file names
document.getElementById('cv').addEventListener('change', function (e) {
  document.getElementById('cv-filename').textContent = e.target.files[0] ? e.target.files[0].name : 'Choose a file...';
});

document.getElementById('video').addEventListener('change', function (e) {
  document.getElementById('video-filename').textContent = e.target.files[0] ? e.target.files[0].name : 'Choose a file...';
});

function showResponse(message, type) {
  const responseDiv = document.getElementById('response');
  responseDiv.textContent = message;
}


