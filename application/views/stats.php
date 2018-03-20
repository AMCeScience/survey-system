

<table>
  <thead>
    <th>User ID</th>
    <th>Email address</th>
    <th>Completion</th>
    <th>Number of answers</th>
  </thead>

  <tbody>
    <?php foreach ($users as $user) { ?>
      <tr>
        <td><?php echo $user->user_id; ?></td>
        <td><?php echo $user->metadata->emailaddress; ?></td>
        <td><?php echo round($user->completion * 100, 0); ?></td>
        <td><?php echo $user->number_of_answers; ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>