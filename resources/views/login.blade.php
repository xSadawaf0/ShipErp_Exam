<!DOCTYPE html>
<html>
  <head>
    <title>Login Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  </head>


  <body>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 col-sm-8">
          <div class="card">
            <div class="card-body">
              <h1 class="card-title text-center">Login</h1>
              <form id="loginForm">
                <div class="form-group">
                    <label for="email">Email address:</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" class="btn btn-primary btn-block" id="loginButton">Login</button>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  </body>

  <script>

    $(document).ready(function() {
        $('#loginForm').submit(function(event) {
            event.preventDefault();
            $.ajax({
            type: 'POST',
            url: 'api/v1/login',
            data: $(this).serialize(),
                success: function(data) {
                    if (data.success == false) {
                        alert(data.message);
                    }else{
                        sessionStorage.setItem('userData', JSON.stringify(data.data));
                        window.location.href = "{{ route('landing') }}";
                    }
                },
                error: function(XHR, textStatus, errorThrown) {
                    alert('Error: ' + errorThrown);
                }
            });
        });
    });

  </script>

</html>
