<?php
// Include Database Connection
require_once '../../dB/config.php';

// Fetch Inventory Data
$sqlInventory = "SELECT flowerID, flower_name, price, quantity FROM flowers;";
$resultInventory = $conn->query($sqlInventory);

$inventory = [];
if ($resultInventory) {
    while ($row = $resultInventory->fetch_assoc()) {
        $inventory[] = $row;
    }
}


// Close Connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Admin Dashboard - Flower Shop</title>
  <link href="/assets/css/admin.css" rel="stylesheet">
</head>
<body>
  <header class="navbar navbar-dark bg-primary px-3">
    <a class="navbar-brand" href="#">Admin Dashboard</a>
    <a href="logout.php" class="btn btn-light">Logout</a>
  </header>
  
  <main class="container py-4">
    <h2 class="text-center">Welcome, Admin!</h2>
    
    <!-- Inventory Section -->
<div class="col-md-6">
    <h3>Manage Inventory</h3>
    <button class="btn btn-success mb-3" onclick="addFlower()">Add New Flower</button>
    <ul class="list-group" id="inventory-list">
        <?php if (!empty($inventory)): ?>
            <?php foreach ($inventory as $item): ?>
                <li class="list-group-item d-flex justify-content-between">
                    <?php echo "₱" . number_format($item['price'], 2) . " - " . htmlspecialchars($item['flower_name']) . " - Stock: " . (int)$item['quantity']; ?>
                    <div>
                        <button class="btn btn-warning btn-sm" onclick="increaseStock(<?php echo (int)$item['flowerID']; ?>, <?php echo (int)$item['quantity']; ?>)">Add Stock</button>
                        <button class="btn btn-danger btn-sm" onclick="removeItem(<?php echo (int)$item['flowerID']; ?>, <?php echo (int)$item['quantity']; ?>)">Remove</button>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="list-group-item">No flowers in inventory</li>
        <?php endif; ?>
    </ul>
</div>

      </div>
    </div>
  </main>

  <script>
    function addFlower() {
    const flowerName = prompt("Enter flower name:");
    if (!flowerName) return;

    const price = parseFloat(prompt("Enter price of the flower:"));
    if (isNaN(price) || price <= 0) {
        alert("Please enter a valid price.");
        return;
    }

    const quantity = parseInt(prompt("Enter quantity:"));
    if (isNaN(quantity) || quantity < 0) {
        alert("Please enter a valid quantity.");
        return;
    }

    fetch("/controller/addFlower.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ flower_name: flowerName, price, quantity })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.status === "success") location.reload(); // Refresh inventory
    })
    .catch(error => console.error("Error:", error));
}
function removeItem(flowerID, currentStock) {
    const quantityToRemove = parseInt(prompt(`Enter quantity to remove (Stock: ${currentStock}):`));

    if (isNaN(quantityToRemove) || quantityToRemove <= 0 || quantityToRemove > currentStock) {
        alert("Invalid quantity. Please enter a number between 1 and " + currentStock);
        return;
    }

    fetch("/controller/removeFlower.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ flowerID, quantity: quantityToRemove })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.status === "success") location.reload();
    })
    .catch(error => console.error("Error:", error));
}
function increaseStock(flowerID, currentStock) {
    const quantityToAdd = parseInt(prompt(`Enter quantity to add (Current Stock: ${currentStock}):`));

    if (isNaN(quantityToAdd) || quantityToAdd <= 0) {
        alert("Invalid quantity. Please enter a number greater than 0.");
        return;
    }

    fetch("/controller/increaseStock.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ flowerID, quantity: quantityToAdd })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.status === "success") location.reload();
    })
    .catch(error => console.error("Error:", error));
}


  </script>
</body>
</html>
