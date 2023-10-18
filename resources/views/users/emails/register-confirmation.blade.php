<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mail</title>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="bg-wheat mx-auto">
        <div class="card w-50">
            <div class="card-body">
                <p class="fw-bold h4">Hello {{ $name }}</p>
                <p>Thank you for registering.</p>
                <p>To start, please access the website.</p>
                <a href="{{ $app_url }}" class="btn btn-info">Click here!</a>
                <p class="mt-4">Thank you! <i class="fa-solid fa-handshake-simple"></i></p>
            </div>
        </div>
    </div>

</body>
</html>