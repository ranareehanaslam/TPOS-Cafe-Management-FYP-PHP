<?php
include 'includes/sqlconnect.php';
include 'includes/sessoincheck.php';
$sql = "SELECT * FROM `tblcategory`";
$all_categories = mysqli_query($connection, $sql);
?>
<style>
    .product-categories {
        margin-top: 10px;
    }
    .btn {
        font-size: 12px;
        font-weight: bold;
    }
</style>
<div class="container-fluid bg-white">
    <div class="row bg-primary text-white fw-bold" style="height: 09vh;">
        <div class="col align-self-center">
            <p class="text-left" id="tableid" style="margin: 0px !important;"></p>
        </div>
        <div class="col align-self-center">
            <p style="text-align:right;margin: 0px !important;" id="transactionid"></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 border border-primary text-white" id="productshow" style="overflow: auto;height: 60vh">
        </div>
        <div class="col-md-4 border border-primary" style="overflow: auto;height: 60vh;--bs-gutter-x:">
            <div class="table-responsive text-black">
                <table class="table table-hover text-black">
                    <thead class="bg-dark text-white">
                    <tr>
                        <th>DESCRIPTION</th>
                        <th>PRICE</th>
                        <th>ORDER</th>
                        <th>TOTAL</th>
                        <th class="text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody id="showcart">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 border border-primary" style="overflow: auto;height: 15vh">
            <form id="productcategoryselect">
                <button type="submit" class="btn btn-primary product-categories" name="All">All</button>
                <?php
                while ($category = mysqli_fetch_array(
                    $all_categories, MYSQLI_ASSOC)):;
                    ?>
                    <button type="submit" class="btn btn-primary product-categories"
                            name="<?php echo $category["category"]; ?>"><?php echo $category["category"]; ?></button>
                <?php
                endwhile;
                // While loop must be terminated
                ?>
            </form>
        </div>
        <div class="col-md-4 border border-primary text-black" style="overflow: auto;height: 15vh">
            <b>
                <div class="clearfix">
                    <span class="float-start" >Subtotal:</span>
                    <span class="float-end" id="subtotalprice">0</span>
                </div>
                <div class="clearfix">
                    <span class="float-start">Discount:</span>
                    <span class="float-end" id="discountprice">0</span>
                </div>
                <div class="clearfix">
                    <span class="float-start">Total:</span>
                    <span class="float-end" id="grandtotal">0</span>
                </div>
            </b>
        </div>
    </div>
    <div class="row text-black" style="overflow: auto;height: auto;margin-top: 5px">
        <div class="col">
            <div class="d-grid">
                <button class="btn btn-primary btn-lg <?php if(isset($_SESSION["trnsdate"])){echo "disabled";}?>" id="startofdaybutton" type="button" data-bs-toggle="modal"
                        data-bs-target="#startofday">Start Of Day
                </button>
            </div>
        </div>
        <div class="col">
            <div class="d-grid">
                <button class="btn btn-primary btn-lg newshoworder <?php if(!isset($_SESSION["trnsdate"])){echo "disabled";}?>" onclick="loadtable()" id="newshoworderbutton" type="button" data-bs-toggle="modal"
                        data-bs-target="#newshoworder">Order's
                </button>
            </div>
        </div>
        <div class="col">
            <div class="d-grid">
                <button class="btn btn-primary btn-lg disabled" type="button" id="settlepaymentbutton" onclick="$('#cashgiven').val('');" data-bs-toggle="modal"
                        data-bs-target="#settlepayment">Settle Payment
                </button>
            </div>
        </div>
        <div class="col">
            <div class="d-grid">
                <button class="btn btn-primary btn-lg <?php if(!isset($_SESSION["trnsdate"])){echo "disabled";}?>" id="refundamountbutton" onclick="refunditems()" type="button" data-bs-toggle="modal"
                        data-bs-target="#refundamount">Refund Amount
                </button>
            </div>
        </div>
        <div class="col">
            <div class="d-grid">
                <button class="btn btn-primary btn-lg disabled" id="printbillbutton" type="button" onclick="printDiv()">
                    Print Bill
                </button>
            </div>
        </div>
        <div class="col">
            <div class="d-grid">
                <button class="btn btn-primary btn-lg disabled" id="kitchenprintbill" type="button" onclick="kitchenprintbill()">
                    Kitchen Print
                </button>
            </div>
        </div>
        <div class="col">
            <div class="d-grid">
                <button class="btn btn-primary btn-lg disabled" type="button" data-bs-toggle="modal" id="discountbutton" onclick="discountcheck();$('#discountinpt').val('');" data-bs-target="#discount">
                    Discount
                </button>
            </div>
        </div>
        <div class="col">
            <div class="d-grid">
                <button class="btn btn-primary btn-lg <?php if(isset($_SESSION["trnsdate"])){echo "disabled";}?>"" type="button" data-bs-toggle="modal" id="readbutton" data-bs-target="#read">
                    Read
                </button>
            </div>
        </div>
        <div class="col">
            <div class="d-grid">
                <button class="btn btn-primary btn-lg <?php if(!isset($_SESSION["trnsdate"])){echo "disabled";}?>" id="endofdaybutton" type="button" data-bs-toggle="modal" data-bs-target="#endofday">
                    End of Day
                </button>
            </div>
        </div>
        <div class="col">
            <div class="d-grid">
                <a class="btn btn-primary btn-lg" type="button" href="logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>


