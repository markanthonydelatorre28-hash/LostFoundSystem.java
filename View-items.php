<?php
include 'db_connect.php';
$result = mysqli_query($conn, "SELECT * FROM items ORDER BY date_reported DESC");
?>
<h2>Lost and Found Items</h2>
<table border="1">
<tr><th>Item</th><th>Status</th><th>Location</th><th>Date</th></tr>
<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
  <td><?= $row['item_name'] ?></td>
  <td><?= $row['status'] ?></td>
  <td><?= $row['location'] ?></td>
  <td><?= $row['date_reported'] ?></td>
</tr>
<?php } ?>
</table>
