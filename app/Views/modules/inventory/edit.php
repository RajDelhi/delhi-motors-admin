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
}
</style>
<div class="banner" id="banner" style="height: 90px">
    <div class="row">
        <div class="banner-inner columns">
            <h1 class="banner-title">Edit Inventory</h1>
        </div>
    </div>
</div>

<main id="main">
    <div class="row main-inner" style="margin: auto">
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
                    </div>
                    <div class="col-md-1">
                        <label for="field2" class="form-label">HSN</label>
                        <input type="text" class="form-control hsd_code" id="hsd_code" placeholder="" name="HSN_code[]"
                            value="" autocomplete="off">
                    </div>
                    <div class="col-md-1">
                        <label for="field2" class="form-label">Tax Rate</label>
                        <input type="text" class="form-control tax_rate" id="tax_rate" placeholder="" name="tax_rate[]" value="" autocomplete="off">
                    </div>
                    <div class="col-md-1">
                        <label for="field2" class="form-label">QTY</label>
                        <input type="text" class="form-control qty" id="qty" placeholder="" name="quantity[]" value="" autocomplete="off">
                    </div>

                    <div class="col-md-1">
                        <label for="field2" class="form-label">Unit</label>
                        <input type="text" class="form-control unit" id="unit" placeholder="" name="unit[]" value="" autocomplete="off">
                    </div>
                    <div class="col-md-1">
                        <label for="field3" class="form-label">MRP</label>
                        <input type="text" class="form-control mrp" id="mrp" placeholder="" name="mrp_unit[]"
                            value="" autocomplete="off">
                    </div>
                    <div class="col-md-1">
                        <label for="field3" class="form-label" title="Base Price without tax">B. Price</label>
                        <input type="text" class="form-control base_price" id="base_price" placeholder="" name="base_price[]"
                            value="" autocomplete="off">
                    </div>
                    <div class="col-md-1">
                        <label for="field3" class="form-label">Tax Value</label>
                        <input type="text" class="form-control tax_value" id="tax_value" placeholder="" name="tax_value[]" value="" autocomplete="off">
                    </div>

                    <div class="col-md-1">
                        <label for="field3" class="form-label">Buy Price</label>
                        <input type="text" class="form-control buy_price" id="buy_price" placeholder="" name="buy_price[]"
                            value="" autocomplete="off">
                    </div>
                    <div class="col-md-1">
                        <label for="field3" class="form-label">Net value</label>
                        <input type="text" class="form-control net_value" id="net_value" placeholder=""
                            name="net_value[]" value="" autocomplete="off">
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
                item_name: {
                    required: true
                },
                item_HSN_code: {
                    required: true
                },
                confirm_item_HSN_code: {
                    required: true,
                    minlength: 3,
                    equalTo: "#item_HSN_code"
                },
                price: {
                    number: true,
                    required: true
                }, quantity: {
                    number: true,
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
            $('#row_'+currnet_div).after('<div id="row_'+div_count+'" class="row mb-3 align-items-center"><div class="col-md-2"><input type="text" class="item_name form-control" id="item_name" placeholder="" name="item_name[]" value="" autocomplete="off"></div><div class="col-md-1"><input type="text" class="form-control hsd_code" id="hsd_code" placeholder="" name="HSN_code[]" value=""></div><div class="col-md-1"><input type="text" class="form-control tax_rate" id="tax_rate" placeholder="" name="tax_rate[]" value=""></div><div class="col-md-1"><input type="text" class="form-control qty" id="qty" placeholder="" name="quantity[]" value=""></div><div class="col-md-1"><input type="text" class="form-control unit" id="unit" placeholder="" name="unit[]" value=""></div><div class="col-md-1"><input type="text" class="form-control mrp" id="mrp" placeholder="" name="mrp_unit[]" value=""></div><div class="col-md-1"><input type="text" class="form-control base_price" id="base_price" placeholder="" name="base_price[]" value=""></div><div class="col-md-1"><input type="text" class="form-control tax_value" id="tax_value" placeholder="" name="tax_value[]" value=""></div><div class="col-md-1"><input type="text" class="form-control buy_price" id="buy_price" placeholder="" name="buy_price[]" value=""></div><div class="col-md-1"><input type="text" class="form-control net_value" id="net_value" placeholder="" name="net_value[]" value=""></div><div class="col-md-1"><span class="input-group-btn"><button class="remove_row btn btn-danger" type="button" id="remove_row_'+div_count+'">Remove</button></span></div></div>');
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


        $(document).on("keyup", ".mrp", function () {
            var current_obj = $(this);
            var mrp_price = $(current_obj).val();
            var tax_rate = $(current_obj).parent().parent().children().find('.tax_rate').val();
            var val = calculateTaxIncluded(mrp_price, tax_rate);
            $(current_obj).parent().parent().children().find('.tax_value').val(val.taxAmount);
            $(current_obj).parent().parent().children().find('.base_price').val(val.netValue);
        });

        function calculateTaxIncluded(totalValue, taxRate) {
            let taxAmount = (totalValue * taxRate) / (100 + taxRate);
            let netValue = totalValue - taxAmount;

            return {
                taxAmount: taxAmount.toFixed(2),
                netValue: netValue.toFixed(2)
            };
        }

        // functon on qty  key up, multiply qty with base price and set value in net value
        $(document).on("keyup", ".qty,.mrp", function () {
            var current_obj = $(this);
            var qty =  $(current_obj).parent().parent().children().find('.qty').val();
            var mrp = $(current_obj).parent().parent().children().find('.mrp').val();
            var val = qty * mrp;
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
                            //$(this).addClass('highlight_red');
                            //$(".add_sign").remove();
                            // if (data.status == 'error') {
                            //     var object_offset = current_obj.offset();
                            //     var left_offset = object_offset.left;
                            //     var dd = parseFloat(object_offset.top);
                            //     var top_offset = dd + 30;
                            //     $(current_obj).after('<div style="left:' + left_offset + 'px;top:' + top_offset + 'px;" class=""></div>');

                            // }
                            data = data.result;
                            console.log(data);
                            response(data);
                        }, complete: function (jqXHR, status) {
                            // if ($signature_count == 1) {
                            //     $(".ui-autocomplete").css('width', '637px!important')
                            // }
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
                    var tax_rate = ui.item.tax_rate;
                    var unit = ui.item.unit;
                    
               // #add_row $('.item_name').parent().parent().children().find('.hsd_code')  
                    $(current_obj).parent().parent().children().find('.item_name').val(ui.item.name);
                    $(current_obj).parent().parent().children().find('.hsd_code').val(ui.item.hsn_code);
                  //  $(current_obj).parent().parent().children().find('.mrp').val(ui.item.purchased_price);
                    $(current_obj).parent().parent().children().find('.tax_rate').val(ui.item.tax_rate);
                    $(current_obj).parent().parent().children().find('.unit').val(ui.item.unit );

                    // //following is the code for signer fees and autographp fees calculation
                    // if (signature_count == '') {
                    //     alert("Plese enter number of signature");
                    //     return false;

                    // }
                    // if (signature_count == undefined) {

                    //     // This is Ticket authentication case
                    //     return false;
                    // }
                    // var page_name = $("#page_name").val();
                    // if (page_name != 'result') {
                    //     $(current_obj).parent().next("td").children("input:text").addClass("loading_player");
                    //     $(current_obj).parent().next("td").next("td").children("input:text").addClass("loading_player");
                         // $('.btn-success').disabled(true);
                         $('.btn-success').removeAttr('disabled');
                      //   auto_fill_items(item_id, current_obj);
                    // }

                    return false;
                }, change: function (e, ui) {
                    if (!(ui.item))
                        e.target.value = "";
                },
                min_length: 3,
                delay: 100,
                autoFocus: true
            }).autocomplete("instance")._renderItem = function (ul, item) {
                var string = String(item.label);
                return $("<li>").append("<div id=" + item.id + " >" + item.name + "</div>").appendTo(ul);
            };



        });

    });
   // function signer_fee_calculation(signer_fees, signature_count, primary_signer_id) {
    function auto_fill_items(){
     if(isNaN(signature_count) == true){
            signature_count = 1;
        }
    var invoice_type = $("#submission_level").val();
    var service_type = $("#service_id").val();
    var submission_id = $("#submission_id").val();
    if (signer_fees !== '') {
        $(".overlay").show();
        $.ajax({
            type: "POST",
            url: '/online_submission_form/signer_fee_calculation',
            dataType: "json",
            data: {
                signer_fees: signer_fees,
                signature_count: signature_count,
                primary_signer_id: primary_signer_id,
                invoice_type: invoice_type,
                service_type: service_type,
                submission_id: submission_id
            },
            success: function (data) {
               // console.log(data);
               // console.log($.parseJSON(data));
                $(".overlay").hide();
                var result = $.parseJSON(data);
                if(result.result.status !== 'undefined' && result.result.status == false){
                   // update_soa_fees(data);
                   $("#signer_fee").val(0.00); 
                    $("#primary_signer_id").val(''); 
                    $('#filter_text').val(''); 
                    bootbox.alert(result.result.message);
                }else{
                    
                    update_form_fees(result.result, invoice_type);
                }
            }, complete: function (jqXHR, status) {
                $(".overlay").hide();
            }
        });
    }
}
</script>
<?= $this->endSection() ?>