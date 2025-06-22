function previewFoto(event) {
    const input = event.target;
    const previewContainer = document.getElementById('foto-preview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            previewContainer.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
        };

        reader.readAsDataURL(input.files[0]);
    }
}
