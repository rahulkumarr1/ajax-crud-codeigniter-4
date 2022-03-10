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
    <div class="login-form text-center">
        <form action="/examples/actions/confirmation.php" method="post">
            <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
            <h2 class="text-center mb-3 font-weight-normal">Please sign in</h1>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Username" name="username" id="username">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" name="pass" id="pass">
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary btn-block" id="loginBtn">Log in</button>
                </div>
                <div id="response"></div>
                <div class="clearfix">
                    <label class="pull-left checkbox-inline"><input type="checkbox"> Remember me</label>
                    <a href="<?= base_url('register') ?>" class="pull-right">Create an Account</a>
                </div>                
        </form>
        
    </div>

    <script>
        $(document).ready(function() {
            $(window.document).on('click', '#loginBtn', function() {
                var uname = $('#username').val();
                var pass  = $('#pass').val();

                if(uname!='' && pass!=''){
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url('login-user'); ?>',
                        data: {username: uname, password:pass},
                        beforeSend: function() {
                            $("#response").html("");
                        },
                        success: function(response) {
                            // console.log(response);
                            if(response === 'success'){
                                setTimeout(function() {
                                    location.href = '<?= base_url('manage-user'); ?>';
                                },1000);
                                $("#response").html('<div class="alert alert-success" style="padding:5px;margin-bottom:5px;">User successfully login!</div>');
                            }else{
                                $("#response").html(response);
                            }                            
                        }
                    });
                }else{
                    $('#response').html('<div class="alert alert-danger" style="padding:5px;margin-bottom:5px;">Please enter username and password.</div>');
                }
            });
        });
    </script>
</body>

</html>