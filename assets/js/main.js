var productsNumber = 0;
var number = 0;

function searchForProducts(){
    let query = document.getElementById("query").value;
    $.ajax({
        url: '/api/api.php?get=search&query=' + query,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#all-products').html('');
            for (var i = 0; i < data.length; i++) {
                let element = '<div style="text-align: center" class="col-md-4">' +
                    '<div style="height: 380px; margin-bottom: 12px" class="card">' +
                    '<div class="card-header">' +
                    '<h5 style="text-align: center" class="card-title">' + data[i].name + '</h5>' +
                    '</div>' +
                    '<div class="card-body">' +
                    '<p><img src="' + 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&dl=battlecreek-coffee-roasters-rsnzc-8dVs0-unsplash.jpgs' + '"width="180px" /></p> ' +
                    '<p>' + data[i].price + ' $ </p>' +
                    '<button id="addToCartButton' + data[i].sku + '" class="btn btn-round btn-success" onclick="addProductToCart(' + data[i].sku + ')">Add to cart</button><br>' +
                    '<button id="incrementQuantity' + data[i].sku + '" style="display:none;margin-top: 8px" class="btn btn-round btn-danger" onclick="incrementQuantity(' + data[i].sku + ')">-</button>' +
                    '<span style="margin-top: 8px; margin-left: 12px;display:none;margin-right: 12px">Quantity: ' + 1 + '</span>' +
                    '<button id="decrementQuantity' + data[i].sku + '" style="display:none;margin-top: 8px" class="btn btn-round btn-info" onclick="decrementQuantity(' + data[i].sku + ')">+</button><br>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                $('#all-products').append(element);
            }
        }
    });
}
function getProductsList(offset) {
    $.ajax({
        url: '/api/api.php?get=products&offset=',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#all-products').html('');
            for (var i = 0; i < data.length; i++) {
                let element = '<div style="text-align: center" class="col-md-4">' +
                    '<div style="height: 380px; margin-bottom: 12px" class="card">' +
                    '<div class="card-header">' +
                    '<h5 style="text-align: center" class="card-title">' + data[i].name + '</h5>' +
                    '</div>' +
                    '<div class="card-body">' +
                    '<p><img src="' + 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&dl=battlecreek-coffee-roasters-rsnzc-8dVs0-unsplash.jpgs' + '"width="180px" /></p> ' +
                    '<p>' + data[i].price + ' $ </p>' +
                    '<button id="addToCartButton' + data[i].sku + '" class="btn btn-round btn-success" onclick="addProductToCart(' + data[i].sku + ')">Add to cart</button><br>' +
                    '<button id="incrementQuantity' + data[i].sku + '" style="display:none;margin-top: 8px" class="btn btn-round btn-danger" onclick="incrementQuantity(' + data[i].sku + ')">-</button>' +
                    '<span style="margin-top: 8px; margin-left: 12px;display:none;margin-right: 12px">Quantity: ' + 1 + '</span>' +
                    '<button id="decrementQuantity' + data[i].sku + '" style="display:none;margin-top: 8px" class="btn btn-round btn-info" onclick="decrementQuantity(' + data[i].sku + ')">+</button><br>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                $('#all-products').append(element);
            }
        }
    });
}

function getNextProducts() {
    document.getElementById("previous").disabled = false;
    if (number < productsNumber) {
        getProductsList(number);
        number += 5;
    }
    if (number === productsNumber) {
        document.getElementById("next").disabled = true;
        number -= 5;
    }
}

function getPreviousProducts() {
    if (number === 5) {
        document.getElementById("previous").disabled = true;
    }
    if (number > 0) {
        number -= 5;
        getProductsList(number);
    }
    if (document.getElementById("next").disabled) {
        document.getElementById("next").disabled = false;
    }
}

function getProductsNumber() {
    $.ajax({
        url: '/api/api.php?get=products&number',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log(data);
            productsNumber = parseInt(data.message);
            getNextProducts();
            document.getElementById("previous").disabled = true;
        }
    });
}

function getCartItemsNumber() {
    $.ajax({
        url: '/api/api.php?get=cartCount',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            let number = data.number;
            document.getElementById("viewCart").innerText = 'View cart ('+number+')';
        }
    });
}

function addProductToCart(id) {
    const body = {
        post: 'cart',
        product: id,
        quantity: 1
    }
    $.ajax({
        url: '/api/api.php',
        type: 'POST',
        dataType: 'json',
        data:JSON.stringify(body),
        success: function(data) {
            if (data.code === 1) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'This product is added successfully to your cart !',
                    showConfirmButton: false,
                    timer: 2000
                }).then((result) => {
                    getCartItemsNumber();
                    let button = document.getElementById("addToCartButton" + id);
                    let increment = document.getElementById("incrementQuantity" + id);
                    let decrement = document.getElementById("decrementQuantity" + id);
                    button.style.display = 'none';
                    increment.style.display = 'inline-block';
                    decrement.style.display = 'inline-block';
                });
            }
        }
    });
}

function incrementQuantity(id) {
    const body = {
        post: 'increment',
        product: id
    }
    $.ajax({
        url: '/api/api.php',
        type: 'POST',
        dataType: 'json',
        data:JSON.stringify(body),
        success: function(data) {
            if (data.code === 1) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'This product is added successfully to your cart !',
                    showConfirmButton: false,
                    timer: 2000
                }).then((result) => {

                });
            }
        }
    });
}

function decrementQuantity(id) {
    const body = {
        post: 'decrement',
        product: id
    }
    $.ajax({
        url: '/api/api.php?get=cart',
        type: 'POST',
        dataType: 'json',
        data:JSON.stringify(body),
        success: function(data) {
            if (data.code === 1) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'This product is added successfully to your cart !',
                    showConfirmButton: false,
                    timer: 2000
                }).then((result) => {

                });
            }
        }
    });
}

function getCartElements() {
    $.ajax({
        url: '/api/api.php?get=cart',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            for (var j = 0; j < data.length; j += 1) {
                addCartItemToTable(data, j)
            }
        }
    });
}

function addCartItemToTable(data, j) {
    $.ajax({
        url: '/api/api.php?get=product&id=' + data[j].product,
        type: 'GET',
        dataType: 'json',
        success: function(product) {
            var tr;
            $('#list').html('');
            for (var i = 0; i < data.length; i++) {
                tr = $('<tr/>');
                tr.append("<td style='text-align: center'>" + (i + 1) + "</td>");
                tr.append("<td style='text-align: center'>" + product.name + "</td>");
                tr.append("<td style='text-align: center'>" + product.price + " $ </td>");
                tr.append("<td style='text-align: center'>" + data[i].quantity + "</td>");
                tr.append("<td style='text-align: center'>" + (data[i].quantity * product.price) + " $ </td>");
                tr.append("<td style='text-align: center'><button onclick='updateUser(" + data[i].id + ")' style='margin-right: 8px' class=\"btn btn-warning btn-round\" type=\"button\">Update</button><button onclick='deleteUser(" + data[i].id + ")' class=\"btn btn-danger btn-round\" type=\"button\">Delete</button></td>")
                $('#list').append(tr);
            }
        }
    });
}