<!-- Modal Start Of Day-->
<div class="modal fade" id="startofday" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black" id="exampleModalLabel">Start Of Day</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="startofday">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label text-black">Cash:</label>
                        <input type="number" class="form-control" required name="cashstartofday" id="cashstartofday">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Start Day</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal NEW Show order -->
<div class="modal fade" id="newshoworder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered">
        <div class="modal-content" style="overflow: auto">
            <div class="modal-header">
                <h5 class="modal-title text-black" id="exampleModalLabel">Select Table</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="tableform">
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body" id="tableshow">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Settle Payment-->
<div class="modal fade" id="settlepayment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black" id="exampleModalLabel">Settle Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="acceptpayment">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label text-black">TOTAL:</label>
                        <input type="number" class="form-control" required name="totalcash" id="totalcash" value=""
                               disabled>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label text-black">Cash:</label>
                        <input type="number" class="form-control" required name="cashgiven" min="0" id="cashgiven" onkeyup="calculatecashback()" onchange="calculatecashback()">
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label text-black">Change:</label>
                        <input type="number" class="form-control" required name="changetogive" id="changetogive"
                               disabled>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="cashgiveninput.value+=1;cashgiveninput.focus();calculatecashback()">1</button></div>
                            <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="cashgiveninput.value+=2;cashgiveninput.focus();calculatecashback()">2</button></div>
                            <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="cashgiveninput.value+=3;cashgiveninput.focus();calculatecashback()">3</button></div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="cashgiveninput.value+=4;cashgiveninput.focus();calculatecashback()">4</button></div>
                            <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="cashgiveninput.value+=5;cashgiveninput.focus();calculatecashback()">5</button></div>
                            <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="cashgiveninput.value+=6;cashgiveninput.focus();calculatecashback()">6</button></div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="cashgiveninput.value+=7;cashgiveninput.focus();calculatecashback()">7</button></div>
                            <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="cashgiveninput.value+=8;cashgiveninput.focus();calculatecashback()">8</button></div>
                            <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="cashgiveninput.value+=9;cashgiveninput.focus();calculatecashback()">9</button></div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="cashgiveninput.value+=9;cashgiveninput.focus();calculatecashback()">0</button></div>
                            <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="cashgiveninput.value='';cashgiveninput.focus();calculatecashback()">C</button></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Accept Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Refund Amount-->
<div class="modal fade" id="refundamount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black" id="exampleModalLabel">Refund Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="refund">
                <div class="modal-body">
                    <div class="table-responsive text-black" id="refunditems">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
            <div class="p-1 text-center" id="responsedata"></div>
        </div>
    </div>
</div>

