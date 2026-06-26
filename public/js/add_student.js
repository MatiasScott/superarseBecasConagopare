const programSelect = document.getElementById('program');
const scholarshipPreview = document.getElementById('scholarship-preview');
const configuredScholarships = window.PROGRAM_SCHOLARSHIPS || {};

function formatPercentageValue(value) {
    const numberValue = Number(value);
    if (Number.isNaN(numberValue)) {
        return '20%';
    }

    const normalized = Number.isInteger(numberValue)
        ? numberValue.toString()
        : numberValue.toFixed(2).replace(/\.0+$/, '').replace(/(\.\d*[1-9])0+$/, '$1');

    return normalized + '%';
}

if (programSelect && scholarshipPreview) {
    programSelect.addEventListener('change', function () {
        const selectedProgram = this.value;

        if (!selectedProgram) {
            scholarshipPreview.value = '';
            return;
        }

        const configuredValue = configuredScholarships[selectedProgram];
        scholarshipPreview.value = configuredValue !== undefined
            ? formatPercentageValue(configuredValue)
            : '20%';
    });
}