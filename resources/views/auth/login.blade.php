<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="/css/style.css">
        <script src="{{ asset('js/jQuery-3.7.1.js') }}"></script>
        <style>
            body {
                background-color: #f0f2f5;
                font-family: Arial, sans-serif;
            }

            .login-container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }

            .login-form {
                background-color: white;
                padding: 2rem;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                width: 100%;
                max-width: 500px;
            }

            h2{
                text-align: center;
            }
        </style>
    </head>

    <body>
        <div class="login-container">
            <form class="login-form" method="POST" id="login-form">
                @csrf
                <h2>Login</h2>
                <h6 style="text-align:center; margin-top:5px; color:#248616;" id="message"></h6>
                <div class="form-input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-input"
                        @if(isset($_COOKIE ["email"])) value="{{ $_COOKIE["email"]}}" @endif >
                    <span class="error" id="email_error"></span>
                </div>
                <div class="form-input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-input">
                    <span class="error" id="password_error"></span>
                    <span class="error" id="error"></span>
                </div>
                <div style="display: flex; justify-content:space-between; margin-bottom:10px;">
                    <div class="input">
                        <input type="checkbox" id="remember" name="remember" @if(isset($_COOKIE ["email"])) checked @endif>
                        <label for="remember">Remember Me</label>
                    </div>
                    <a href="{{ route('forgotPassword') }}">Forgot Your Password?</a>
                </div>
                <div class="center">
                    <input type="submit" class="btn-blue" id="login" value="Login">
                </div>
            </form>
        </div>

        <script>
            
            $(document).ready(function () {
                var apiUrl = "{{ config('app.api_url') }}";
                console.log(apiUrl);
                
                const message = sessionStorage.getItem('redirectMessage');
                
                if (message) {
                    $('#message').html(message)
                    sessionStorage.removeItem('redirectMessage');
                }
                
                $(document).on('submit', '#login-form', function (e) {
                    e.preventDefault();
                    let isValid = true;
                    let formData = new FormData(this);

                    let email = $('#email').val();
                    let password = $('#password').val();

        
                    // Validate Product
                    if (!email) {
                        isValid = false;
                        $('#email_error').html('Email is required');
                    }
                    else{
                        $('#email_error').html('');
                    }

                    if (!password) {
                        isValid = false;
                        $('#password_error').html('Password is required');
                    }
                    else{
                        $('#password_error').html('');
                    }

                    if(isValid){
                        $.ajax({
                            url: `${apiUrl}/login`,
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            xhrFields: {
                                withCredentials: true, // Send session cookies
                            },
                            success: function(response) {
                                console.log('Hi');
                                localStorage.setItem('token', response.token);
                                window.location.href = '/dashboard';
                            },
                            error: function(response) {
                                if (response.responseJSON && response.responseJSON.domain) {
                                    window.location.href = 'https://' + response.responseJSON.domain +'.teamsolutionsbangladesh.com/login';
                                }

                                if (response.responseJSON && response.responseJSON.notice) {
                                    $('#error').html(response.responseJSON.notice)
                                }
                                if (response.responseJSON && response.responseJSON.redirect) {
                                    sessionStorage.setItem('redirectMessage', response.responseJSON.message);
                                    window.location.href = response.responseJSON.redirect;
                                }
                            }
                        });
                    }
                    
                    
                });
            });
        </script>
    </body>
</html>