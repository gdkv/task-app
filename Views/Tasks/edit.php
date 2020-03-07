<h1>Edit task</h1>
<?php if($errors): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $errors; ?>
    </div>
<?php endif; ?>
<form method='post' action='/tasks/edit/<?php echo $task['id'];?>'>
    <div class="form-group">
        <label for="title">User name (to whom assign)</label>
        <input type="text" class="form-control" id="title" placeholder="Enter a name" name="username" value="<?php echo $task['username'];?>" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" placeholder="Enter a email" name="email" value="<?php echo $task['email'];?>" required>
    </div>
    <div class="form-group">
        <label for="description">Task description</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Describe the task" name="text" rows="3" required><?php echo $task['text'];?></textarea>
    </div>
    <div class="form-group">
        <div class="form-check">
            <input class="form-check-input" name="is_closed" type="checkbox" value="" <?php echo ($task['is_closed'] ? "checked='checked'" : "");?> id="defaultCheck1">
            <label class="form-check-label" for="defaultCheck1">
                Task is closed?
            </label>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>