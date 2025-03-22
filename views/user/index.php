
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Dashboard - Flower Shop</title>
  <link rel="stylesheet" href="assets/css/user.css">
</head>
<body>  
  <header class="navbar navbar-dark bg-primary px-3">
    <a class="navbar-brand" href="#">Flower Shop</a>
    <a href="logout.php" class="btn btn-light">Logout</a>
  </header>
  <main class="container py-4">
    <h2 class="text-center">Welcome, User!</h2>
    
    <div class="row">
      <!-- Flower Catalog -->
      <div class="col-md-8">
        <h3>Available Flowers</h3>
        <div class="row" id="flower-list">
          <!-- Flower items will be dynamically added here -->
        </div>
      </div>
      
      <!-- Cart Summary -->
      <div class="col-md-4">
        <h3>Cart</h3>
        <ul id="cart-list" class="list-group">
          <li class="list-group-item">Your cart is empty</li>
        </ul>
        <button class="btn btn-success w-100 mt-3" id="checkout">Checkout</button>
      </div>
    </div>
  </main>
  
  <script>
    const flowers = [
      { id: 1, name: "Roses", price: 10 },
      { id: 2, name: "Lilies", price: 12 },
      { id: 3, name: "Tulips", price: 8 }
    ];
    const cart = [];
    
    function displayFlowers() {
      const flowerList = document.getElementById("flower-list");
      flowerList.innerHTML = "";
      flowers.forEach(flower => {
        flowerList.innerHTML += `
          <div class="col-md-4">
            <div class="card p-3">
              <h5>${flower.name}</h5>
              <p>$${flower.price}</p>
              <button class="btn btn-primary" onclick="addToCart(${flower.id})">Add to Cart</button>
            </div>
          </div>`;
      });
    }
    
    function addToCart(id) {
      const flower = flowers.find(f => f.id === id);
      cart.push(flower);
      updateCart();
    }
    
    function updateCart() {
      const cartList = document.getElementById("cart-list");
      cartList.innerHTML = "";
      cart.forEach((item, index) => {
        cartList.innerHTML += `<li class="list-group-item d-flex justify-content-between">${item.name} - $${item.price} <button class="btn btn-danger btn-sm" onclick="removeFromCart(${index})">X</button></li>`;
      });
      if (cart.length === 0) cartList.innerHTML = "<li class='list-group-item'>Your cart is empty</li>";
    }
    
    function removeFromCart(index) {
      cart.splice(index, 1);
      updateCart();
    }
    
    document.getElementById("checkout").addEventListener("click", function() {
      alert("Order placed successfully!");
      cart.length = 0;
      updateCart();
    });
    
    displayFlowers();
  </script>
</body>
</html>