<!-- Modal discount-->
<div class="modal fade" id="discount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black" id="exampleModalLabel">Discount</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="discount">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label text-black">Sub-Total:</label>
                        <input type="number" class="form-control" required name="subtotalcash" id="subtotalcash" value=""
                               disabled>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label text-black">Discount:</label>
                        <input type="number" class="form-control" value="" name="discountinpt" id="discountinpt" onkeyup="discountcheck()" min="1" required onchange="discountcheck()">
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label text-black">Coupon:</label>
                        <input type="text" class="form-control" name="coupon" id="coupon" onkeyup="discountcheck()" onchange="discountcheck()">
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label text-black">Total:</label>
                        <input type="number" class="form-control" required name="totalafterdiscount" id="totalafterdiscount"
                               disabled>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="discountinput.value+=1;discountinput.focus();discountcheck()">1</button></div>
                            <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="discountinput.value+=2;discountinput.focus();discountcheck()">2</button></div>
                            <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="discountinput.value+=3;discountinput.focus();discountcheck()">3</button></div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="discountinput.value+=4;discountinput.focus();discountcheck()">4</button></div>
                            <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="discountinput.value+=5;discountinput.focus();discountcheck()">5</button></div>
                            <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="discountinput.value+=6;discountinput.focus();discountcheck()">6</button></div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="discountinput.value+=7;discountinput.focus();discountcheck()">7</button></div>
                            <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="discountinput.value+=8;discountinput.focus();discountcheck()">8</button></div>
                            <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="discountinput.value+=9;discountinput.focus();discountcheck()">9</button></div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="if(!discountinput.value==''){discountinput.value+=0;discountinput.focus();discountcheck()}">0</button></div>
                            <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="discountinput.value='';discountinput.focus();discountcheck()">C</button></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Apply Discount</button>
                </div>
            </form>
            <div class="p-1 text-center" id="responsedata"></div>
        </div>
    </div>
</div>


<!-- Modal End Of Day-->
<div class="modal fade" id="endofday" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black" id="exampleModalLabel">END OF DAY</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="endofday">
                <div class="modal-body text-black">
                    <p>Do you want to Close Sales of Day.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal ITEM ADD-->
<div class="modal fade" id="itemadd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black" id="exampleModalLabel">ADD ITEM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="neworder">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label text-black">QUANTITY:</label>
                        <input type="number" class="form-control" required name="quantity" id="quantity" min="1" oninput="(validity.valid)||(value='');" required>
                        <br>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="quantityinput.value+=1;quantityinput.focus()">1</button></div>
                                <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="quantityinput.value+=2;quantityinput.focus()">2</button></div>
                                <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="quantityinput.value+=3;quantityinput.focus()">3</button></div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="quantityinput.value+=4;quantityinput.focus()">4</button></div>
                                <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="quantityinput.value+=5;quantityinput.focus()">5</button></div>
                                <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="quantityinput.value+=6;quantityinput.focus()">6</button></div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="quantityinput.value+=7;quantityinput.focus()">7</button></div>
                                <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="quantityinput.value+=8;quantityinput.focus()">8</button></div>
                                <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="quantityinput.value+=9;quantityinput.focus()">9</button></div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="if(!quantityinput.value==''){quantityinput.value+=0;quantityinput.focus()}">0</button></div>
                                <div class="col-md-4"><button class="btn btn-primary btn-lg btn-block" type="button" onclick="quantityinput.value='';quantityinput.focus()">C</button></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Add Item</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal ITEM REFUND-->
<div class="modal fade" id="itemrefund" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black" id="exampleModalLabel">REFUND</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="refund">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label text-black">NAME:</label>
                        <input type="text" class="form-control" required name="refunditemname" id="refunditemname"
                               value="" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label text-black">PRICE:</label>
                        <input type="number" class="form-control" required name="refunditemprice" id="refunditemprice" value="" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label text-black">QUANTITY:</label>
                        <input type="number" class="form-control" required name="refunditemquantity" id="refunditemquantity">
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label text-black">AMOUNT:</label>
                        <input type="number" class="form-control" required name="refunditemamount" id="refunditemamount" value=""
                               disabled>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label text-black">REASON:</label>
                        <input type="text" class="form-control" required name="refunditemreason" id="refunditemreason">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Refund</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Delete Item-->
