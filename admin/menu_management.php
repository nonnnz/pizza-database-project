<?php

// Include the database connection file
require_once "../components/connect.php";

// array
$menu_items = array();

// Query the database for the menu items
$stmt = $pdo->query("SELECT f.fd_id, f.fd_des, f.fd_image, p.pz_name, p.pz_des, p.pz_price, c.cat_name, s.size_name, s.size_price, cr.crust_name, cr.crust_price, d.dip_name, d.dip_price, sa.sauce_name 
                     FROM food f 
                     INNER JOIN pizza p ON f.pz_id = p.pz_id 
                     INNER JOIN category c ON p.cat_id = c.cat_id 
                     INNER JOIN size s ON p.size_id = s.size_id 
                     INNER JOIN crust cr ON p.crust_id = cr.crust_id 
                     INNER JOIN dipping_sauce d ON p.dip_id = d.dip_id 
                     INNER JOIN sauce sa ON p.sauce_id = sa.sauce_id");

$stmt->execute();

// Fetch the query results and build an array of menu items
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $menu_item = array(
        'fd_id' => $row['fd_id'],
        'fd_des' => $row['fd_des'],
        'fd_image' => $row['fd_image'],
        'pz_name' => $row['pz_name'],
        'pz_des' => $row['pz_des'],
        'pz_price' => $row['pz_price'],
        'cat_name' => $row['cat_name'],
        'size_name' => $row['size_name'],
        'size_price' => $row['size_price'],
        'crust_name' => $row['crust_name'],
        'crust_price' => $row['crust_price'],
        'dip_name' => $row['dip_name'],
        'dip_price' => $row['dip_price'],
        'sauce_name' => $row['sauce_name']
    );

    array_push($menu_items, $menu_item);
}
// Display the menu items in a table
// echo "<table>";
// echo "<tr><th>Food ID</th><th>Food Description</th><th>Pizza Name</th><th>Pizza Description</th><th>Pizza Price</th><th>Category</th><th>Size</th><th>Size Price</th><th>Crust</th><th>Crust Price</th><th>Dipping Sauce</th><th>Dipping Sauce Price</th><th>Sauce</th></tr>";
// while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//     echo "<tr>";
//     echo "<td>" . $row['fd_id'] . "</td>";
//     echo "<td>" . $row['fd_des'] . "</td>";
//     echo "<td>" . $row['pz_name'] . "</td>";
//     echo "<td>" . $row['pz_des'] . "</td>";
//     echo "<td>" . $row['pz_price'] . "</td>";
//     echo "<td>" . $row['cat_name'] . "</td>";
//     echo "<td>" . $row['size_name'] . "</td>";
//     echo "<td>" . $row['size_price'] . "</td>";
//     echo "<td>" . $row['crust_name'] . "</td>";
//     echo "<td>" . $row['crust_price'] . "</td>";
//     echo "<td>" . $row['dip_name'] . "</td>";
//     echo "<td>" . $row['dip_price'] . "</td>";
//     echo "<td>" . $row['sauce_name'] . "</td>";
//     echo "</tr>";
// }
// echo "</table>";
?>

<!DOCTYPE html>
<html>
<head>
  <title>Menu Management</title>
</head>
<body>

<?php require_once '../components/admin_header.php'; ?>

  <h1>Menu Management</h1>
  <form>
    <label for="category_id">Filter by Category:</label>
    <select name="category_id">
      <option value="">All Categories</option>
      <?php foreach($menu_items as $item): ?>
        <option value=""><?php echo $item['cat_name']; ?></option>
      <?php endforeach; ?>
    </select>
    <button type="submit">Filter</button>
  </form>
  <table>
    <thead>
      <tr>
        <th>Food Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Category</th>
        <th>Size</th>
        <th>Crust</th>
        <th>Dipping Sauce</th>
        <th>Sauce</th>
        <th>Food Image</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($menu_items as $item): ?>
        <tr>
          <td><?php echo $item['pz_name']; ?></td>
          <td><?php echo $item['pz_des']; ?></td>
          <td><?php echo $item['pz_price']; ?></td>
          <td><?php echo $item['cat_name']; ?></td>
          <td><?php echo $item['size_name']; ?></td>
          <td><?php echo $item['crust_name']; ?></td>
          <td><?php echo $item['dip_name']; ?></td>
          <td><?php echo $item['sauce_name']; ?></td>
          <td><img src="<?php echo $item['fd_image']; ?>" alt="<?php echo $item['pz_name']; ?>" width="100px"></td>
          <td><a href="edit_menu_item.php?id=<?php echo $item['fd_id']; ?>">Edit</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>

