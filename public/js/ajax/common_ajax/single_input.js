function SingleInputDataCrudeAjax(link, RenderData){
    // Load Data on Hard Reload
    ReloadData(link, RenderData);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#name");


    // Insert Ajax
    InsertAjax(link, {company: { selector: "#company", attribute: 'data-id' }}, function() {
        $('#name').focus();
    });


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax(link);
    

    // Delete Ajax
    DeleteAjax(link);
    
    
    // Delete Status Ajax
    DeleteStatusAjax(link);
}