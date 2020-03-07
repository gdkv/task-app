<div class="mb-3">
    <ul class="nav justify-content-end">
        <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Sort by: </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/tasks/index/?order=username&sort=<?php echo ($sort=='ASC'||!$sort?'DESC':'ASC'); ?>">
                User 
                <span class="badge badge-secondary"><?php echo ($sort=='ASC'||!$sort?'Z->A':'A->Z'); ?></span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/tasks/index/?order=email&sort=<?php echo ($sort=='ASC'||!$sort?'DESC':'ASC'); ?>">
                Email 
                <span class="badge badge-secondary"><?php echo ($sort=='ASC'||!$sort?'Z->A':'A->Z'); ?></span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/tasks/index/?order=is_closed&sort=<?php echo ($sort=='ASC'||!$sort?'DESC':'ASC'); ?>">
                Status 
                <span class="badge badge-secondary"><?php echo ($sort=='ASC'||!$sort?'Cl->Op':'Op->Cl'); ?></span>
            </a>
        </li>
    </ul>
</div>

<div class="row">
    <?php foreach($tasks as $task): ?>
        <div class="col-sm-6">
            <div class="card mb-5">
                <?php if($task['is_closed']): ?>
                    <div class="card-header bg-success"><small>Closed</small></div>
                <?php else: ?>
                    <div class="card-header bg-warning"><small>Open</small></div>
                <?php endif; ?>
                <div class="card-body">
                <h5 class="card-title">
                    <?php echo $task['username'];?>
                    <span class="badge badge-secondary">#<?php echo $task['id'];?></span>
                </h5>
                <h6><?php echo $task['email'];?></h6>
                <small class="text-muted">Date: <?php echo $task['edit_at'];?></small>
                <p class="card-text">
                    <?php echo $task['text'];?>
                </p>
                <?php if ($USER->isLoggedIn()): ?>
                    <a href="/tasks/edit/<?php echo $task['id']; ?>" class="card-link">Edit</a>
                    <a href="/tasks/delete/<?php echo $task['id']; ?>" class="text-danger card-link">Delete</a>
                <?php endif;?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php if(!count($tasks)): ?>
    <p>There is no tasks here, try to <a href="/tasks/add/">add one</a> 🚀</p>
<?php endif;?>

<div class="mt-3">
    <nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php for($i = 0; $i < $pages; $i++): ?>
            <li class="page-item <?php echo ($current==$i+1 ? "active" : ""); ?>">
                <a class="page-link" 
                    href="/tasks/index/?page=<?php echo $i+1 . ($order ? "&order={$order}" : "") . ($order ? "&sort={$sort}" : "");?>">
                    <?php echo $i+1;?>
                </a>
            </li>
        <?php endfor; ?>
    </ul>
    </nav>
</div>