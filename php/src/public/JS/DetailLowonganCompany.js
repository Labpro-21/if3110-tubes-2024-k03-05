const deleteButton = document.getElementById('deleteButton');

deleteButton.addEventListener('click', () => {
    console.log('delete button clicked');

    const xhr = new XMLHttpRequest();
    xhr.open('DELETE', '/lowongan');
    xhr.setRequestHeader('Content-Type', 'application/json');

    const urlParams = new URLSearchParams(window.location.search);
    const lowonganid = urlParams.get('lowonganId');
    const params = {
        lowongan_id: lowonganid
    };

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                window.location.href = '/dashboard';
            } else {
                alert(xhr.responseText);
            }
        }
    };

    xhr.send(JSON.stringify(params));
});

const closeButton = document.getElementById('closeButton');
closeButton.addEventListener('click', () => {
    const xhr = new XMLHttpRequest();
    xhr.open('PUT', '/lowongan');
    xhr.setRequestHeader('Content-Type', 'application/json');

    const urlParams = new URLSearchParams(window.location.search);
    const lowonganid = urlParams.get('lowonganId');
    const params = {
        lowongan_id: lowonganid
    };

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                window.location.href = '/dashboard';
            } else if (xhr.status === 500) {
                alert(xhr.responseText);
            } else if (xhr.status === 403) {
                alert(xhr.responseText);
            }
        }
    };

    xhr.send(JSON.stringify(params));
});