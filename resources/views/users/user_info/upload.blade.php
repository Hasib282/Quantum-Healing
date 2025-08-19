<div id="uploadModal" class="modal-container">
    <div class="modal-subject" style="width: 40%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Upload {{ $name }}</h3>
                <span class="close-modal" data-modal-id="uploadModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="CsvForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="form-input-group">
                <label for="file">Upload Excel File<span class="required">*</span></label>
                <input type="file" name="file" class="form-input" id="file">
                <span class="error" id="file_error"></span>
                <span class="error" id="count"></span>
            </div>
            
            <div class="center">
                <button type="submit" class="btn-blue" id="Upload">Upload</button>
            </div>
        </form>
    </div>
</div>
