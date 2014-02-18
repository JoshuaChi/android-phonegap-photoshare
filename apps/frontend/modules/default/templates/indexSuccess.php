<h2>PicStorm Topic: <em><?php echo $theme->getTitle();?></em></h2>
<p class="subtitle"><?php echo $theme->getDescription();?></p>

<h3>New Photos</h3>
<div class="photoGroup">
	<?php foreach($newestPhotos as $photo):?>
	  <a href="<?php echo url_for(sprintf("photo/index?id=%d", $photo->getId())); ?>" class="photo">
	    <img src="/uploads/thumbnail/<?php echo $photo->getTitle();?>" />
	  </a>
	<?php endforeach; ?>
</div>

<h3>Popular Photos</h3>
<div class="photoGroup">
	<?php foreach($popularPhotos as $photo):?>
	  <a href="<?php echo url_for(sprintf("photo/index?id=%d", $photo->getId())); ?>" class="photo">
	    <img src="/uploads/thumbnail/<?php echo $photo->getTitle();?>" />
	  </a>
	<?php endforeach; ?>
</div>

<h3>Random Photos</h3>
<div class="photoGroup">
	<?php foreach($randomPhotos as $photo):?>
	  <a href="<?php echo url_for(sprintf("photo/index?id=%d", $photo->getId())); ?>" class="photo">
	    <img src="/uploads/thumbnail/<?php echo $photo->getTitle();?>" />
	  </a>
	<?php endforeach; ?>
</div>