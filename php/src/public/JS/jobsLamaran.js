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

  showResponse('Form submitted successfully!', 'success');
}

// Display selected file names
document.getElementById('cv').addEventListener('change', function (e) {
  const fileName = e.target.files[0] ? e.target.files[0].name : 'Choose a file...';
  document.getElementById('cv-filename').textContent = fileName;
});

document.getElementById('video').addEventListener('change', function (e) {
  const fileName = e.target.files[0] ? e.target.files[0].name : 'Choose a file...';
  document.getElementById('video-filename').textContent = fileName;
});

function showResponse(message, type) {
  const responseDiv = document.getElementById('response');
  responseDiv.textContent = message;
}
