<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forget Password</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="{{ asset('js/jQuery-3.7.1.js') }}"></script>
    <style>
        body {
            background-color: #f0f2f5;
            font-family: Arial, sans-serif;
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .forget-pass{
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h2{
            text-align: center;
            font-size: 30px;
            margin: 10px 0 20px 0;
        }

        .instructions{
            background-color: #f5f5f5;
            border: 1px solid #e3e3e3;
            border-radius: 6px;
            padding: 20px;
            line-height: 28px;
            font-size: 25px;
            text-align: justify;

        }

        .submit{
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <form class="forget-pass" id="forget-pass" method="POST" >
            @csrf
            <h2>Forget Password</h2>
            
            <div class="form-input-groupe">
                <label for="email">Email</label>
                <input id="email" class="form-input" type="email" name="email" autofocus placeholder="Enter your email here.." />
                <span class="error" id="error" style="color:#dc3545;"></span>
                <span class="message" id="message" style="color:#007500ee;"></span>
            </div>
            <div class="center submit">
                <input class="btn-blue" type="submit" value="Submit">
            </div>

            <div class="instructions">
                <p>* Please enter your email shortly you will receive an mail with a verification code, the verification code will be needed to reset your password.</p>
                <p>** Please note: verified email address is required for password reset.</p>
            </div>
        </form>
        <script>
            var apiUrl = "{{ config('app.api_url') }}";
            $(document).on('submit', '#forget-pass', function(e){
                e.preventDefault();

                let email = $('#email').val();
                let frontend_url = window.location.origin;
                if (!email) {
                    $('#error').text('Please enter your email address.');
                    return;
                }

                $.ajax({
                    url: `${apiUrl}/forgotpassword`,
                    type: 'POST',
                    data: { email, frontend_url },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    beforeSend: function(response, settings) {
                        $(document).find('span.error').text('');
                        $(document).find('span.message').text('');
                    },
                    success: function(response) {
                        $('#message').text(response.message)
                    },
                    error: function(error) {
                        console.log(error);
                        
                        $('#error').text(error.responseJSON.message);
                    }
                });
            });
        </script>
    </div>
</body>
</html>