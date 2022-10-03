<?php
include 'includes/header.php';
require 'includes/sqlconnect.php';
include 'includes/sessoincheck.php';
$sql = "SELECT * FROM `tblcategory`";
$all_categories = mysqli_query($connection,$sql);
?>
<head>
    <link rel="stylesheet" type="text/css" href="./includes/css/datatables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./includes/css/buttons.bootstrap5.css">
</head>
<body class="bg-light text-white">
<div class="container">
    <div>
        <!-- Start: Menu -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation" id="Product"><a class="nav-link active" role="tab"
                                                                     data-bs-toggle="tab" href="#tab-1" onclick="loadtable('tblproduct')">Product</a></li>
            <li class="nav-item" role="presentation" id="Category"><a class="nav-link" role="tab" data-bs-toggle="tab"
                                                                      href="#tab-2" onclick="loadtable('tblcategory')">Category</a></li>
            <li class="nav-item" role="presentation" id="Table"><a class="nav-link" role="tab" data-bs-toggle="tab"
                                                                    href="#tab-3" onclick="loadtable('tbltable')">Table</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" role="tabpanel" id="tab-1">
                <button class="btn btn-primary" id="Product" type="button" data-bs-toggle="modal" data-id="-1"
                        data-bs-target="#productmodal">Create New
                </button>
                <!-- Start: Product crud-Table -->
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-xxl-9">
                        <div class="card shadow-lg">
                            <div class="card-header d-flex flex-wrap justify-content-center align-items-center justify-content-sm-between gap-3">
                                <h5 class="display-6 text-nowrap text-capitalize mb-0 text-black" id="tblheading">
                                    Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive text-black">
                                <div id="tblproduct"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End: crud-Table -->
            </div>
            <div class="tab-pane" role="tabpanel" id="tab-2">
                <button class="btn btn-primary" id="Category" data-category="-1" type="button" data-bs-toggle="modal"
                        data-bs-target="#categorymodal">Create New
                </button>
                <!-- Start: Category crud-Table -->
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-xxl-9">
                        <div class="card shadow-lg">
                            <div class="card-header d-flex flex-wrap justify-content-center align-items-center justify-content-sm-between gap-3">
                                <h5 class="display-6 text-nowrap text-capitalize mb-0 text-black" id="tblheading">
                                    Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive text-black">
                                    <div id="tblcategory"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End: crud-Table -->
            </div>
            <div class="tab-pane" role="tabpanel" id="tab-3">
                <button class="btn btn-primary btn-modal" data-table="-1" id="Table" data-bs-toggle="modal" data-bs-target="#tabelmodal">Create New</button>
                <!-- Start: Table crud-Table -->
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-xxl-9">
                        <div class="card shadow-lg">
                            <div class="card-header d-flex flex-wrap justify-content-center align-items-center justify-content-sm-between gap-3">
                                <h5 class="display-6 text-nowrap text-capitalize mb-0 text-black" id="tblheading">
                                    Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive text-black">
                                    <div id="tbltable"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End: crud-Table -->
            </div>
        </div>
    </div>

</div>
<!-- Modal ADD Table-->
<div class="modal fade" id="tabelmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black tableModalHead tableModalHeadTitle" >Add Table</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="tableform">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label text-black">Table No:</label>
                        <input type="text" class="form-control" required name="tableno" id="tableno">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary tableModalHead" id="exampleModalLabel">Add Table</button>
                </div>
            </form>
            <div class="p-1 text-center" id="tableaddrespnose"></div>
        </div>
    </div>
</div>
<!-- Modal ADD Category-->
<div class="modal fade" id="categorymodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black tableModalHeadTitle" id="exampleModalLabel">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="cagtegoryform">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label text-black">Category:</label>
                        <input type="text" class="form-control" required name="category" id="category">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="categorylabel">Add Category</button>
                </div>
            </form>
            <div class="p-1 text-center" id="categoryaddresponse"></div>
        </div>
    </div>
</div>

