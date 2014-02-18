<h2><a href="<?php echo url_for("/"); ?>">Home</a> - Photo Overview</h2>

<div id="photoSingle">

  <div class="photo">
    <img src="/uploads/photos/<?php echo $photo->getTitle();?>" />
    
    <ul class="photoInfo">
    	<li><strong>Uploaded:</strong> <?php echo $photo->getCreatedat(); ?></li>
      <li><strong>Theme:</strong> <?php echo $theme->getTitle(); ?></li>
      <li><strong>Author:</strong> <?php echo $user->getName();?></li>
    </ul>    
    
    <div class="description"><?php echo $photo->getDescription(); ?></div>

    <div id="comments">
      <ul class="commentlist" id="comments-list">
      <?php foreach($comments as $c):?>
        <li id="li-comment-65" class="comment">
          <div class="comment-author vcard">
            <?php echo $c->getUser()->getName();?> said:
          </div>
          <p class="commentContent"><?php echo $c->getDescription();?></p>
        </li>
      <?php endforeach;?>
      </ul>

		<?php if($sf_user->isAuthenticated()):?>
      <form id="commentForm" method="post" action='<?php echo url_for("comment/add"); ?>'>
        <input type='hidden' name='user_id' value='<?php echo $sf_user->getUserObject()->getId(); ?>' />
        <input type='hidden' name='photo_id' value='<?php echo $photo->getId(); ?>' />
        <textarea id="commentInput" name="description" rows="5"  required placeholder="Leave a comment on this photo. Be nice." min="10"></textarea>
        <button type=submit>Submit Comment</button>
      </form>
    <?php endif;?>  

  </div>

</div>

</div> 
