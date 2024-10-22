const dummyData = {
  name: "John Doe",
  email: "john.doe@example.com",
  cv: "dummy-cv.pdf",
  video: "dummy-video.mp4",
  status: "waiting"
};

// Populate HTML with dummy data
document.querySelector('.pelamar-name').textContent = dummyData.name;
document.querySelector('.pelamar-email').textContent = dummyData.email;
document.querySelector('.cv-viewer').src = dummyData.cv;
document.querySelector('.video-viewer').querySelector('source').src = dummyData.video;
document.querySelector('#statusText').textContent = dummyData.status.charAt(0).toUpperCase() + dummyData.status.slice(1);
document.getElementById('statusText').className = 'status ' + dummyData.status;

// Conditionally display buttons based on status
if (dummyData.status === 'approved' || dummyData.status === 'rejected') {
  document.querySelector('.btn-group').style.display = 'none';
}

function updateStatus(status) {
  const statusText = document.getElementById('statusText');
  const followUpReason = document.getElementById('followUpReason');
  const reasonText = document.getElementById('reasonText');
  const reasonInput = document.getElementById('reasonInput').value;

  if (status === 'approved') {
    statusText.textContent = 'Approved';
    statusText.className = 'status approved';
    followUpReason.style.display = 'block';
    reasonText.textContent = 'Lamaran Anda telah disetujui.';
  } else if (status === 'rejected') {
    statusText.textContent = 'Rejected';
    statusText.className = 'status rejected';
    followUpReason.style.display = 'block';
    reasonText.textContent = reasonInput || 'Tidak ada alasan yang diberikan.';
  }

  // Hide action buttons and reason form after action is taken
  document.getElementById('actionSection').style.display = 'none';
}

function toggleReasonInput() {
  const reasonForm = document.getElementById('reasonForm');
  reasonForm.style.display = reasonForm.style.display === 'none' ? 'block' : 'none';
}