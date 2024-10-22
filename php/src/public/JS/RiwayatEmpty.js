function setActiveButton(filter) {
    const buttons = document.querySelectorAll('.filter-buttons button');

    buttons.forEach(button => button.classList.remove('active'));

    document.querySelector(`.filter-buttons button[onclick="setActiveButton('${filter}')"]`).classList.add('active');
}

document.addEventListener('DOMContentLoaded', () => {
    setActiveButton('all');
});
