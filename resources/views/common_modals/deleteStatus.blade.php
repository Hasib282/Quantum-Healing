<div id="deleteStatusModal" class="modal-container">
    <div class="modal-subject" style="width: 40%; margin:10% auto;">
        <div class="modal-heading">
            <div class="center icon-center"><i class="fa-solid fa-circle-exclamation"></i></div>
            <h3 class="center">Are you sure?</h3>
            <span class="close-modal" data-modal-id="deleteStatusModal" style="top: 10px;">&times;</span>
        </div>
        <p class="center">Are you sure you want to delete this {{ $name }}?</p>
        <div class="center button">
            <button type="button" class="btn-blue"  id="confirm_status">Yes</button>
            <button type="button" class="btn-red" id="cancel_status" data-dismiss="modal">No</button>
        </div>
    </div>
</div>