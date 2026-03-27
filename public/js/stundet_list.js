const searchInput = document.getElementById('tableSearch');
const table = document.getElementById('studentsTable');

searchInput.addEventListener('keyup', function () {
    const filter = this.value.toLowerCase();
    const rows = table.querySelectorAll('tbody tr');

    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(filter) ? '' : 'none';
    });
});