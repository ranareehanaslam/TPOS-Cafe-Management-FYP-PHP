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
            <li class="nav-item" role="presentation"><a class="nav-link active" role="tab" data-bs-toggle="tab" href="#tab-1">Accounts</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active text-black" role="tabpanel" id="tab-1">
                <button class="btn btn-primary" id="user" type="button" data-bs-toggle="modal" data-id="-1" data-bs-target="#updateuser">Create New
                </button>
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-xxl-9">
                        <div class="card shadow">
                            <div class="card-header d-flex flex-wrap justify-content-center align-items-center justify-content-sm-between gap-3">
                                <h2 class="display-5 text-nowrap text-capitalize mb-0">User's</h2>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div id="tbluser"></div>
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
<!-- Modal Add User USER-->
<div class="modal fade" id="updateuser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black tableModalHead tableModalHeadTitle" >Update User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateuserform" class="userform">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="col-form-label text-black">Username:</label>
                        <input type="text" class="form-control" required name="username" id="username">
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label text-black">Name:</label>
                        <input type="text" class="form-control" required name="name" id="name">
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label text-black">Role:</label>
                        <select class="form-select text-black" id="role" required name="role">
                            <option value="Admin">Admin</option>
                            <option value="Cashier">Cashier</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label text-black">Password:</label>
                        <input type="password" class="form-control" required name="password" id="password">
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label text-black">Confirm Password:</label>
                        <input type="password" class="form-control" required name="cpassword" id="cpassword">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btnupdateuser">Update User</button>
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
            var deleteitemobj = JSON.stringify(deleteuser);
            var deleteitemtypeobj = JSON.stringify('user');
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
                        $('#deleteresponse').text("User "+ deleteuser +" Deleted Successfully");
                        loadtable();
                    } else {
                        $("#deleteresponse").attr("class", "h2 p-1 text-center text-danger");
                        $('#deleteresponse').text("Unable to Delete User");
                    }
                },
                error: function () {
                    alert("Form submission failed!");
                }
            });

        });
        //ADD UPDATE FORM SUBMIT
        $('#updateuserform').submit(function (e) {
            e.preventDefault();
            if($("#password").val()!=$("#cpassword").val())
            {
                $("#response").attr("class", "h2 p-1 text-center text-danger");
                $('#response').text("Password Don't Match");
            }
            else
            {
                var name = JSON.stringify($("#name").val());
                var username = JSON.stringify($("#username").val());
                var role = JSON.stringify($("#role").val());
                var pass = JSON.stringify($("#password").val());
                $.ajax({
                    url: "formhandling.php",
                    type: "POST",
                    data: {
                        "productid": productid,
                        "name": name,
                        "username": username,
                        "role": role,
                        "pass": pass
                    },
                    success: function (data) {
                        if (data == "success") {
                            $("#response").attr("class", "h2 p-1 text-center text-success");
                            if(productid==-1)
                            {
                                $('#response').text("User "+ $("#username").val() +" Added Successfully");
                            }
                            else
                            {
                                $('#response').text("User "+ $("#username").val() +" Updated Successfully");
                            }
                            loadtable();
                        } else {
                            $("#response").attr("class", "h2 p-1 text-center text-danger");
                            $('#response').text("Unable to Update User");
                        }
                    },
                    error: function () {
                        alert("Form submission failed!");
                    }
                });
            }

    });
    });
    function loadtable()
    {
        var jsonObj = JSON.stringify("tbluser");
        $.ajax({
            type: "POST",
            data: {"table": jsonObj},
            url: "tablehandling.php",
            dataType: "html",
            success: function(data){
                    $("#tbluser").html(data);
                }
        });
    }
    //UPDATE BUTTON CODING HERE
    var productid
    var updatemodal = document.getElementById('updateuser')
    updatemodal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        var username = button.getAttribute('data-username')
        var name = button.getAttribute('data-name')
        var role = button.getAttribute('data-role')
        productid = button.getAttribute('data-id')
        var modalTitle = updatemodal.querySelector('.tableModalHeadTitle')
        var modalBodyInputName = updatemodal.querySelector('#name')
        var modalBodyInputRole = updatemodal.querySelector('#role')
        var modalBodyInputUser = updatemodal.querySelector('#username')
        var modalTitleButton = updatemodal.querySelector('#btnupdateuser')
        if(productid==-1)
        {
            $('#username').removeAttr('disabled');
            modalTitle.textContent = 'Add User'
            modalTitleButton.textContent = 'Add User'
            modalBodyInputName.value = ''
            modalBodyInputRole.value = ''
            modalBodyInputUser.value = ''
        }
        else
        {
            $('#username').attr('disabled', 'disabled');
            modalTitle.textContent = 'Update User ' + name
            modalTitleButton.textContent = 'Update User'
            modalBodyInputName.value = name
            modalBodyInputRole.value = role
            modalBodyInputUser.value = username
        }
    })
    //All Delete Button Codding Here
    var deleteuser
    var deletemodal = document.getElementById('delete')
    deletemodal.addEventListener('show.bs.modal', function (event) {
        var modalTitle = deletemodal.querySelector('.tableModalHeadTitle')
        var confirmationtext = deletemodal.querySelector('#confirmationtext')
        var deletebutton = deletemodal.querySelector('#deletebutton')
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        deleteuser= button.getAttribute('data-username')
        modalTitle.textContent = 'Delete Table ?'
        confirmationtext.textContent = 'Are you sure you want to Delete ' + deleteuser + ' ?'
        deletebutton.textContent = 'Delete Table'
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