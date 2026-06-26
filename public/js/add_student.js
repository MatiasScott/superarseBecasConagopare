const programSelect = document.getElementById('program');
const scholarshipPreview = document.getElementById('scholarship-preview');
const convenioCheckbox = document.getElementById('is_convenio');
const convenioFields = document.getElementById('convenio-fields');
const convenioNameInput = document.getElementById('convenio_name');
const convenioPercentageInput = document.getElementById('convenio_percentage');
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

function updateScholarshipPreview() {
    if (!scholarshipPreview) {
        return;
    }

    if (convenioCheckbox && convenioCheckbox.checked) {
        const convenioValue = convenioPercentageInput ? convenioPercentageInput.value : '';
        scholarshipPreview.value = convenioValue ? formatPercentageValue(convenioValue) : '';
        return;
    }

    if (!programSelect) {
        scholarshipPreview.value = '';
        return;
    }

    const selectedProgram = programSelect.value;
    if (!selectedProgram) {
        scholarshipPreview.value = '';
        return;
    }

    const configuredValue = configuredScholarships[selectedProgram];
    scholarshipPreview.value = configuredValue !== undefined
        ? formatPercentageValue(configuredValue)
        : '20%';
}

function toggleConvenioFields() {
    if (!convenioCheckbox || !convenioFields) {
        return;
    }

    const isConvenio = convenioCheckbox.checked;
    convenioFields.classList.toggle('hidden', !isConvenio);

    if (convenioNameInput) {
        convenioNameInput.required = isConvenio;
    }
    if (convenioPercentageInput) {
        convenioPercentageInput.required = isConvenio;
    }

    updateScholarshipPreview();
}

if (programSelect && scholarshipPreview) {
    programSelect.addEventListener('change', function () {
        updateScholarshipPreview();
    });
}

if (convenioCheckbox) {
    convenioCheckbox.addEventListener('change', toggleConvenioFields);
}

if (convenioPercentageInput) {
    convenioPercentageInput.addEventListener('input', updateScholarshipPreview);
}

toggleConvenioFields();
updateScholarshipPreview();