<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url("styles/jquery-ui.css") ?>" type="text/css" media="screen">
<!-- Start Banner -->
<style>
    input {
        height: 30px;
    }
    .loading_player {
    background-color: #fff;
    background-image: url('./images/ajax-loader1.gif');
    background-size: 25px 25px;
    background-position: right center;
    background-repeat: no-repeat;
}.row {
    flex-wrap: nowrap;
}
.bc {
    background-color: rgb(236, 228, 228);
}
</style>
<div class="banner" id="banner" style="height: 90px">
    <div class="row">
        <div class="banner-inner columns">
            <h1 class="banner-title">Add Inventory</h1>
        </div>
    </div>
</div>
<main id="main">
    <div class="row main-inner" style="margin-left: 20px;">
        <form name="addListingForm" id="addListingForm" method="POST">
            <div class="col-md-2">
                <label for="field1" class="form-label">Vendor Name</label>
                <input type="text" class="form-control" id="vendor_name" placeholder="" name="vendor_name"
                    value="">
            </div>
            <div class="col-md-2">
                <label for="field1" class="form-label">Invoice Number</label>
                <input type="text" class="form-control" id="invoice_id" placeholder="" name="invoice_id" value="">
            </div>
            <div class="container mt-6">
                <div id="row_1" class="row mb-3 align-items-center">
                    <div class="col-md-2">
                        <label for="field1" class="form-label">Item</label>
                        <input type="text" class="item_name form-control" id="item_name" placeholder="" name="item_name[]"
                            value="" autocomplete="off">
                        <input type="hidden" class="item_id" id="item_id" placeholder="" name="item_id[]"
                            value="" autocomplete="off">   
                    </div>
                    <div class="col-md-1">
                        <label for="field2" class="form-label">Unit</label>
                        <input type="text" class="form-control unit bc" id="unit" placeholder="" name="unit[]" value="" autocomplete="off" readonly>
                    </div>
                    <div class="col-md-1" style="width: 120px;">
                        <label for="field2" class="form-label">HSN</label>
                        <input type="text" class="form-control hsd_code bc" id="hsd_code" placeholder="" name="HSN_code[]"
                            value="" autocomplete="off" readonly>
                    </div>
                    <div class="col-md-1">
                        <label for="field2" class="form-label">SGST</label>
                        <input type="text" class="form-control sgst_tax_rate bc" id="sgst_tax_rate" placeholder="" name="sgst_tax_rate[]" value="" autocomplete="off" readonly>
                    </div>
                    <div class="col-md-1">
                        <label for="field2" class="form-label">CGST</label>
                        <input type="text" class="form-control cgst_tax_rate bc" id="cgst_tax_rate" placeholder="" name="cgst_tax_rate[]" value="" autocomplete="off" readonly>
                    </div>
                    <div class="col-md-1">
                        <label for="field2" class="form-label">QTY</label>
                        <input type="text" class="form-control qty" id="qty" placeholder="" name="quantity[]" value="" autocomplete="off">
                    </div>
                  
                    <div class="col-md-1">
                        <label for="field3" class="form-label">Buy Price</label>
                        <input type="text" class="form-control buy_price" id="buy_price" placeholder="" name="buy_price[]"
                            value="" autocomplete="off">
                    </div>
                    <div class="col-md-1" style="width: 120px;">
                        <label for="field3" class="form-label">SGST Value</label>
                        <input type="text" class="form-control sgst_tax_value bc" id="sgst_tax_value" placeholder="" name="sgst_tax_value[]" value="" autocomplete="off" readonly>
                    </div>
                    <div class="col-md-1" style="width: 120px;">
                        <label for="field3" class="form-label">CGST Value</label>
                        <input type="text" class="form-control cgst_tax_value bc" id="cgst_tax_value" placeholder="" name="cgst_tax_value[]" value="" autocomplete="off" readonly>
                    </div>
                    <!-- <div class="col-md-1">
                        <label for="field3" class="form-label" title="Base Price without tax">B. Price</label>
                        <input type="text" class="form-control base_price" id="base_price" placeholder="" name="base_price[]"
                            value="" autocomplete="off">
                    </div> -->
                    

                    <div class="col-md-1">
                        <label for="field3" class="form-label">MRP</label>
                        <input type="text" class="form-control mrp_price" id="mrp_price" placeholder="" name="mrp_price[]"
                            value="" autocomplete="off">
                    </div>
                    <div class="col-md-1">
                        <label for="field3" class="form-label">Net value</label>
                        <input type="text" class="form-control net_value bc" id="net_value" placeholder=""
                            name="net_value[]" value="" autocomplete="off" readonly>
                    </div>
                  
                </div>

                <!-- Submit Button -->
                <div class="row">

                    <div class="col-md-2">

                        <button id="add_row" class="btn btn-primary" type="button">Add Row</button>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>

                </div>


            </div>
        </form>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- ****************************** -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