<div class="modal fade" id="deleteitem" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black" id="exampleModalLabel">Do You Really Want to Delete?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deletecartitem">
                <div class="modal-body text-black">
                    <p id="confirmationtext">Are You Sure!.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal READ -->
<div class="modal fade" id="read" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black tableModalHeadTitle" id="saleofdaytitle">SALES OF DAY</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label class="text-black col h4">Sales:</label>
                        <p class="text-black col h4" id="sales"></p>
                    </div>
                    <div class="mb-3 row">
                        <label class="text-black col h4">Initial Cash:</label>
                        <p class="text-black col h4" id="initialcash"></p>
                    </div>
                    <div class="mb-3 row">
                        <label class="text-black col h4">Discounts:</label>
                        <p class="text-black col h4" id="discountaddedtoday"></p>
                    </div>
                    <div class="mb-3 row">
                        <label class="text-black col h4">Total:</label>
                        <p class="text-black col h4" id="totalsale"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#saleofday" data-bs-dismiss="modal">View Sale Details</button>
                </div>
        </div>
    </div>
</div>

<!-- Modal SALE OF DAY  -->
<div class="modal fade" id="saleofday" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black tableModalHeadTitle" id="detailedsaleofdaytitle">DETAILS OF SALE OF DAY</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="saleofdaytable">
                <table class="table text-black">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th colspan="2">TRNASACTION NO</th>
                        <th colspan="2">TABLE NO</th>
                        <th colspan="2">ITEM NAME</th>
                        <th>PRICE</th>saleofday
                        <th>QUANTITY</th>
                        <th>TOTAL</th>
                    </tr>
                    </thead>
                    <tbody id="saleofdaybodytable">
            </div>

        </div>
    </div>
</div>

