const form = document.getElementById('applicantForm');

form.addEventListener('submit', ((event) => {
  event.preventDefault();

  const name = form.name.value.trim();
  const email = form.email.value.trim();
  const cvFile = form.cv.files[0];
  const videoFile = form.video.files[0];

  // Add job_id to form
  const urlParams = new URLSearchParams(window.location.search);
  const jobId = urlParams.get('lowonganId');
  const jobIdInput = document.createElement('input');
  jobIdInput.setAttribute('type', 'hidden');
  jobIdInput.setAttribute('name', 'job_id');
  jobIdInput.setAttribute('value', jobId);
  form.appendChild(jobIdInput);

  if (!name || !email || !cvFile || !videoFile) {
    showResponse('Please fill all fields and upload the required files.', 'error');
    return;
  }

  if (!cvFile.name.endsWith('.pdf')) {
    showResponse('Please upload a valid PDF for your CV.', 'error');
    return;
  }

  const formData = new FormData(form);
  const xhttp = new XMLHttpRequest();


  xhttp.onreadystatechange = function() {
    if (this.readyState === 4) {
      if (this.status === 200) {
        console.log('Response:', this.responseText);
        alert('Application submitted successfully!');
        setTimeout(
            function() {
                window.location.href = '/dashboard';
            }, 1000
        )
      } else {
        console.error('Error:', this.statusText);
        alert('Failed to submit application.');
      }
    }
  };

  xhttp.open("POST", "/submitApplication", true);
  xhttp.send(formData);
}));

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