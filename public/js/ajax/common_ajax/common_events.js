/////////////// ------------------ Details Grid Toggle Functionality Ajax Part Start ---------------- /////////////////////////////
function GridAjax(link) {
    $(document).off('click', '#showGrid').on('click', '#showGrid', function (e) {
        let id = $(this).attr('data-id');
        let grid = $(`#grid${id}`);
        let arrow = $(this).find('.fa-chevron-circle-right');
        
        if (grid.is(':visible')) {
            grid.hide();
            arrow.removeClass('rotate');
        }
        else {
            $.ajax({
                url: `${apiUrl}/${link}/grid`,
                method: 'GET',
                data: { id },
                success: function (res) {
                    grid.html(res.data);
                    grid.show();
                    arrow.addClass('rotate');
                }
            });
        }
    });
};


$(document).ready(function () {
    //////////////////// --------------------- Show Image When Select File ---------------- /////////////////////
    $(document).on('change','#image', function (e){
        let path = $(this).val();
        let extension = path.substring(path.lastIndexOf('.')+1).toLowerCase();
        
        if(extension == 'jpg' || extension == 'jpeg' || extension == 'png' || extension == 'gif'){
            var file = e.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
            else{
                $('#previewImage').attr('src', "/images/male.png");
            }
        }
        else{
            $('#previewImage').attr('src', "/images/male.png");
        }
    });


    //////////////////// --------------------- Show Update Image When Select File ---------------- /////////////////////
    $(document).on('change','#updateImage', function (e){
        let path = $(this).val();
        let extension = path.substring(path.lastIndexOf('.')+1).toLowerCase();
        
        if(extension == 'jpg' || extension == 'jpeg' || extension == 'png' || extension == 'gif'){
            var file = e.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#updatePreviewImage').attr('src', " ");
                    $('#updatePreviewImage').attr('src', e.target.result).show();
                };
                reader.readAsDataURL(file);
            }
            else{
                $('#updatePreviewImage').attr('src', "/images/male.png");
            }
        }
        else{
            $('#updatePreviewImage').attr('src', "/images/male.png");
        }
    });




    /////////////// ------------------ User Details List Toggle Functionality Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '.details li', function(e){
        let id = $(this).attr('data-id');
        if(id == 1){
            if($('.general').is(':visible')){
                $('.general').hide()
            }
            else{
                $('.general').show();
            }
        }
        else if(id == 2){
            if($('.contact').is(':visible')){
                $('.contact').hide()
            }
            else{
                $('.contact').show();
            }
        }
        else if(id == 3){
            if($('.address').is(':visible')){
                $('.address').hide()
            }
            else{
                $('.address').show();
            }
        }
        else if(id == 4){
            if($('.transaction').is(':visible')){
                $('.transaction').hide()
            }
            else{
                $('.transaction').show();
            }
        }
        else if(id == 5){
            if($('.others').is(':visible')){
                $('.others').hide()
            }
            else{
                $('.others').show();
            }
        }
        // Employee Details
        else if(id == 1.1){
            if($('.personal').is(':visible')){
                $('.personal').hide()
            }
            else{
                $('.personal').show();
            }
        }
        else if(id == 1.2){
            if($('.education').is(':visible')){
                $('.education').hide()
            }
            else{
                $('.education').show();
            }
        }
        else if(id == 1.3){
            if($('.training').is(':visible')){
                $('.training').hide()
            }
            else{
                $('.training').show();
            }
        }
        else if(id == 1.4){
            if($('.experience').is(':visible')){
                $('.experience').hide()
            }
            else{
                $('.experience').show();
            }
        }
        else if(id == 1.5){
            if($('.organization').is(':visible')){
                $('.organization').hide()
            }
            else{
                $('.organization').show();
            }
        }
        else if(id == 1.6){
            if($('.payroll').is(':visible')){
                $('.payroll').hide()
            }
            else{
                $('.payroll').show();
            }
        }
    }); // End Toggle  Event
    /////////////// ------------------ User Details List Toggle Functionality Ajax Part End ---------------- /////////////////////////////





    //////////////////// -------------------- Logout Button Click Event Start -------------------- ////////////////////
    $(document).on('click', '#logout', function (e) {
        e.preventDefault();
        $.ajax({
            url: `${apiUrl}/logout`,
            type: 'POST',
            success: function() {
                localStorage.removeItem('token');
                window.location.href = '/login';
            }
        });
    }); // End Logout Event
    //////////////////// -------------------- Logout Button Click Event End -------------------- ////////////////////
});