<script src="https://grading.beckett.com/webroot/js/bas_js/jquery-ui.js"></script>

<script>

    $().ready(function () {

        $("#addListingForm").validate({
            rules: {
                vendor_name: {
                    required: true
                },
                invoice_id: {
                    required: true
                },
                'item_name[]': {
                    required: true
                },
                'quantity[]': {
                    required: true
                },
                'buy_price[]': {
                    required: true
                },
                "mrp_price[]": {
                    required: true
                }

            },

            messages: {

                vendor_name: {
                    required: " Please enter vendor name"

                },
                invoice_id: {
                    required: " Please enter invoice number"

                },
                confirm_item_HSN_code: {
                    required: " Please enter a HSN code",
                    minlength: " Your HSN code must be consist of at least 3 characters",
                    equalTo: " Please enter the same HSN code "
                },
                price: {
                    required: " Please enter item price",
                    number: " Please enter valid price"
                },
                quantity: {
                    required: " Please enter item quantity",
                    number: " Please enter valid quantity"
                }


            },
            submitHandler: function (form) {
                var formData = $("#addListingForm").serialize();


                $.ajax({
                    type: "POST",
                    url: "<?= base_url() . 'add-inventory'; ?>",
                    cache: false,
                    data: formData,
                    success: function (b) {
                        var c = $.parseJSON(b);
                        console.log(c);
                        if (c.status == 1) {
                            $('#addListingForm').trigger("reset");
                            //alert(c.message);
                            window.location.href = c.URL;
                        } else {
                            alert(c.message);

                        }
                    },
                    error: function (b, d, c) {
                        alert("Error: There is some problem in processing. Please try again");
                    },
                });
            }
        });

        $("#add_row").click(function () {
            var div_count = $('#row_1').parent().children().length;
            var currnet_div = div_count - 1;
            $('#row_'+currnet_div).after('<div id="row_'+div_count+'" class="row mb-3 align-items-center"><div class="col-md-2"><input type="text" class="required item_name form-control " id="item_name" placeholder="" name="item_name[]" value="" autocomplete="off"><input type="hidden" class="item_id" id="item_id" name="item_id[]" > </div><div class="col-md-1"><input type="text" class="form-control unit bc" id="unit" placeholder="" name="unit[]" value="" autocomplete="off" readonly></div><div class="col-md-1" style="width: 120px;"><input type="text" class="form-control hsd_code bc" id="hsd_code" placeholder="" name="HSN_code[]" value="" autocomplete="off" readonly></div><div class="col-md-1"><input type="text" class="form-control sgst_tax_rate bc" id="sgst_tax_rate" placeholder="" name="sgst_tax_rate[]" value="" autocomplete="off" readonly></div><div class="col-md-1"><input type="text" class="form-control cgst_tax_rate bc" id="cgst_tax_rate" placeholder="" name="cgst_tax_rate[]" value="" autocomplete="off" readonly></div><div class="col-md-1"><input type="text" class="form-control qty" id="qty" placeholder="" name="quantity[]" value="" autocomplete="off"></div><div class="col-md-1"><input type="text" class="form-control buy_price" id="buy_price" placeholder="" name="buy_price[]" value="" autocomplete="off"></div><div class="col-md-1" style="width: 120px;"><input type="text" class="form-control sgst_tax_value bc" id="sgst_tax_value" placeholder="" name="sgst_tax_value[]" value="" autocomplete="off" readonly></div><div class="col-md-1" style="width: 120px;"><input type="text" class="form-control cgst_tax_value bc" id="cgst_tax_value" placeholder="" name="cgst_tax_value[]" value="" autocomplete="off" readonly></div><div class="col-md-1"><input type="text" class="form-control mrp_price" id="mrp_price" placeholder="" name="mrp_price[]" value="" autocomplete="off"></div><div class="col-md-1"><input type="text" class="form-control net_value bc" id="net_value" placeholder="" name="net_value[]" value="" autocomplete="off" readonly></div><div class="col-md-1"><span class="input-group-btn"><button class="remove_row btn btn-danger" type="button" id="remove_row_'+div_count+'">Remove</button></span></div></div>');
            $("#addListingForm").validate();
        });
        //  create function to add multiple row  in in one click 
    
        
        $(document).on("click", ".remove_row", function () {
            var current_id = $(this).attr('id');
            var split_id = current_id.split('_');
            var delete_id = split_id[2];
            $('#row_' + delete_id).remove();
        });

        $('.net_value').keypress(function (e) {
            var key = e.which;
            if (key == 13)  // the enter key code
            {
                //   $('#row_1').append('<div id="row_2" class="row mb-3 align-items-center"><div class="col-md-2"><label for="field1" class="form-label"></label><input type="text" class="form-control" id="field1" placeholder=""></div><div class="col-md-1"><label for="field2" class="form-label"></label><input type="text" class="form-control" id="field2" placeholder=""></div><div class="col-md-1"><label for="field2" class="form-label"></label><input type="text" class="form-control" id="field2" placeholder=""></div><div class="col-md-1"><label for="field2" class="form-label"></label><input type="text" class="form-control" id="field2" placeholder=""></div><div class="col-md-1"><label for="field3" class="form-label"></label><input type="text" class="form-control" id="field3" placeholder=""></div><div class="col-md-1"><label for="field3" class="form-label"></label><input type="text" class="form-control" id="field3" placeholder=""></div><div class="col-md-1"><label for="field3" class="form-label"></label><input type="text" class="form-control" id="field3" placeholder=""></div><div class="col-md-1"><label for="field3" class="form-label"></label><input type="text" class="form-control" id="field3" placeholder=""></div><div class="col-md-1"><label for="field3" class="form-label"></label><input type="text" class="form-control" id="field3" placeholder=""></div><div class="col-md-1"><label for="field3" class="form-label"></label><input type="text" class="form-control" id="field3" placeholder=""></div></div>');

                return false;
            }
        });
        // create a function to  calculate 5.3 tax value in total value 1300, tax value already added in total value 


        // $(document).on("keyup", ".mrp", function () {
        //     var current_obj = $(this);
        //     var mrp_price = $(current_obj).val();
        //     var tax_rate = $(current_obj).parent().parent().children().find('.tax_rate').val();
        //     var val = calculateTaxIncluded(mrp_price, tax_rate);
        //     $(current_obj).parent().parent().children().find('.tax_value').val(val.taxAmount);
        //     $(current_obj).parent().parent().children().find('.base_price').val(val.netValue);
        // });

        // function calculateTaxIncluded(totalValue, taxRate) {
        //     let taxAmount = (totalValue * taxRate) / (100 + taxRate);
        //     let netValue = totalValue - taxAmount;

        //     return {
        //         taxAmount: taxAmount.toFixed(2),
        //         netValue: netValue.toFixed(2)
        //     };
        // }

        $(document).on("keyup", ".buy_price", function () {
            var current_obj = $(this);
            var buy_price = $(current_obj).val();
            var sgst_tax_rate = $(current_obj).parent().parent().children().find('.sgst_tax_rate').val();
            var cgst_tax_rate = $(current_obj).parent().parent().children().find('.cgst_tax_rate ').val();
            
            console.log(buy_price);
            console.log(sgst_tax_rate);
            console.log(cgst_tax_rate);
            var sgst_tax_val = calculateTax(buy_price, sgst_tax_rate);
            var cgst_tax_val = calculateTax(buy_price, cgst_tax_rate);
            $(current_obj).parent().parent().children().find('.sgst_tax_value').val(sgst_tax_val);
            $(current_obj).parent().parent().children().find('.cgst_tax_value').val(cgst_tax_val);

            var qty =  $(current_obj).parent().parent().children().find('.qty').val();
            var val = qty * (parseInt(buy_price) + parseInt(cgst_tax_val) + parseInt(sgst_tax_val));
            if(isNaN(val) == true){
                val = '';
            }
            $(current_obj).parent().parent().children().find('.net_value').val(val);
           
        });
        
        // create a function to calculate tax value on buy_price
        function calculateTax(buy_price, tax_rate) {
                if (isNaN(buy_price) || isNaN(tax_rate)) {
                    console.error("Invalid input: buy_price and tax_rate must be numbers.");
                    return 0;
                }
                return (buy_price * tax_rate) / 100;
            }



        // functon on qty  key up, multiply qty with base price and set value in net value
        $(document).on("keyup", ".qty", function () {
            var current_obj = $(this);
            var qty =  $(current_obj).parent().parent().children().find('.qty').val();
            var buy_price = $(current_obj).parent().parent().children().find('.buy_price').val();
           //  var tax_value = $(current_obj).parent().parent().children().find('.tax_value').val();
            var sgst_tax_value = $(current_obj).parent().parent().children().find('.sgst_tax_value').val();
            var cgst_tax_value = $(current_obj).parent().parent().children().find('.cgst_tax_value').val();
            var val = qty * (parseInt(buy_price) + parseInt(sgst_tax_value) + parseInt(cgst_tax_value));
            if(isNaN(val) == true){
                val = '';
            }
            $(current_obj).parent().parent().children().find('.net_value').val(val);
        });

        $(document).on("keyup ", ".item_name", function () {
            var current_obj = $(this);
            $(current_obj).autocomplete({
                minLength: 3,
                source: function (request, response) {
                    $(current_obj).addClass("loading_player");
                    //$('.btn-success').disabled(true);
                    $('.btn-success').attr('disabled', 'disabled');
                    // $(".overlay").show();
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url() . 'read-item'; ?>",
                        dataType: "json",
                        data: {
                            term: request.term,
                        },
                        success: function (data) {

                            $(".overlay").hide();
                            data = data.result;
                            console.log(data);
                            response(data);
                        }, complete: function (jqXHR, status) {
                            $(current_obj).removeClass("loading_player");
                            if (status == 'parsererror') {
                                var data = [''];
                                response(data);
                            }
                            $('.btn-success').removeAttr('disabled');
                        }
                    });
                }, select: function (event, ui) {
                    var item_id = ui.item.id;
                    var hsn_code = ui.item.hsn_code;
                    var purchased_price = ui.item.purchased_price;
                    var unit = ui.item.unit;
                    
               // #add_row $('.item_name').parent().parent().children().find('.hsd_code')  
                    $(current_obj).parent().parent().children().find('.item_name').val(ui.item.name);
                    $(current_obj).parent().parent().children().find('.item_id').val(ui.item.id);
                    $(current_obj).parent().parent().children().find('.hsd_code').val(ui.item.hsn_code);
                    $(current_obj).parent().parent().children().find('.sgst_tax_rate').val(ui.item.sgst_tax_rate);
                    $(current_obj).parent().parent().children().find('.cgst_tax_rate').val(ui.item.cgst_tax_rate);
                  //  $(current_obj).parent().parent().children().find('.tax_rate').val(tax_rate);
                    $(current_obj).parent().parent().children().find('.unit').val(ui.item.unit );
                         $('.btn-success').removeAttr('disabled');
                      //   auto_fill_items(item_id, current_obj);
                    // }

                    return false;
                }, change: function (e, ui) {
                    if (!(ui.item.id))
                        e.target.value = "";
                },
                min_length: 3,
                delay: 100,
                autoFocus: true
            }).autocomplete("instance")._renderItem = function (ul, item) {
                
                if (item == null || item == '') {
                    console.log('HERE');
                    return $("<li>").append("<div>No results found</div>").appendTo(ul);
                }
     
                return $("<li>").append("<div id=" + item.id + " >" + item.name + "</div>").appendTo(ul);
            };



        });

    });
 
</script>
<?= $this->endSection() ?>