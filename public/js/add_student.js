const programSelect = document.getElementById('program');
const scholarshipPreview = document.getElementById('scholarship-preview');

const programs30Percent = [
    'Tecnología Superior en Topografía',
    'Tecnólogo en Minería',
    'Tecnología Superior en Enfermería Veterinaria',
    'Tecnólogo en Producción Animal'
];

programSelect.addEventListener('change', function () {
    if (programs30Percent.includes(this.value)) {
        scholarshipPreview.value = '30%';
    } else if (this.value) {
        scholarshipPreview.value = '20%';
    } else {
        scholarshipPreview.value = '';
    }
});