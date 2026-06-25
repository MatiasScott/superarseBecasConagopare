const modal = document.getElementById('studentModal');
const studentIdInput = document.getElementById('modal-student-id');
const fullNameInput = document.getElementById('modal-full-name');
const statusSelect = document.getElementById('modal-status');
const searchInput = document.getElementById('tableSearch');
const table = document.getElementById('studentsTable');

function openModal(student) {
    if (!modal || !studentIdInput || !fullNameInput || !statusSelect) {
        return;
    }

    studentIdInput.value = student.id;

    // Construir nombre completo sin valores vacíos
    const fullName = [
        student.first_name,
        student.second_name,
        student.first_last_name,
        student.second_last_name
    ].filter(Boolean).join(' ');

    fullNameInput.value = fullName;

    statusSelect.value = student.status;
    modal.classList.remove('hidden');
}

function closeModal() {
    if (!modal) {
        return;
    }

    modal.classList.add('hidden');
}

if (searchInput && table) {
    searchInput.addEventListener('keyup', function () {
        const filter = this.value.toLowerCase();
        const rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
}