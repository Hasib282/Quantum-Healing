$(document).ready(function () {
    // General function to calculate total amount
    $(document).off('keyup', '#quantity, .amount').on('keyup', '#quantity, .amount', function (e) {
        let quantity = $('#quantity').val();
        let amount = $('.amount').val();
        let totalAmount = quantity * amount;
        $('#totAmount').val(totalAmount);
    });


    $(document).off('keyup', '#updateQuantity, .updateAmount').on('keyup', '#updateQuantity, .updateAmount', function (e) {
        let quantity = $('#updateQuantity').val();
        let amount = $('.updateAmount').val();
        let totalAmount = quantity * amount;
        $('#updateTotAmount').val(totalAmount);
    });


    $(document).off('keyup', '#totalDiscount, #advance').on('keyup', '#totalDiscount, #advance', function (e) {
        // Calculate total discount
        let amountRP = parseInt($('#amountRP').val());
        let totalDiscount = parseInt($('#totalDiscount').val());
        let advance = parseInt($('#advance').val());

        let netAmount = amountRP - totalDiscount;
        let balance = netAmount - advance;

        $('#netAmount').val(netAmount);
        $('#balance').val(balance);
    });


    $(document).off('keyup', '#updateTotalDiscount, #updateAdvance').on('keyup', '#updateTotalDiscount, #updateAdvance', function (e) {
        // Calculate total discount
        let amountRP = parseInt($('#updateAmountRP').val());
        let totalDiscount = parseInt($('#updateTotalDiscount').val());
        let advance = parseInt($('#updateAdvance').val());

        let netAmount = amountRP - totalDiscount;
        let balance = netAmount - advance;

        $('#updateNetAmount').val(netAmount);
        $('#updateBalance').val(balance);
    });
});