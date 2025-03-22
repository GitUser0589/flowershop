<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Admin Dashboard - Flower Shop</title>
  <link href="assets/css/admin.css" rel="stylesheet">
</head>
<body>
  <header class="navbar navbar-dark bg-primary px-3">
    <a class="navbar-brand" href="#">Admin Dashboard</a>
    <a href="logout.php" class="btn btn-light">Logout</a>
  </header>
  
  <main class="container py-4">
    <h2 class="text-center">Welcome, Admin!</h2>
    
    <div class="row">
      <!-- Orders Section -->
      <div class="col-md-6">
        <h3>Recent Orders</h3>
        <ul class="list-group" id="orders-list">
          <li class="list-group-item">No recent orders</li>
        </ul>
      </div>
      
      <!-- Inventory Section -->
      <div class="col-md-6">
        <h3>Manage Inventory</h3>
        <button class="btn btn-success mb-3" onclick="addFlower()">Add New Flower</button>
        <ul class="list-group" id="inventory-list">
          <li class="list-group-item">No flowers in inventory</li>
        </ul>
      </div>
    </div>
  </main>
  
  <script>
    const orders = [
      { id: 1, customer: "John Doe", item: "Roses", quantity: 5 },
      { id: 2, customer: "Jane Smith", item: "Lilies", quantity: 3 }
    ];
    const inventory = [
      { id: 1, name: "Roses", stock: 20 },
      { id: 2, name: "Lilies", stock: 15 }
    ];
    
    function displayOrders() {
      const ordersList = document.getElementById("orders-list");
      ordersList.innerHTML = "";
      orders.forEach(order => {
        ordersList.innerHTML += `<li class="list-group-item">${order.customer} ordered ${order.quantity} ${order.item}</li>`;
      });
      if (orders.length === 0) ordersList.innerHTML = "<li class='list-group-item'>No recent orders</li>";
    }
    
    function displayInventory() {
      const inventoryList = document.getElementById("inventory-list");
      inventoryList.innerHTML = "";
      inventory.forEach(item => {
        inventoryList.innerHTML += `<li class="list-group-item d-flex justify-content-between">${item.name} - Stock: ${item.stock} <button class="btn btn-danger btn-sm" onclick="removeItem(${item.id})">Remove</button></li>`;
      });
      if (inventory.length === 0) inventoryList.innerHTML = "<li class='list-group-item'>No flowers in inventory</li>";
    }
    
    function addFlower() {
      const flowerName = prompt("Enter flower name:");
      if (flowerName) {
        inventory.push({ id: inventory.length + 1, name: flowerName, stock: 10 });
        displayInventory();
      }
    }
    
    function removeItem(id) {
      const index = inventory.findIndex(item => item.id === id);
      if (index !== -1) {
        inventory.splice(index, 1);
        displayInventory();
      }
    }
    
    displayOrders();
    displayInventory();
  </script>
</body>
</html>
