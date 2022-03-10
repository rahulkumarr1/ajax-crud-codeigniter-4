<style>
    .login-form {
        width: 450px;
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
        <form action="#" id="registerForm" method="post" autocomplete="off" enctype="multipart/form-data">
            <h2 class="text-center">Sign up</h2>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Full Name" name="fullname" id="fullname">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Username" name="username" id="username">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Email" name="email" id="email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="password" id="password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Confirm Password" name="conf_password" id="conf_password">
            </div>
            <div class="form-group">
                <label for="imgFile">Multiple Image Files</label>
                <input type="file" name='images[]' multiple="" class="form-control" id="image_file">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-primary btn-block" id="submitreg">Register</button>
            </div>
            <div id="response"></div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $(window.document).on('click', '#submitreg', function() {
                var flag = true;
                var errors = "";
                $("#response").html("");
                // cannot be empty:
                var arrEmptyVal = ['#fullname', '#username', '#password', '#conf_password', '#email'];
                var arrLbl = {'#fullname': 'Full name', '#username': 'Username', "#password": 'Password', "#conf_password": 'Confirm Password', "#email": 'Email'};
                for (var i = 0; i < arrEmptyVal.length; i++) {
                    var f = arrEmptyVal[i];
                    var value = $(f).val();
                    if (value.length < 1) {
                        flag = false;
                        errors += '<div class="alert alert-danger" style="padding:5px;margin-bottom:5px;">The ' + arrLbl[f] + ' field is required.</div>';
                    }
                }

                // email:
                var email = $('#email').val();
                if (email != '') {
                    var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
                    if (!(emailExp.test(email))) {
                        errors += '<div class="alert alert-danger" style="padding:5px;margin-bottom:5px;">Email Address is invalid.</div>';
                        flag = false;
                    }
                }


                // validate password.
                var p1 = $('#password').val();
                var p2 = $('#conf_password').val();
                if (p1 != '' && p2 != '') {
                    if (!(p1 === p2)) {
                        flag = false;
                        errors += '<div class="alert alert-danger" style="padding:5px;margin-bottom:5px;">Passwords don\'t match! </div>';
                    }
                }

                // Multiple file:
                var imageFile = $('#image_file').val();
                if (imageFile == '') { 
                    flag = false;
                    errors += '<div class="alert alert-danger" style="padding:5px;margin-bottom:5px;">The Image file is required.</div>';
                }
                if (flag == false) {
                    $("#response").html(errors);
                    return false;
                } else {
                    var formData = $('#registerForm')[0];
                    var userFormData = new FormData(formData);
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url('register-user'); ?>',
                        data: userFormData,
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            $("#response").html("");
                        },
                        success: function(response) {
                            // console.log(response);
                            if(response=='success'){
                                setTimeout(function() {
                                    location.href = '<?= base_url('login'); ?>';
                                },1500);
                                $("#response").html('<div class="alert alert-success" style="padding:5px;margin-bottom:5px;">User registered successfully</div>');
                            }else{
                                $("#response").html(response);
                            }
                            
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>