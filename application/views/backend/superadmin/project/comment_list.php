<?php  if(empty($comments_tree)): ?>
    <p class="text-muted text-center py-4"><?php echo get_phrase('no_comments_yet'); ?></p>
<?php endif; ?>

<?php foreach($comments_tree as $parent): 
    $role_class = ($parent['role'] == 'admin') ? 'comment-admin' : (($parent['role'] == 'donor') ? 'comment-donor' : 'comment-ministry');
?>
    <!-- Parent Comment -->
    <div class="comment-box <?= $role_class; ?>">
        <div class="d-flex justify-content-between mb-1">
            <div>
                <strong>
                    <?= $parent['user_name']; ?> 
                    <?php if(!empty($parent['inst_abbr'])): ?>
                        <span class="text-primary">(<?= $parent['inst_abbr']; ?>)</span>
                    <?php endif; ?>
                </strong>
                <?php if(!empty($parent['user_address'])): ?>
                    <small class="text-muted d-block italic-post"><i class="mdi mdi-briefcase-outline me-1"></i><?= $parent['user_address']; ?></small>
                <?php endif; ?>
            </div>
            <small class="text-muted"><?= $this->crud_model->get_time_ago($parent['created_at']); ?></small>
        </div>
        <p class="mb-0 text-dark"><?= nl2br($parent['message']); ?></p>
        <span class="reply-btn" onclick="toggleReplyForm(<?= $parent['id']; ?>)"><i class="mdi mdi-reply"></i> <?php echo get_phrase('reply'); ?></span>
        
        <div class="hidden-reply-form" id="reply-form-<?= $parent['id']; ?>">
            <form class="comment-ajax-form" action="<?= route('project/add_comment/project/'.$parent['resource_id']); ?>" method="POST">
                <input type="hidden" name="parent_id" value="<?= $parent['id']; ?>">
                <div class="input-group">
                    <textarea name="message" class="form-control" rows="1" placeholder="..." required></textarea>
                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-send"></i></button>
                </div>
            </form>
        </div>
    </div>

    <!-- Replies -->
    <?php if(!empty($parent['replies'])): ?>
        <?php foreach($parent['replies'] as $reply): 
            $reply_role_class = ($reply['role'] == 'admin') ? 'comment-admin' : (($reply['role'] == 'donor') ? 'comment-donor' : 'comment-ministry');
        ?>
            <div class="comment-box reply-box <?= $reply_role_class; ?>">
                <div class="d-flex justify-content-between mb-1">
                    <div>
                        <i class="mdi mdi-arrow-right-bottom text-muted me-1"></i> 
                        <strong><?= $reply['user_name']; ?> (<?= $reply['inst_abbr']; ?>)</strong>
                        <?php if(!empty($reply['user_address'])): ?>
                            <small class="text-muted d-block ps-4 italic-post"><?= $reply['user_address']; ?></small>
                        <?php endif; ?>
                    </div>
                    <small class="text-muted"><?= $this->crud_model->get_time_ago($reply['created_at']); ?></small>
                </div>
                <p class="mb-0 text-muted small"><?= nl2br($reply['message']); ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endforeach; ?>