<!-- Modal ADD Product-->
<div class="modal fade" role="dialog" id="productmodal" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-black">
            <div class="modal-header">
                <h4 class="modal-title">Add Product</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="productform" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="row">
                    <div class="mb-3">
                        <label for="txtproduct">Product:</label>
                        <input class="form-control" id="txtproduct" type="text" required>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <label for="txtcategory">Category:</label>
                        <select class="form-select text-black" required id="txtcategory">
                            <?php
                            while ($category = mysqli_fetch_array(
                                $all_categories,MYSQLI_ASSOC)):;
                                ?>
                                <option value="<?php echo $category["category"];
                                // The value we usually set is the primary key
                                ?>">
                                    <?php echo $category["category"];
                                    // To show the category name to the user
                                    ?>
                                </option>
                            <?php
                            endwhile;
                            // While loop must be terminated
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <label for="txtprice">Price:</label>
                        <input class="form-control" id="txtprice" type="number" min="0" oninput="(validity.valid)||(value='');" step="any" required>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <label for="txtstatus">Status:</label>
                        <select class="form-select text-black" required id="txtstatus">
                            <option value="available">Available</option>
                            <option value="not-available">Not Available</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <div class="col">
                            <label for="txtstock">Stock:</label>
                            <input type="checkbox" id="txtstock">
                        </div>
                        <div class="col">
                            <input class="form-control" id="stock" type="number" min="0" oninput="(validity.valid)||(value='');" step="any" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <div class="col">
                            <label for="pictureupload" class="form-label">Product Picture:</label>
                            <input class="form-control" type="file" id="ProductImage" name="ProductPicutre" required accept=".jpg, .png"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="productsubmitlabel" type="submit">Add Product</button>
            </div>
            </form>
            <div class="p-1 text-center" id="productaddresponse"></div>
        </div>
    </div>
</div>

<!-- Modal Delete-->
<div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black tableModalHead tableModalHeadTitle" >Are you sure?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteform">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label text-black" id="confirmationtext">Do you really want to delete</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary tableModalHead" id="deletebutton">Delete</button>
                </div>
            </form>
            <div class="p-1 text-center" id="deleteresponse"></div>
        </div>
    </div>
</div>



