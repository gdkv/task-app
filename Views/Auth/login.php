<h1>Login form</h1>
<form method='post' action='/auth/login'>
    <?php if($errors): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errors; ?>
        </div>
    <?php endif; ?>
    <div class="form-group">
        <label for="login">Login</label>
        <input type="text" class="form-control" id="login" placeholder="Login" name="login" value="" require>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Enter a password" name="password" require>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>