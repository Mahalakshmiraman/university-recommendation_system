<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./assets/bootstrap.css">
    <script src="./assets/jquery.js"></script>
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #a7c5ff 0%, #dbc8ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-container {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin: 1rem;
        }

        .tab-buttons {
            display: flex;
            margin-bottom: 2rem;
            background: #f8f9fa;
            border-radius: 2rem;
            padding: 0.3rem;
        }

        .tab-button {
            flex: 1;
            padding: 0.5rem;
            border: none;
            border-radius: 2rem;
            background: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .tab-button.active {
            background: #0d6efd;
            color: white;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-control {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
        }

        .btn-primary {
            width: 100%;
            padding: 0.75rem;
            border-radius: 0.5rem;
            background: #0d6efd;
            border: none;
            margin-top: 1rem;
        }

        .bottom-text {
            text-align: center;
            margin-top: 1rem;
        }

        .bottom-text a {
            color: #0d6efd;
            text-decoration: none;
        }

        #signupForm {
            display: none;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="tab-buttons">
            <button class="tab-button active" id="loginTab">Login</button>
            <button class="tab-button" id="signupTab">Signup</button>
        </div>

        
        <form id="loginForm">
            <div class="form-group">
                <input type="email" id="loginEmail" class="form-control" placeholder="Email Address" required>
            </div>
            <div class="form-group">
                <input type="password" id="loginPassword" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary" id="loginSubmit">Login</button>
            <p class="bottom-text">
                Create an account <a href="#" id="goToSignup">Signup now</a>
            </p>
        </form>

        
        <form id="signupForm">
            <div class="form-group">
                <input type="text" id="studname" class="form-control" placeholder="Name" required>
            </div>
            <div class="form-group">
                <input type="email" id="signupEmail" class="form-control" placeholder="Email Address" required>
            </div>
            <div class="form-group">
                <input type="password" id="signupPassword" class="form-control" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="password" id="confirmPassword" class="form-control" placeholder="Confirm password" required>
            </div>
            <button type="submit" class="btn btn-primary" id="signupSubmit">Signup</button>
            <p class="bottom-text">
                Already have an account? <a href="#" id="goToLogin">Login</a>
            </p>
        </form>
    </div>


    <form id="hiddenform" action="mainpage.php" method="post">
        <input type="hidden" id="studid" name="studid" value="">
        

    </form>
    <script>
        $(document).ready(function() {
            
            showForm('login');

            
            $('#loginTab').click(function() {
                $(".form-control").val('')
                showForm('login');
            });
            
            $('#signupTab').click(function() {
                $(".form-control").val('')
                showForm('signup');
            });
            
            
            $('#goToSignup').click(function(e) {
                e.preventDefault();
                showForm('signup');
            });

            
            $('#goToLogin').click(function(e) {
                e.preventDefault();
                showForm('login');
            });

            
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();
                var email = $('#loginEmail').val();
                var password = $('#loginPassword').val();

                $.ajax({
                    url: 'backend.php',
                    type: 'POST',
                    data: {
                        signin: true,
                        email: email,
                        password: password
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.status === 1) {
                            alert('Login successful');

                            $("#studid").val(data.studid);
                            $("#hiddenform").submit();

                        } else {
                            alert('Incorrect email or password');
                        }
                    }
                });
            });

            
            $('#signupForm').on('submit', function(e) {
                e.preventDefault();
                var name = $('#studname').val();
                var email = $('#signupEmail').val();
                var password = $('#signupPassword').val();
                var confirmPassword = $('#confirmPassword').val();
                var phone = $('#studphone').val();

                
                if (password !== confirmPassword) {
                    alert('Passwords do not match');
                    return;
                }

                $.ajax({
                    url: 'backend.php',
                    type: 'POST',
                    data: {
                        signup: true,
                        studname: name,
                        email: email,
                        password: password,
                        phno: phone
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data === 1) {
                            alert('Signup successful');
                            showForm('login');
                        } else if (data === 2) {
                            alert('Email already exists');
                        } else {
                            alert('An error occurred. Please try again.');
                        }
                    }
                });
            });

            
            function showForm(formType) {
                if (formType === 'login') {
                    $('#loginForm').show();
                    $('#signupForm').hide();
                    $('#loginTab').addClass('active');
                    $('#signupTab').removeClass('active');
                } else {
                    $('#loginForm').hide();
                    $('#signupForm').show();
                    $('#loginTab').removeClass('active');
                    $('#signupTab').addClass('active');
                }
            }
        });
    </script>
</body>
</html>
