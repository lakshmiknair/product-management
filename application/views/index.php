<html>
    <head>
        <title>Product Grid List</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.3.1/jquery.bootgrid.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.3.1/jquery.bootgrid.js"></script>  
    </head>
    <body>
        <div class="container box">
            <h3 align="center">Product List</h3><br />
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="panel-title">Products</h3>
                        </div>
                        <div class="col-md-2" align="right">
                            <button type="button" id="add_button" data-toggle="modal" data-target="#productModal" class="btn btn-info btn-xs">Add Product</button>
                        </div>
                    </div>

                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="product_data" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th data-column-id="product_image" data-width="10%" data-formatter="image">Image</th>
                                    <th data-column-id="product_title" data-width="30%">Title</th>
                                    <th data-column-id="product_description" data-width="30%" data-formatter="limit">Description</th>
                                    <th data-column-id="product_price" data-width="10%" data-formatter="price">Price</th>
                                    <th data-column-id="product_quantity" data-width="10%">Quantity</th>                                   
                                    <th data-column-id="commands" data-width="10%" data-formatter="commands" data-sortable="false">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<div id="productModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="product_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Product</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Enter Title</label>
                        <input type="text" name="product_title" id="product_title" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label>Enter Description</label>
                        <textarea name="product_description" id="product_description" class="form-control" required></textarea>
                    </div>                
                    <div class="form-group">
                        <label>Enter Price in $</label>
                        <input type="text" name="product_price" id="product_price" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label>Enter Quantity</label>
                        <input type="text" name="product_quantity" id="product_quantity" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label>Upload Image</label>
                        <input type="file" name="product_image" id="product_image" class="form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="product_id" id="product_id" />
                    <input type="hidden" name="operation" id="operation" value="Add" />
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" language="javascript" >
    $(document).ready(function () {
        
        //Jquery bootgrid plugin is used to display poduct grid list.
        var productTable = $('#product_data').bootgrid({
            ajax: true,
            rowCount: 5, // pagination per page
            rowSelect: true,
            navigation: 2,

            post: function ()
            {
                return{
                    id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
                }
            },
            url: "<?php echo base_url(); ?>index.php/products/fetch_data",
            formatters: { // for formatting the grid columns
                "commands": function (column, row) { // for displaying edit and delete button
                    return "<button type='button' class='btn btn-warning btn-xs update' data-row-id='" + row.product_id + "'>Edit</button>" + "&nbsp; <button type='button' class='btn btn-danger btn-xs delete' data-row-id='" + row.product_id + "'>Delete</button>";
                },
                "image": function (column, row) { // for getting product image
                    return "<img src=\"assets/images/products/thumb/" + row[column.id] + "\" />";
                },
                "price": function (column, row) { // for formatting the price colum
                    return "$" + ReplaceNumberWithCommas(row[column.id]);
                },
                "limit": function (column, row) { // for limiting the characters in the description column
                    return  limitDesc(row[column.id]);
                },
            }
        });
        //function is used to format the price
        function ReplaceNumberWithCommas(yourNumber) {
            //Seperates the components of the number
            var n = yourNumber.toString().split(".");
            //Comma-fies the first part
            n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            //Combines the two sections
            return n.join(".");
        }
        //function is used to limit the description characters
        function limitDesc(description)
        {
            if (description.length > 155)
                return description.substring(0, 100) + '.....';
            else
                return description;
        }
        // to add new product
        $('#add_button').click(function () {
            $('#product_form')[0].reset();
            $('.modal-title').text("Add Product");
            $('#action').val("Save");
            $('#operation').val("Save");
        });
        //submit form for add / edit
        $(document).on('submit', '#product_form', function (event) {
            event.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/products/action",
                method: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data)
                {
                    $('#product_form')[0].reset();
                    $('#productModal').modal('hide');
                    $('#product_data').bootgrid('reload');
                }
            });

        });
        //validating decimal price
        $('#product_price').blur(function () {
            if (!validatePrice($('#product_price').val())) {
                alert("Please enter a valid price");
                $('#product_price').val('');
                $('#product_price').focus();
                return false;
            }
        })
        //validating numeric quantity
        $('#product_quantity').blur(function () {
            if (!validatePrice($('#product_quantity').val())) {
                alert("Please enter a valid quantity");
                $('#product_quantity').val('');
                $('#product_quantity').focus();
                return false;
            }
        })
        //check whether price is decimal or not
        function validatePrice(price) {
            return /^\d{0,10}(\.\d{0,4})?$/i.test(price);
        }
        //check whether quantity is numeric 
        function isNormalInteger(str) {
            var n = Math.floor(Number(str));
            return n !== Infinity && String(n) === str && n >= 0;
        }
        //to edit and delete the product in the grid
        $(document).on("loaded.rs.jquery.bootgrid", function () {
            productTable.find('.update').on('click', function (event) {
                var id = $(this).data('row-id');
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/products/fetch_single_data",
                    method: "POST",
                    data: {product_id: id},
                    dataType: "json",
                    success: function (data)
                    {
                        $('#productModal').modal('show'); //to show edit product form popup 
                        $('#product_title').val(data.product_title);
                        $('#product_description').val(data.product_description);
                        $('#product_price').val(data.product_price);
                        $('#product_quantity').val(data.product_quantity);
                        $('.modal-title').text("Edit Product Details");
                        $('#product_id').val(id);
                        $('#action').val('Update');
                        $('#operation').val('Update');
                    }
                });
            });
            productTable.find('.delete').on('click', function (event) {
                if (confirm("Are you sure you want to delete this?"))
                {
                    var id = $(this).data('row-id');
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/products/delete_data",
                        method: "POST",
                        data: {product_id: id},
                        success: function (data)
                        {
                            $('#product_data').bootgrid('reload');
                        }
                    });
                } else
                {
                    return false;
                }
            });
        });
    });
</script>