var productsNumber = 0;
var number = 0;

function getProductsList(offset) {
    fetch('/api/api.php?get=products&offset='+offset, {
        headers: {
            'Accept': 'application/json',
        },
        method: 'GET'
    }).then(function (response) {
        return response.json();
    }).then(function (data) {
        $('#all-articles').html('');
        for (var i = 0; i < data.length; i++) {
            let element = '<div style="text-align: center" class="col-md-4">' +
                '<div style="height: 380px; margin-bottom: 12px" class="card">' +
                '<div class="card-header">' +
                '<h5 style="text-align: center" class="card-title">' + data[i].name + '</h5>' +
                '</div>' +
                '<div class="card-body">' +
                '<p><img src="'+'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&dl=battlecreek-coffee-roasters-rsnzc-8dVs0-unsplash.jpgs'+'"width="180px" /></p> ' +
                '<p>' + data[i].price + '</p>' +
                '<button class="btn btn-round btn-success" onclick="getNextProducts()">Add to cart</button><br>'+
                '<button style="margin-top: 8px" class="btn btn-round btn-danger" onclick="getNextProducts()">-</button>'+
                '<span style="margin-top: 8px; margin-left: 12px;margin-right: 12px">Quantity: ' + 1 + '</span>' +
                '<button style="margin-top: 8px" class="btn btn-round btn-info" onclick="getNextProducts()">+</button><br>'+
                '</div>' +
                '</div>' +
                '</div>';
            $('#all-articles').append(element);
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
    fetch('/api/api.php?get=products&number', {
        method: 'GET'
    }).then(function (response) {
        return response.json();
    }).then(function (data) {
        console.log(data);
        productsNumber = parseInt(data.message);
        getNextProducts();
        document.getElementById("previous").disabled = true;
    });
}
