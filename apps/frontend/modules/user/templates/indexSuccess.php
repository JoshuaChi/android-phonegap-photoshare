<h1>Users List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Name</th>
      <th>Email</th>
      <th>Password</th>
      <th>Is admin</th>
      <th>Login count</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($Users as $User): ?>
    <tr>
      <td><a href="<?php echo url_for('user/edit?id='.$User->getId()) ?>"><?php echo $User->getId() ?></a></td>
      <td><?php echo $User->getName() ?></td>
      <td><?php echo $User->getEmail() ?></td>
      <td><?php echo $User->getPassword() ?></td>
      <td><?php echo $User->getIsAdmin() ?></td>
      <td><?php echo $User->getLoginCount() ?></td>
      <td><?php echo $User->getCreatedAt() ?></td>
      <td><?php echo $User->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('user/new') ?>">New</a>
