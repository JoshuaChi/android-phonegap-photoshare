<h1>PhotoComments List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>User</th>
      <th>Photo</th>
      <th>Description</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($PhotoComments as $PhotoComment): ?>
    <tr>
      <td><a href="<?php echo url_for('comment/edit?id='.$PhotoComment->getId().'&user_id='.$PhotoComment->getUserId().'&photo_id='.$PhotoComment->getPhotoId()) ?>"><?php echo $PhotoComment->getId() ?></a></td>
      <td><a href="<?php echo url_for('comment/edit?id='.$PhotoComment->getId().'&user_id='.$PhotoComment->getUserId().'&photo_id='.$PhotoComment->getPhotoId()) ?>"><?php echo $PhotoComment->getUserId() ?></a></td>
      <td><a href="<?php echo url_for('comment/edit?id='.$PhotoComment->getId().'&user_id='.$PhotoComment->getUserId().'&photo_id='.$PhotoComment->getPhotoId()) ?>"><?php echo $PhotoComment->getPhotoId() ?></a></td>
      <td><?php echo $PhotoComment->getDescription() ?></td>
      <td><?php echo $PhotoComment->getCreatedAt() ?></td>
      <td><?php echo $PhotoComment->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('comment/new') ?>">New</a>