<script type="text/javascript" src="./includes/js/jquery.min.js"></script>
<script type="text/javascript">
    var quantityinput=document.getElementById('quantity');
    var discountinput=document.getElementById('discountinpt');
    var cashgiveninput=document.getElementById('cashgiven');
    var d = new Date();
    var buttonpressed='All';
    var tableid;
    $(document).ready(function () {
        checkday();
        var month='' + (d.getMonth() + 1);
        day = '' + d.getDate();
        if(month.length<2)
        {
            month = '0' + month;
        }
        if(day.length)
        {
            day = '0' + day;
        }
        date = d.getFullYear() + '-' + month + '-' + day;
        loadproducts('tblproduct', buttonpressed);
        //product category button check

        $('.product-categories').click(function () {
            buttonpressed = $(this).attr('name')
        })
        //PRODUCT CATEGORY SELECT
        $('#productcategoryselect').submit(function (e) {
            e.preventDefault();
            loadproducts('tblproduct', buttonpressed);
        });
        //START OF DAY
        $('#startofday').submit(function (e) {
            e.preventDefault();
            startofday();
        });
        //TABLE SELECT SUBMIT
        $('#tableform').submit(function (e) {
            e.preventDefault();
            tableid=$(document.activeElement).val();
            document.getElementById("tableid").textContent="Table #"+ tableid;
            loadtransactionno(tableid);
            $("#newshoworder").modal('hide');
        });
        //ITEM ADD SUBMIT
        $('#neworder').submit(function (e) {
            e.preventDefault();
            if(typeof tableid=='undefined'||tableid==null||tableid=='')
            {
                alertify.error("SELECT TABLE OR START ORDER");
            }
            else
            {
                addproducts($("#quantity").val(),itemid,price,tableid,transactionno);
            }

        });
        //ITEM DELETE SUBMIT
        $('#deletecartitem').submit(function (e) {
            e.preventDefault();
            deletecartitem(deleteid);
        });
        //Accept Payment
        $('#acceptpayment').submit(function (e) {
            e.preventDefault();
            if(parseInt($("#cashgiven").val())<parseInt($("#totalcash").val()))
            {
                alertify.error("INSUFFICIENT CASH! PLEASE ENTER CORRECT AMOUNT");
            }
            else
            {
                acceptpayment(tableid);
            }
        });
        //END OF DAY SUBMIT
        $('#endofday').submit(function (e) {
            e.preventDefault();
            endofday();
        });
        //DISCOUNT SUBMIT
        $('#discount').submit(function (e) {
            e.preventDefault();
            discountadd();
        });
        //get elements of product adding
        var itemid,price
        var myModal = document.getElementById('itemadd')
        myModal.addEventListener('shown.bs.modal', function (event) {
            $("#quantity").val('')
            quantityinput.focus();
            // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-* attributes
            itemid = button.getAttribute('data-itemid')
            price = button.getAttribute('data-price')
        })
        //SETTLE PAYMENT ADJUSTMENT
        var settlepayment = document.getElementById('settlepayment')
        var cashgiven = document.getElementById('cashgiven')
        settlepayment.addEventListener('shown.bs.modal', function (event) {
            cashgiven.focus()
            $("#totalcash").val(grandtotal)
        })
        var deleteid,itemname
        var deletemodal = document.getElementById('deleteitem')
        deletemodal.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-* attributes
            deleteid = button.getAttribute('data-id')
            itemname = button.getAttribute('data-name')
            var confirmationtext = deletemodal.querySelector('#confirmationtext')
            confirmationtext.textContent = 'Are you sure you want to Delete ' + itemname + ' ?'
        })
        //READ SALE
        var tablemodal = document.getElementById('read')
        tablemodal.addEventListener('show.bs.modal', function (event) {
            readsales();
        })
        //DETAILS OF SALE
        var tablemodal = document.getElementById('saleofday')
        tablemodal.addEventListener('show.bs.modal', function (event) {
            salesofdaytable();
        })
        //REFUND ITEM DETAILS
        var refunditemmodal = document.getElementById('itemrefund')
        refunditemmodal.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-* attributes
            var refunditemname = button.getAttribute('data-refunditemname') // Extract info from data-* attributes
            var refunditemprice = button.getAttribute('data-refunditemprice') // Extract info from data-* attributes
            var refunditemamount = button.getAttribute('data-refunditemamount') // Extract info from data-* attributes
            var refunditemqty = button.getAttribute('data-refunditemqty') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            $("#refunditemquantity").val(refunditemqty);
            $("#refunditemname").val(refunditemname);
            $("#refunditemprice").val(refunditemprice);
            $("#refunditemamount").val(refunditemamount);

        })
        //DISCOUNT FOCUS
        var myModal = document.getElementById('discount')
        var myInput = document.getElementById('discountinpt')
        myModal.addEventListener('shown.bs.modal', function (event) {
            myInput.focus()
        })
        //START OF DAY FOCUS
        var startofdaymodal = document.getElementById('startofday')
        var cashstartofday = document.getElementById('cashstartofday')
        startofdaymodal.addEventListener('shown.bs.modal', function (event) {
            cashstartofday.focus();
        })
    });
    function calculatecashback()
    {
        $("#changetogive").val($("#cashgiven").val()-grandtotal);
    }
    //Function Start Of Day
    function startofday()
    {
        var cashstartofday = JSON.stringify($("#cashstartofday").val());
        var startdate = JSON.stringify(date);
        $.ajax({
            type: "POST",
            data: {
                "cashstartofday": cashstartofday,
                "startdate": startdate,
                "tablecalled": JSON.stringify("startofday")
            },
            url: "cashierhandling.php",
            dataType: "html",
            success: function (data) {
                {
                    if (data == "success") {
                        alertify.success("DAY STARTED");
                        $("#startofdaybutton").attr("class", "btn btn-primary btn-lg disabled");
                        $("#newshoworderbutton").attr("class", "btn btn-primary btn-lg enabled");
                        $("#endofdaybutton").attr("class", "btn btn-primary btn-lg enabled");
                        $("#refundamountbutton").attr("class", "btn btn-primary btn-lg enabled");

                    } else if(data == "closed") {
                        alertify.error("DAY IS CLOSED");
                    }
                else {
                        alertify.error("DAY IS ALREADY STARTED");
                }
                }
            }
        });
    }
    //Load Products
    function loadproducts(tablecalled, category) {
        var tablecalled = JSON.stringify(tablecalled);
        var categorycalled = JSON.stringify(category);
        $.ajax({
            type: "POST",
            data: {
                "tablecalled": tablecalled,
                "categorycalled": categorycalled
            },
            url: "cashierhandling.php",
            dataType: "html",
            success: function (data) {
                {
                    $("#productshow").html(data);
                }
            }
        });
    }
    //Load Table
    function loadtable() {
        var tablecalled = JSON.stringify('tbltable');
        $.ajax({
            type: "POST",
            data: {
                "tablecalled": tablecalled
            },
            url: "cashierhandling.php",
            dataType: "html",
            success: function (data) {
                {
                    $("#tableshow").html(data);
                }
            }
        });
    }
    //Load Transaction No

    var transactionno;
    function loadtransactionno(tableid) {
        if(tableid==""||tableid==null)
        {
            alertify.error("SELECT TABLE AGAIN");
        }
        else
        {
        var tablecalled = JSON.stringify('loadtransactionno');
        var tableid = JSON.stringify(tableid);
        $.ajax({
            type: "POST",
            data: {
                "tablecalled": tablecalled,
                "tableid": tableid
            },
            url: "cashierhandling.php",
            dataType: "html",
            success: function (data) {
                {
                    document.getElementById("transactionid").textContent= "Transaction #"+data;
                    transactionno=data;
                    showcart(transactionno);
                }
            }
        });
        }
    }
    //ADD Products
    function addproducts(quantity, itemid,price,tableid,transactionno) {
        var quantity = JSON.stringify(quantity);
        var itemid = JSON.stringify(itemid);
        var tablecalled = JSON.stringify('addprodut');
        var price = JSON.stringify(price);
        var tableid = JSON.stringify(tableid);
        var transactionnoobj = JSON.stringify(transactionno);
        $.ajax({
            type: "POST",
            data: {
                "tablecalled": tablecalled,
                "quantity": quantity,
                "itemid": itemid,
                "price": price,
                "tableid": tableid,
                "transactionno": transactionnoobj
            },
            url: "cashierhandling.php",
            dataType: "html",
            success: function (data) {
                {
                    if(data>=0)
                    {
                        alertify.error("ONLY "+data+ " ITEMS LEFT IN STOCK");
                    }
                    else
                    {
                        alertify.success("ITEM ADDED");
                        loadproducts('tblproduct', buttonpressed);
                        showcart(transactionno);
                    }
                    
                }
            }
        });
    }
    //SHOW CART ITEMS
    var total;
    var grandtotal;
    function showcart(transactionno)
    {
        var invoiceid=transactionno;
        var tablecalled = JSON.stringify('showcart');
        var transactionno = JSON.stringify(transactionno);
        $.ajax({
            type: "POST",
            data: {
                "tablecalled": tablecalled,
                "transactionno": transactionno
            },
            url: "cashierhandling.php",
            dataType: "html",
            success: function (data) {
                {
                    $("#showcart").html(data);
                    if($('#showcart tr').length==0)
                    {
                        $("#subtotalprice").html('0')
                        $("#grandtotal").html('0')
                        $("#discountprice").html('0')
                        disablepaymentbutton()
                    }
                    else
                    {
                    enablepaymentbutton()
                    var calculated_total_sum=0;
                    $("#showcart .total-price").each(function () {
                        var get_textbox_value = parseInt($(this).text());
                        if ((get_textbox_value)) {
                            calculated_total_sum += parseFloat(get_textbox_value);
                        }
                    });
                    $("#subtotalprice").html(calculated_total_sum)
                    $("#grandtotal").html(calculated_total_sum)
                    total=calculated_total_sum;
                    checkdiscount();
                }
                }
            }
        });
    }
    function enablepaymentbutton()
    {
        $("#settlepaymentbutton").attr("class", "btn btn-primary btn-lg enabled");
        $("#printbillbutton").attr("class", "btn btn-primary btn-lg enabled");
        $("#kitchenprintbill").attr("class", "btn btn-primary btn-lg enabled");
        $("#discountbutton").attr("class", "btn btn-primary btn-lg enabled");
    }
    function disablepaymentbutton()
    {
        $("#settlepaymentbutton").attr("class", "btn btn-primary btn-lg disabled");
        $("#settlepaymentbutton").attr("class", "btn btn-primary btn-lg disabled");
        $("#discountbutton").attr("class", "btn btn-primary btn-lg disabled");
        $("#printbillbutton").attr("class", "btn btn-primary btn-lg disabled");
        $("#kitchenprintbill").attr("class", "btn btn-primary btn-lg disabled");
    }
    function deletecartitem(deleteid)
    {
        var tablecalled = JSON.stringify('deletecartitem');
        var deleteid = JSON.stringify(deleteid);
        $.ajax({
            type: "POST",
            data: {
                "tablecalled": tablecalled,
                "deleteid": deleteid
            },
            url: "cashierhandling.php",
            dataType: "html",
            success: function (data) {
                if(data=="success")
                {
                    alertify.success("DELETE SUCCESS");
                    showcart(transactionno);
                    loadproducts('tblproduct', buttonpressed);
                }
                else
                {
                    alertify.error("UNABLE TO DELETE");
                }
            }
        });
    }
    function acceptpayment(tableid)
    {
        var tablecalled = JSON.stringify('acceptpayment');
        var time=d.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric',second: 'numeric',  hour12: true })
        var timeobj = JSON.stringify(time);
        $.ajax({
            type: "POST",
            data: {
                "tablecalled": tablecalled,
                "transactionno": JSON.stringify(transactionno),
                "total": JSON.stringify(grandtotal),
                "table": JSON.stringify(tableid),
                "time": timeobj
            },
            url: "cashierhandling.php",
            dataType: "html",
            success: function (data) {
                if(data=="success")
                {
                    alertify.success("TABLE # "+tableid+" ORDER COMPLETED SUCCESSFULLY");
                    loadtransactionno(tableid);
                }
                else
                {
                    alertify.error("UNABLE TO ACCEPT PAYMENT");
                }
            }
        });
    }
    function endofday()
    {
        $.ajax({
            type: "POST",
            data: {
                "tablecalled": JSON.stringify('endofday')
            },
            url: "cashierhandling.php",
            dataType: "html",
            success: function (data) {
                if(data=="success")
                {
                    alertify.success("DAY ENDED SUCCESSFULLY");
                    $("#startofdaybutton").attr("class", "btn btn-primary btn-lg enabled");
                    $("#newshoworderbutton").attr("class", "btn btn-primary btn-lg disabled");
                    $("#endofdaybutton").attr("class", "btn btn-primary btn-lg disabled");
                    $("#readbutton").attr("class", "btn btn-primary btn-lg enabled");
                    tableid='';
                    disablepaymentbutton();
                }
                else
                {
                    alertify.error("MAKE SURE ALL TABLES ARE CLEAR!");
                }
            }
        });
    }
    function checkday()
    {
        $.ajax({
            type: "POST",
            data: {
                "tablecalled": JSON.stringify('checkday')
            },
            url: "cashierhandling.php",
            dataType: "html",
            success: function (data) {
                if(data=="closed")
                {
                    $("#startofdaybutton").attr("class", "btn btn-primary btn-lg enabled");
                    $("#newshoworderbutton").attr("class", "btn btn-primary btn-lg disabled");
                    $("#endofdaybutton").attr("class", "btn btn-primary btn-lg disabled");
                    disablepaymentbutton();
                }
                else
                {

                }
            }
        });
    }
    var dateofsale;
    function readsales()
    {
        $.ajax({
            type: "POST",
            data: {
                "tablecalled": JSON.stringify('readsales')
            },
            url: "cashierhandling.php",
            dataType: "html",
            success: function (data) {
                data=JSON.parse(data);
                $('#sales').text(data[0].sale);
                $('#initialcash').text(data[0].initialcash);
                $('#totalsale').text(data[0].total);
                var discount=0;
                if(data[0].discount!=null){discount=data[0].discount}
                $('#discountaddedtoday').text(discount);
                $('#saleofdaytitle').text("SALES OF DAY "+data[0].date);
                dateofsale=data[0].date;
            }
        });
    }
    function salesofdaytable()
    {
        $.ajax({
            type: "POST",
            data: {
                "tablecalled": JSON.stringify('salesofdaytable'),
                "date":JSON.stringify(dateofsale)
            },
            url: "cashierhandling.php",
            dataType: "html",
            success: function (data) {
                $("#saleofdaybodytable").html(data);
                $('#detailedsaleofdaytitle').text("DETAILS OF SALES OF DAY "+dateofsale);
            }
        });
    }
    //Show Refunditems
    function refunditems() {
        var tablecalled = JSON.stringify('refunditems');
        $.ajax({
            type: "POST",
            data: {
                "tablecalled": tablecalled
            },
            url: "cashierhandling.php",
            dataType: "html",
            success: function (data) {
                {
                    $("#refunditems").html(data);
                }
            }
        });
    }
    function discountcheck()
    {
        $("#subtotalcash").val(total);
        if($("#discountinpt").val()!='')
        {
            document.getElementById("discount").required = true;
            document.getElementById("coupon").setAttribute('disabled','')
            document.getElementById("coupon").required = false;
        }
        else if($("#coupon").val()!='')
        {
            document.getElementById("coupon").removeAttribute("required")
            document.getElementById("discountinpt").removeAttribute("enabled")
            document.getElementById("discountinpt").setAttribute('disabled','')
            document.getElementById("discountinpt").required = false;
        }
        else
        {
            document.getElementById("coupon").required = true;
            document.getElementById("discountinpt").required = true;
            document.getElementById("coupon").removeAttribute("disabled")
            document.getElementById("discountinpt").removeAttribute("disabled")
        }

        if($("#discountinpt").val()>total)
        {
            $("#discountinpt").val('')
        }
        $("#totalafterdiscount").val(total-$("#discountinpt").val());
    }
    function discountadd()
    {
        var discount=parseInt($("#discountinpt").val());
        var tablecalled = JSON.stringify('discountadd');
        $.ajax({
            type: "POST",
            data: {
                "tablecalled": tablecalled,
                "discount": discount,
                "transno": JSON.stringify(transactionno)

            },
            url: "cashierhandling.php",
            dataType: "html",
            success: function (data) {
                {
                    alertify.success("DISCOUNT ADDED!");
                    showcart(transactionno);
                }
            }
        });
    }
    function checkdiscount()
    {
        var tablecalled = JSON.stringify('checkdiscount');
        $.ajax({
            type: "POST",
            data: {
                "tablecalled": tablecalled,
                "transno": JSON.stringify(transactionno)

            },
            url: "cashierhandling.php",
            dataType: "html",
            success: function (data) {
                {
                    if(data>0)
                    {
                        grandtotal=total-data;
                        $("#discountprice").html(data);
                        $("#grandtotal").html(grandtotal);
                    }
                    else
                    {
                        grandtotal=total;
                        $("#grandtotal").html(grandtotal);
                        $("#discountprice").html('0');
                    }

                }
            }
        });

    }
    let myWindow;
    function printDiv() {
        var url="printinvoice.php?tid="+transactionno;
        myWindow = window.open(url, "", "width=1024,height=768");
        setTimeout(function () {
            myWindow.close();
                }, 1000);
    }
    function kitchenprintbill() {
        var url="kitcheninvoice.php?tid="+transactionno+"&table="+tableid;
        myWindow = window.open(url, "", "width=1024,height=768");
        setTimeout(function () {
            myWindow.close();
        }, 1000);
    }


</script>
<!-- jQuery -->
<link rel="stylesheet" href="./includes/alertify/themes/alertify.core.css" />
<link rel="stylesheet" href="./includes/alertify/themes/alertify.default.css" id="toggleCSS" />
<script src="./includes/alertify/src/alertify.js"></script>