<script src="./includes/js/bootstrap.min.js"></script>
<script src="./includes/js/bootstrapdrop.min.js"></script>
<script type="text/javascript" src="./includes/js/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        loadtable('tblproduct');
        //product checkbox handle
        $('#txtstock').click(function() {
            if( $('#txtstock').is(':checked') ){
                $('#stock').prop('disabled', false);
            }
            else
            {
                $('#stock').prop('disabled', true);
            }
        });
        //TABLE SUBMIT
        $('#tableform').submit(function (e) {
            var inpttableno = $("#tableno").val();
            var jsonObj = JSON.stringify(inpttableno);
            var jsonObj2 = JSON.stringify(table);
            e.preventDefault();
            $.ajax({
                url: "formhandling.php",
                type: "POST",
                data: {"tableno": jsonObj,
                    "tupdateid": jsonObj2
                        },
                success: function (data) {
                    if (data == "success") {
                        $("#tableaddrespnose").attr("class", "h2 p-1 text-center text-success");
                        if(table==-1)
                        {
                            $('#tableaddrespnose').text("Table " + inpttableno + " Added Successfuly");
                        }
                        else
                        {
                            $('#tableaddrespnose').text("Table " + table + " Updated Successfuly");
                        }
                        loadtable('tbltable');
                    } else if (data == "exist") {
                        $("#tableaddrespnose").attr("class", "h2 p-1 text-center text-danger");
                        $('#tableaddrespnose').text("Table " + inpttableno + " Exist Already");
                    } else {
                        $("#tableaddrespnose").attr("class", "h2 p-1 text-center text-danger");
                        $('#tableaddrespnose').text("Unable to add table");
                    }
                },
                error: function () {
                    alert("Form submission failed!");
                }
            });
        });
        //CATEGORY SUBMIT
        $('#cagtegoryform').submit(function (e) {
            var inptcategory = $("#category").val();
            var jsonObj = JSON.stringify(inptcategory);
            var jsonObj2 = JSON.stringify(category);
            e.preventDefault();
            $.ajax({
                url: "formhandling.php",
                type: "POST",
                data: {"category": jsonObj,
                    "cupdateid": jsonObj2
                },
                success: function (data) {
                    if (data == "success") {
                        $("#categoryaddresponse").attr("class", "h2 p-1 text-center text-success");
                        if(category==-1)
                        {
                            $('#categoryaddresponse').text("Category " + inptcategory + " Added Successfuly");
                        }
                       else
                        {
                            $('#categoryaddresponse').text("Category " + category + " Updated Successfuly");
                        }
                        loadtable('tblcategory');
                    } else if (data == "exist") {
                        $("#categoryaddresponse").attr("class", "h2 p-1 text-center text-danger");
                        $('#categoryaddresponse').text("Category " + inptcategory + " Exist Already");
                    } else {
                        $("#categoryaddresponse").attr("class", "h2 p-1 text-center text-danger");
                        $('#categoryaddresponse').text("Unable to add Category");
                    }
                },
                error: function () {
                    alert("Form submission failed!");
                }
            });
        });
        //DELETE SUBMIT
        $('#deleteform').submit(function (e) {
            var jsonObj = JSON.stringify(deleteitem);
            var jsonObj2 = JSON.stringify(deleteitemtype);
            e.preventDefault();
            $.ajax({
                url: "formhandling.php",
                type: "POST",
                data: {"deleteitem": jsonObj,
                    "deleteitemtype": jsonObj2
                },
                success: function (data) {
                    if (data == "success") {
                        $("#deleteresponse").attr("class", "h2 p-1 text-center text-success");
                        if(deleteitemtype=='category')
                        {
                            $('#deleteresponse').text("Category " + deleteitem + " Deleted Successfuly");
                            loadtable('tblcategory');
                        }
                        else if(deleteitemtype=='table')
                        {
                            $('#categoryaddresponse').text("Table  " + deleteitem + " Deleted Successfuly");
                            loadtable('tbltable');
                        }
                        else if(deleteitemtype=='product')
                        {
                            $('#deleteresponse').text("Product  " + productname + " Deleted Successfuly");
                            loadtable('tblproduct');
                        }

                    }
                    else {
                        $("#deleteresponse").attr("class", "h2 p-1 text-center text-danger");
                        $('#deleteresponse').text("Unable to Delete");
                    }
                },
                error: function () {
                    alert("Form submission failed!");
                }
            });
        });
        //Product Submit
        $('#productform').submit(function (e) {
            e.preventDefault();
            var formData = new FormData($('#productform')[0]);
            formData.append('ProductPicutre', $('input[type=file]')[0].files[0]);
            formData.append('txtproduct', $("#txtproduct").val());
            formData.append('txtcategory', $("#txtcategory").val());
            formData.append('txtprice', $("#txtprice").val());
            formData.append('txtstatus', $("#txtstatus").val());
            formData.append('productid', productid);
            if($('#txtstock').is(':checked')){
                $stock=$("#stock").val();
            }
            else
            {
                $stock=-1;
            }
            formData.append('stock', $stock);
            $.ajax({
                url: 'formhandling.php',
                data: formData,
                async: true,
                contentType: false,
                processData: false,
                cache: false,
                type: 'POST',
                success: function (data) {
                    if (data == "success") {
                        $("#productaddresponse").attr("class", "h2 p-1 text-center text-success");
                        if(productid==-1)
                        {
                            $('#productaddresponse').text("Product "+ $("#txtproduct").val() + " Added Successfuly");
                        }
                       else
                        {
                            $('#productaddresponse').text("Product Updated "+ $("#txtproduct").val() + " Successfuly");
                        }
                        loadtable('tblproduct');
                    } else if (data == "exist") {
                        $("#productaddresponse").attr("class", "h2 p-1 text-center text-danger");
                        $('#productaddresponse').text("Product Exist Already");
                    } else {
                        $("#productaddresponse").attr("class", "h2 p-1 text-center text-danger");
                        $('#productaddresponse').text(data);

                    }
                },
                error: function () {
                    alert("Form submission failed!");
                    $("#productaddresponse").attr("class", "h2 p-1 text-center text-danger");
                    $('#productaddresponse').text("Unable to add product");
                }
            });
        });
    });
    function loadtable(tablecalled){
        var jsonObj = JSON.stringify(tablecalled);
        $.ajax({
            type: "POST",
            data: {"table": jsonObj},
            url: "tablehandling.php",
            dataType: "html",
            success: function(data){
                if(tablecalled=="tblproduct") {
                    $("#tblproduct").html(data);
                }
                else if (tablecalled=="tblcategory") {
                    $("#tblcategory").html(data);
                }
                else if (tablecalled=="tbltable") {
                    $("#tbltable").html(data);
                }
            }
        });
    }
    //Update Product Button Codding Here
    var productid,productname,productprice,productcategory,productstock,productimage,productstatus
    var productmodal = document.getElementById('productmodal')
    productmodal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        productid = button.getAttribute('data-id')
        productname = button.getAttribute('data-name')
        productcategory = button.getAttribute('data-category')
        productprice = button.getAttribute('data-price')
        productstatus = button.getAttribute('data-status')
        productstock = button.getAttribute('data-stock')
        productimage = button.getAttribute('data-image')


        var modalTitle = productmodal.querySelector('.modal-title')
        var modalBodyProduct = productmodal.querySelector('#txtproduct')
        var modalBodyCategory = productmodal.querySelector('#txtcategory')
        var modalBodyPrice = productmodal.querySelector('#txtprice')
        var modalBodyStatus = productmodal.querySelector('#txtstatus')
        var modalBodyStock = productmodal.querySelector('#stock')
        var modalTitleButton = productmodal.querySelector('#productsubmitlabel')
        if(productid!=-1)
        {
            $('#ProductImage').attr('required', false);
            modalTitleButton.textContent = 'Update Product'
            modalTitle.textContent = 'Update Product ' + productname
            modalBodyProduct.value = productname
            modalBodyCategory.value = productcategory
            modalBodyPrice.value = productprice
            modalBodyStatus.value = productstatus
            $("#ProductImage").val("");
            if(productstock!=-1)
            {
                $('#txtstock').prop('checked', true);
                $('#stock').attr('disabled', false);
                modalBodyStock.value=productstock
            }
            else
            {
                $('#txtstock').prop('checked', false);
                $('#stock').attr('disabled', true);
                modalBodyStock.value=''
            }
        }
        else
        {
            modalTitleButton.textContent = 'Add Product'
            modalTitle.textContent = 'Add Product '
            modalBodyProduct.value = ''
            modalBodyCategory.value = ''
            modalBodyPrice.value = ''
            modalBodyStatus.value = ''
            modalBodyStock.value = ''
            $('#txtstock').prop('checked', false);
            $('#stock').attr('disabled', true);
            $('#ProductImage').attr('required', true);
            $("#ProductImage").val("");
        }
    })
