// Agrega el event listener para el botón de cerrar
document.addEventListener('DOMContentLoaded', function() {
  const modal = document.getElementById('successModal');
  const closeModalBtn = document.getElementById('closeModalBtn');

  if (modal && closeModalBtn) {
    closeModalBtn.addEventListener('click', () => {
      modal.classList.add('hidden');
    });
  }
});