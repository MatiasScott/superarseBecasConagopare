// Obtiene una referencia a los elementos select de cantón y parroquia
const cantonSelect = document.getElementById('canton_id');
const parishSelect = document.getElementById('parish_id');

if (cantonSelect && parishSelect) {
    const appBasePath = window.BASE_PATH || '/landingPage_BecasConagopare/public';

    // Agrega un 'escuchador' de eventos al select de cantones
    cantonSelect.addEventListener('change', async function() {
    // Obtiene el ID del cantón seleccionado
    const cantonId = this.value;

    // Si no se selecciona un cantón, reinicia el select de parroquias
    if (!cantonId) {
        parishSelect.innerHTML = '<option value="">Seleccione una parroquia</option>';
        parishSelect.disabled = true;
        return;
    }

    // Muestra un mensaje de carga mientras se obtienen los datos
    parishSelect.innerHTML = '<option value="">Cargando...</option>';
    parishSelect.disabled = true;

    try {
        // Realiza una petición fetch al servidor para obtener las parroquias
        const response = await fetch(`${appBasePath}/get-parishes?canton_id=${encodeURIComponent(cantonId)}`);

        // Si la respuesta no es exitosa (por ejemplo, un error 404 o 500)
        if (!response.ok) {
            throw new Error('La respuesta de la red no fue exitosa');
        }

        // Convierte la respuesta a formato JSON
        const parishes = await response.json();

        // Limpia el select de parroquias para llenarlo con los nuevos datos
        parishSelect.innerHTML = '<option value="">Seleccione una parroquia</option>';

        // Recorre los datos recibidos y crea una opción para cada parroquia
        parishes.forEach(parish => {
            const option = document.createElement('option');
            option.value = parish.id;
            option.textContent = parish.name;
            parishSelect.appendChild(option);
        });

        // Habilita el select de parroquias una vez que ha sido cargado
        parishSelect.disabled = false;

    } catch (error) {
        // Si hay un error, lo muestra en la consola y en el select de parroquias
        console.error('Error al obtener las parroquias:', error);
        parishSelect.innerHTML = '<option value="">Error al cargar</option>';
    }
    });
}