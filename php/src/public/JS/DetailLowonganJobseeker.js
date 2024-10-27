const urlParams = new URLSearchParams(window.location.search);
const lowonganId = urlParams.get('lowonganId');

const applyButton = document.getElementById('applyButton');
applyButton.addEventListener('click', async () => {
    window.location.href = '/lamaran?lowonganId=' + lowonganId;
});