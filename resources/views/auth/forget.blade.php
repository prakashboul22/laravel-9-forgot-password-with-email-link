<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Reset Password</title>
</head>

<body class="bg-dark">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" id="updatePassword">
                            @csrf
                            <div class="mb-2">
                                <label for="" class="form-label">Your Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ $email }}" readonly>
                                <input type="hidden" class="form-control" id="email" name="ftoken"
                                    value="{{ $ftoken }}">
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Password</label>
                                <input type="text" class="form-control" id="password" name="password">
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm w-100" id="updatePasswordbtn">Update
                                Password</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#updatePassword").submit(function(e) {
                e.preventDefault();
                $("#updatePasswordbtn").text('Please Wait...');

                $.ajax({
                    type: "POST",
                    url: "{{ route('auth.passwordreset') }}",
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status == 200) {
                            alert('Update');
                        } else {
                            alert('Fail to update');
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
