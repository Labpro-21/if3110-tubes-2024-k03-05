function updateStatus(status) {
  console.log(status)

  const statusText = document.getElementById('statusText');
  const followUpReason = document.getElementById('followUpReason');
  const reasonText = document.getElementById('reasonText');
  const reasonInput = document.getElementById('reasonInput').value;

  // AJAX request to update status on the server
  const xhr = new XMLHttpRequest();
  xhr.open('POST', '/updateLamaranStatus', true);
  xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        console.log('Status updated successfully:', xhr.responseText);
      } else {
        console.error('Error updating status:', xhr.statusText);
      }
    }
  };

  const url = new URL(window.location.href);
  const lamaranid = url.searchParams.get('id');
  // Send the request with the status and reason

  xhr.send(JSON.stringify({
    lamaranId: lamaranid,
    status: status,
    reason: reasonInput
  }));


  if (status === 'accepted') {
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