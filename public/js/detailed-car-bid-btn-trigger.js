const bidInput = document.getElementById('bid-input');
const bidButton = document.getElementById('bid-button');

if (bidInput) {
    // Show/hide the BID button and format the typed value with a thousands
    // separator (e.g. 22399 -> 22.399) for readability.
    bidInput.addEventListener('input', function () {
        const digits = bidInput.value.replace(/\D/g, '');
        // Insert a dot as a thousands separator every 3 digits from the right.
        bidInput.value = digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

        if (bidInput.value.trim() !== '') {
            bidButton.removeAttribute('hidden');
        } else {
            bidButton.setAttribute('hidden', 'true');
        }
    });

    // Strip the separators right before submitting so the server receives a
    // plain integer (the bid validation expects an integer value).
    const bidForm = bidInput.closest('form');
    if (bidForm) {
        bidForm.addEventListener('submit', function () {
            bidInput.value = bidInput.value.replace(/\D/g, '');
        });
    }
}
