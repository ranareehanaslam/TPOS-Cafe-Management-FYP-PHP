<?php
include 'includes/header.php';
require 'includes/sqlconnect.php';
include 'includes/sessoincheck.php';
?>
<head>
    <link rel="stylesheet" type="text/css" href="./includes/css/datatables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./includes/css/buttons.bootstrap5.css">
</head>
<div class="container">
    <div>
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation"><a class="nav-link active" role="tab" data-bs-toggle="tab" href="#tab-1">Coupons List</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active text-black" role="tabpanel" id="tab-1">
                <button class="btn btn-primary" id="user" type="button" data-bs-toggle="modal" data-id="-1" data-bs-target="#updatecoupon">Create New
                </button>
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-xxl-9">
                        <div class="card shadow">
                            <div class="card-header d-flex flex-wrap justify-content-center align-items-center justify-content-sm-between gap-3">
                                <h2 class="display-5 text-nowrap text-capitalize mb-0">Coupons</h2>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div id="tblcoupon"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
<!-- Modal Add Coupon-->
<div class="modal fade" id="updatecoupon" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black tableModalHead tableModalHeadTitle" >Update Coupon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updatecoupon" class="userform">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="col-form-label text-black">Coupon Code:</label>
                        <input type="text" class="form-control" required name="coupon" id="coupon">
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label text-black">Percentage:</label>
                        <input type="number" class="form-control" required name="percentage" id="percentage" min="0" max="100" oninput="(validity.valid)||(value=''); step="any"">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btnupdatecoupon">Update Coupon</button>
                </div>
            </form>
            <div class="p-1 text-center" id="response"></div>
        </div>
    </div>
</div>
<script type="text/javascript" src="./includes/js/jquery.min.js"></script>
<script>
    //Form SUBMIT
    $(document).ready(function () {
        loadtable();
        //DELETE FORM SUBMIT
        $('#deleteform').submit(function (e) {
            var deleteitemobj = JSON.stringify(deletecoupon);
            var deleteitemtypeobj = JSON.stringify('coupon');
            e.preventDefault();
            $.ajax({
                url: "formhandling.php",
                type: "POST",
                data: {
                    "deleteitemtype": deleteitemtypeobj,
                    "deleteitem": deleteitemobj,
                },
                success: function (data) {
                    if (data == "success") {
                        $("#deleteresponse").attr("class", "h2 p-1 text-center text-success");
                        $('#deleteresponse').text("Coupon "+ coupon +" Deleted Successfully");
                        loadtable();
                    } else {
                        $("#deleteresponse").attr("class", "h2 p-1 text-center text-danger");
                        $('#deleteresponse').text("Unable to Delete Coupon");
                    }
                },
                error: function () {
                    alert("Form submission failed!");
                }
            });

        });
        //ADD UPDATE FORM SUBMIT
        $('#updatecoupon').submit(function (e) {
            e.preventDefault();
                var coupon = JSON.stringify($("#coupon").val());
                var percentage = JSON.stringify($("#percentage").val());
                var user ='<?php echo $_SESSION["username"];?>';
                user = JSON.stringify(user);
                $.ajax({
                    url: "formhandling.php",
                    type: "POST",
                    data: {
                        "couponid": id,
                        "coupon": coupon,
                        "percentage": percentage,
                        "user": user
                    },
                    success: function (data) {
                        if (data == "success") {
                            $("#response").attr("class", "h2 p-1 text-center text-success");
                            if(id==-1)
                            {
                                $('#response').text("Coupon "+ coupon +" Added Successfully");
                            }
                            else
                            {
                                $('#response').text("Coupon "+ coupon +" Updated Successfully");
                            }
                            loadtable();
                        } else {
                            $("#response").attr("class", "h2 p-1 text-center text-danger");
                            $('#response').text("Unable to Coupon User");
                        }
                    },
                    error: function () {
                        alert("Form submission failed!");
                    }
                });
        });
    });
    function loadtable()
    {
        var jsonObj = JSON.stringify("tblcoupon");
        $.ajax({
            type: "POST",
            data: {"table": jsonObj},
            url: "tablehandling.php",
            dataType: "html",
            success: function(data){
                $("#tblcoupon").html(data);
            }
        });
    }
    //UPDATE BUTTON CODING HERE
    var id
    var updatemodal = document.getElementById('updatecoupon')
    updatemodal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        var coupon = button.getAttribute('data-coupon')
        var percentage = button.getAttribute('data-percentage')
        id = button.getAttribute('data-id')
        var modalTitle = updatemodal.querySelector('.tableModalHeadTitle')
        var modalBodyInputCoupon = updatemodal.querySelector('#coupon')
        var modalBodyInputPercentage = updatemodal.querySelector('#percentage')
        var modalTitleButton = updatemodal.querySelector('#btnupdatecoupon')
        if(id==-1)
        {
            modalTitle.textContent = 'Add Coupon'
            modalTitleButton.textContent = 'Add Coupon'
            modalBodyInputCoupon.value = ''
            modalBodyInputPercentage.value = ''
        }
        else
        {
            modalTitle.textContent = 'Update Coupon ' + coupon
            modalTitleButton.textContent = 'Update Coupon'
            modalBodyInputCoupon.value = coupon
            modalBodyInputPercentage.value = percentage
        }
    })
    //All Delete Button Codding Here
    var deletecoupon,coupon
    var deletemodal = document.getElementById('delete')
    deletemodal.addEventListener('show.bs.modal', function (event) {
        var modalTitle = deletemodal.querySelector('.tableModalHeadTitle')
        var confirmationtext = deletemodal.querySelector('#confirmationtext')
        var deletebutton = deletemodal.querySelector('#deletebutton')
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        deletecoupon= button.getAttribute('data-id')
        coupon = button.getAttribute('data-coupon')
        modalTitle.textContent = 'Delete Coupon ?'
        confirmationtext.textContent = 'Are you sure you want to Delete Coupon ' + coupon + ' ?'
        deletebutton.textContent = 'Delete Coupon'
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