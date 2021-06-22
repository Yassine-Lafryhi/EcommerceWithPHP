<html lang="en" class="perfect-scrollbar-off">
<head>
    <meta charset="utf-8">
    <title>
        Register
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
            <div class="row">
                <div class="col-md-3">
                </div>
                <div class="col-md-6">
                    <center><button onclick="location.href='login.php'" class="btn btn-primary btn-round"
                                    type="button">Log in
                        </button></center>
                    <br>
                    <div class="card">
                        <div class="card-header">
                            <h5 style="text-align: center" class="title">Register</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div style="text-align: center" class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="firstName">Your first name :</label>
                                            <input type="text" class="form-control" placeholder="Your first name"
                                                   id="firstName">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="lastName">Your last name :</label>
                                            <input type="text" class="form-control" placeholder="Your last name" id="lastName">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address">Your address :</label>
                                            <input type="text" class="form-control" placeholder="Your address"
                                                   id="address">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="phoneNumber">Your phone number :</label>
                                            <input type="tel" class="form-control" placeholder="Your phone number" id="phoneNumber">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="email">Your email :</label>
                                            <input type="email" class="form-control" placeholder="Your email"
                                                   id="email">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="password">Your password :</label>
                                            <input type="password" class="form-control" placeholder="Your password" id="password">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div style="text-align: center" class="col-md-12">
                                        <div class="form-group">
                                            <button onclick="register()" class="btn btn-primary btn-round"
                                                    type="button">Create new account
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
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
<script src="assets/js/cookie.umd.min.js"></script>
<script src="assets/js/main.js"></script>

<script type="text/javascript">
    var role = cookie.get('role');
    if (role !== undefined) {
        if (role === 'admin') {
            window.location.href = "manage-users.html";
        } else if (role === 'author') {
            window.location.href = "manage-articles.html";
        } else {
            window.location.href = "view-articles.html";
        }
    }
</script>
</body>
</html>
