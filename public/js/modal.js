$(document).ready(function () {
    $(document).on('click','.open-modal',function(){
        let modalId = $(this).data('modal-id');
        var modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
        }
    });
    
    $(document).on('click','.close-modal',function(){
        let modalId = $(this).data('modal-id');
        var modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
        }
    });
    

    // Close modal if clicked outside the modal
    // window.addEventListener('click', function (event) {
    //     if (event.target.classList.contains('modal-container')) {
    //         event.target.style.display = 'none';
    //     }
    // });
});