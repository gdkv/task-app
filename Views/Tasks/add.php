<h1>Create task</h1>
<?php if($errors): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $errors; ?>
    </div>
<?php endif; ?>
<form method='post' action='/tasks/add'>
    <div class="form-group">
        <label for="username">User name (to whom assign)</label>
        <input type="text" class="form-control" id="username" placeholder="Enter a name" name="username" value="" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" placeholder="Enter a email" name="email" required>
    </div>
    <div class="form-group">
        <label for="text">Task description</label>
        <textarea class="form-control" id="text" placeholder="Describe the task" name="text" rows="3" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>