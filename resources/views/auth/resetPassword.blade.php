<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
    <link rel="stylesheet" href="/css/style.css">
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
        <form class="forget-pass" id="change-pass" method="POST" >
            @csrf
            <h2>Reset Password</h2>
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="form-input-group">
                <label for="email">Email</label>
                <input id="email" class="form-input" type="email" name="email" required autofocus value="{{ $email }}" readonly/>
                <span class="error" id="email_error"></span>
            </div>
            <div class="form-input-group">
                <label for = "password">Password<span class="red">*</span></label>
                <input type="password" name="password" id="password" class="form-input">
                <span class="error" id="password_error"></span>
            </div>
            <div class="form-input-group">
                <label for = "password_confirmation">Confirm Password<span class="red">*</span></label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input">
                <span class="error" id="password_confirmation_error"></span>
                <span class="error" id="error"></span>
            </div>

            <div class="center submit">
                <input class="btn-blue" type="submit" value="Submit">
            </div>
        </form>
        <script>
            var apiUrl = "{{ config('app.api_url') }}";
            $(document).on('submit', '#change-pass', function(e){
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    url: `${apiUrl}/resetpassword`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function(response, settings) {
                        $(document).find('span.error').text('');
                    },
                    success: function(response) {
                        if (response.redirect) {
                            sessionStorage.setItem('redirectMessage', response.message);
                            window.location.href = response.redirect;
                        }
                    },
                    error: function(error) {
                        if(error.responseJSON.errors){
                            $.each(error.responseJSON.errors, function (key, value) {
                                $('#' + key + "_error").text(value);
                            });
                        }
                        $('#error').text(error.responseJSON.message);
                    }
                });
            });
        </script>
    </div>
</body>
</html>