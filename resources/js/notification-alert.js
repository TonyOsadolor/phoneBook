document.addEventListener('livewire:init', () => {
    // On Success
    Livewire.on('success', (event) => {
        event.forEach(function(element){
            Swal.fire({
                title: element.title,
                text: element.message,
                icon: element.status,
                allowOutsideClick: false,
            });
        });
    });

    // On Error
    Livewire.on('error', (event) => {
        event.forEach(function(element){
            Swal.fire({
                title: element.title,
                text: element.message,
                icon: 'error',
                allowOutsideClick: false,
            });
        });
    });

    // On Info
    Livewire.on('info', (event) => {
        event.forEach(function(element){
            Swal.fire({
                title: element.title,
                text: element.message,
                icon: 'info',
                allowOutsideClick: false,
            });
        });
    });

    // On Warning
    Livewire.on('warning', (event) => {
        event.forEach(function(element){
            Swal.fire({
                title: element.title,
                text: element.message,
                icon: 'warning',
                allowOutsideClick: false,
            });
        });
    });

    // On Question
    Livewire.on('question', (event) => {
        event.forEach(function(element){
            Swal.fire({
                title: element.title,
                text: element.message,
                icon: 'question',
                allowOutsideClick: false,
            });
        });
    });
});