//Update Table Button Codding Here
    var table
    var tablemodal = document.getElementById('tabelmodal')
    tablemodal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        table = button.getAttribute('data-table')
        var modalTitle = tablemodal.querySelector('.tableModalHeadTitle')
        var modalBodyInput = tablemodal.querySelector('#tableno')
        var modalTitleButton = tablemodal.querySelector('#exampleModalLabel')
        if(table!=-1)
        {
            modalTitleButton.textContent = 'Update Table '
            modalTitle.textContent = 'Update Table ' + table
            modalBodyInput.value = table
        }
        else
        {
            modalTitleButton.textContent = 'Add Table '
            modalTitle.textContent = 'Add Table '
            modalBodyInput.value = ''
        }
    })
    //Update Category Button Codding Here
    var category
    var updatemodal = document.getElementById('categorymodal')
    updatemodal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        category = button.getAttribute('data-category')
        var modalTitle = updatemodal.querySelector('.tableModalHeadTitle')
        var modalBodyInput = updatemodal.querySelector('#category')
        var modalTitleButton = updatemodal.querySelector('#categorylabel')
        if(category!=-1)
        {
            modalTitleButton.textContent = 'Update Category'
            modalTitle.textContent = 'Update Category ' + category
            modalBodyInput.value = category

        }
        else
        {
            modalTitleButton.textContent = 'Add Category'
            modalTitle.textContent = 'Add Category '
            modalBodyInput.value = ''
        }
    })
    //All Delete Button Codding Here
    var deleteitem,deleteitemtype,productname
    var deletemodal = document.getElementById('delete')
    deletemodal.addEventListener('show.bs.modal', function (event) {
        var modalTitle = deletemodal.querySelector('.tableModalHeadTitle')
        var confirmationtext = deletemodal.querySelector('#confirmationtext')
        var deletebutton = deletemodal.querySelector('#deletebutton')
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        deleteitemtype=button.getAttribute('data-type')
        if(deleteitemtype=='table')
        {
            deleteitem= button.getAttribute('data-table')
            modalTitle.textContent = 'Delete Table ?'
            confirmationtext.textContent = 'Are you sure you want to Delete ' + deleteitem + ' ?'
            deletebutton.textContent = 'Delete Table'
        }
        else if(deleteitemtype=='category')
        {
            deleteitem= button.getAttribute('data-category')
            modalTitle.textContent = 'Delete Category ?'
            confirmationtext.textContent = 'Are you sure you want to Delete ' + deleteitem + ' ?'
            deletebutton.textContent = 'Delete Category'
        }
        else if(deleteitemtype=='product')
        {
            deleteitem= button.getAttribute('data-id')
            productname=button.getAttribute('data-name')
            modalTitle.textContent = 'Delete Product ?'
            confirmationtext.textContent = 'Are you sure you want to Delete ' + productname + ' ?'
            deletebutton.textContent = 'Delete Product'
        }

    })

</script>
<script type="text/javascript" src="./includes/js/jquery-3.5.1.js"></script>
<script type="text/javascript" src="./includes/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="./includes/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="./includes/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="./includes/js/buttons.bootstrap5.min.js"></script>
<script type="text/javascript" src="./includes/js/jszip.min.js"></script>
<script type="text/javascript" src="./includes/js/pdfmake.min.js"></script>
<script type="text/javascript" src="./includes/js/vfs_fonts.js"></script>
<script type="text/javascript" src="./includes/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="./includes/js/buttons.print.min.js"></script>
</body>


