<?php
session_start();
?>

<html lang="en" class="perfect-scrollbar-off">
<head>
    <meta charset="utf-8">
    <title>
        View Products
    </title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no"
          name="viewport">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
<body class="user-profile">
<div class="wrapper ">
    <div class="main-panel" id="main-panel">
        <div class="content">
            <center>
                <button id="viewCart" onclick="location.href='cart.php'" class="btn btn-danger btn-round"
                        type="button">View cart
                </button>
            </center>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 style="text-align: center" class="card-title">Products List</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">

                                </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Search here for products"
                                           id="query">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button id="next" class="btn btn-round btn-info" onclick="searchForProducts()">Search
                                    </button>
                                </div>
                            </div>
                            </div>
                            <div style="text-align: center" class="col-md-12">
                                <h4>Pagination</h4>
                                <button id="previous" class="btn btn-round btn-success"
                                        onclick="getPreviousProducts()">Previous
                                </button>
                                <button id="next" class="btn btn-round btn-info" onclick="getNextProducts()">Next
                                </button>
                                <br>
                            </div>
                            <br>
                            <div style="text-align: center" class="col-md-12">
                                <div id="all-products" class="row"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/main.js"></script>

<script>
    getProductsNumber();
    getCartItemsNumber();
</script>

</body>
</html>

