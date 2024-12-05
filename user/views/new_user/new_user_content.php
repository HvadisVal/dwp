<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New User</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/dwp/user/assets/css/new_user.css">
</head>
<body>
    <div class="container">
        <h2>Create New User</h2>
        <div id="message" class="error-message"></div>

        <!-- User Registration Form -->
        <form id="newUserForm" class="col s12">
            <div class="row">
                <div class="input-field col s12">
                    <input id="username" name="user" type="text" class="validate" required>
                    <label for="username">Username</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="email" name="email" type="email" class="validate" required>
                    <label for="email">Email</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="phone" name="phone" type="text" class="validate" required>
                    <label for="phone">Telephone Number</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="password" name="pass" type="password" class="validate" required>
                    <label for="password">Password</label>
                </div>
            </div>
            <button class="btn waves-effect waves-light" type="submit">Create</button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/dwp/user/assets/js/new_user.js"></script>
</body>
</html>
