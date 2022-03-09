<style>
    .login-form {
        width: 340px;
        margin: 50px auto;
    }

    .login-form form {
        margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }

    .login-form h2 {
        margin: 0 0 15px;
    }

    .form-control,
    .btn {
        min-height: 38px;
        border-radius: 2px;
    }

    .btn {
        font-size: 15px;
        font-weight: bold;
    }
</style>
</head>

<body>
    <div class="login-form">
        <form action="/examples/actions/confirmation.php" method="post">
            <h2 class="text-center">Sign up</h2>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Full Name" id="fullname">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Username" id="username">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" placeholder="Email" id="email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" id="password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Confirm Password" id="conf_password">
            </div>
            <div class="form-group">
                <label for="imgFile">Image File</label>
                <input type="file" id="imgFile">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </div>
        </form>
    </div>
</body>

</html>