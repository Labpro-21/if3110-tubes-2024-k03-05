const statusText = document.getElementById('statusText');
const followUpReason = document.getElementById('followUpReason');
const reasonText = document.getElementById('reasonText');
const reasonInput = document.getElementById('reasonInput').value;

function updateStatus(status) {
  if (status === 'accepted') {
    statusText.textContent = 'Approved';
    statusText.className = 'status approved';
    followUpReason.style.display = 'block';
    reasonText.textContent = reasonInput || 'Lamaran Anda telah disetujui.';
  } else if (status === 'rejected') {
    statusText.textContent = 'Rejected';
    statusText.className = 'status rejected';
    followUpReason.style.display = 'block';
    reasonText.textContent = reasonInput || 'Tidak ada alasan yang diberikan.';
  }
}

function submitReason(status) {

  // AJAX request to update status on the server
  const xhr = new XMLHttpRequest();
  xhr.open('POST', '/updateLamaranStatus', true);

  xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        console.log('Status updated successfully:', xhr.responseText);
        showToast('Status updated successfully', 'success');
        setTimeout(
            () => {
                window.location.reload();
            }, 1000
        )
      } else {
        console.error('Error updating status:', xhr.statusText);
        showToast('Error updating status', 'error');
      }
    }
  };

  const url = new URL(window.location.href);
  const lamaranid = url.searchParams.get('lamaran_id');

  xhr.send(JSON.stringify({
    lamaranId: lamaranid,
    status: status,
    reason: reasonInput
  }));
}

function toggleReasonInput() {
  const reasonForm = document.getElementById('reasonForm');
  reasonForm.style.display = reasonForm.style.display === 'none' ? 'block' : 'none';
}

function showToast(message, type) {
  const toast = document.getElementById('toast');
  toast.textContent = message;
  toast.className = `toast show ${type}`;
  setTimeout(() => {
    toast.className = toast.className.replace('show', '');
  }, 3000);
}