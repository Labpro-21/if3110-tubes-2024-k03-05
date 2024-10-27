const statusText = document.getElementById('statusText');
const followUpReason = document.getElementById('followUpReason');
const reasonInputA = document.getElementById('reasonInputA');
const reasonInputR = document.getElementById('reasonInputR');




function updateStatus(status) {
  if (status === 'accepted') {
    statusText.textContent = 'Approved';
    statusText.className = 'status approved';
    followUpReason.style.display = 'block';
  } else if (status === 'rejected') {
    statusText.textContent = 'Rejected';
    statusText.className = 'status rejected';
    followUpReason.style.display = 'block';
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
    reason: status === 'accepted' ? reasonInputA.value : reasonInputR.value
  }));
}

const reasonFormA = document.getElementById('reasonFormA');
const reasonFormR = document.getElementById('reasonFormR');
const approveButton = document.querySelector('.btn-approve');
const rejectButton = document.querySelector('.btn-reject');

function toggleReasonInputA() {
    reasonFormA.style.display = reasonFormA.style.display === 'none' ? 'block' : 'none';
    reasonFormR.style.display = 'none';
    
    approveButton.classList.toggle('active', reasonFormA.style.display === 'block');
    rejectButton.classList.remove('active');
}

function toggleReasonInputR() {
    reasonFormR.style.display = reasonFormR.style.display === 'none' ? 'block' : 'none';
    reasonFormA.style.display = 'none';

    rejectButton.classList.toggle('active', reasonFormR.style.display === 'block');
    approveButton.classList.remove('active');
}

function showToast(message, type) {
  const toast = document.getElementById('toast');
  toast.textContent = message;
  toast.className = `toast show ${type}`;
  setTimeout(() => {
    toast.className = toast.className.replace('show', '');
  }, 3000);
}