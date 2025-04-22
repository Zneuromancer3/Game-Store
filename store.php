<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Game Store - Store</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
  <style>
      .navbar {
      background: rgba(0, 0, 0, 0.8);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid #444;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
    }

    .navbar a {
      color: #f0f0f0;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: color 0.3s;
    }

    .navbar a:hover {
      color: #ffd700;
    }

    .navbar h1 i {
      color: #ffd700;
    }
  </style>
</head>
<body class="bg-black text-white">

  <header class="navbar fixed w-full p-4 z-20 bg-dark-800 text-white">
    <div class="container mx-auto flex justify-between items-center">
      <!-- Logo -->
      <h1 class="text-3xl font-bold">
        <i class="fas fa-gamepad"></i> Game Store
      </h1>
      <!-- Hamburger Button -->
      <button 
        class="lg:hidden text-2xl focus:outline-none" 
        id="menu-toggle"
        aria-label="Toggle menu">
        <i class="fas fa-bars"></i>
      </button>
      <!-- Navigation Links -->
      <nav class="hidden lg:flex">
        <ul class="flex space-x-6">
          <li><a href="index.html" class="hover:text-yellow-300"><i class="fas fa-home"></i> Home</a></li>
          <li><a href="store.php" class="hover:text-yellow-300"><i class="fas fa-store"></i> Store</a></li>
          <li><a href="cart.html" class="hover:text-yellow-300"><i class="fas fa-shopping-cart"></i> Cart</a></li>
          <li><a href="about.html" class="hover:text-yellow-300"><i class="fas fa-info-circle"></i> About</a></li>
          <li><a href="contact.html" class="hover:text-yellow-300"><i class="fas fa-envelope"></i> Contact</a></li>
          <li id="authButton"></li>
        </ul>
      </nav>
      <!-- Mobile Menu -->
      <nav id="mobile-menu" class="absolute top-full left-0 w-full bg-gray-900 hidden lg:hidden">
        <ul class="flex flex-col items-center space-y-4 py-4">
          <li><a href="index.html" class="hover:text-yellow-300"><i class="fas fa-home"></i> Home</a></li>
          <li><a href="store.php" class="hover:text-yellow-300"><i class="fas fa-store"></i> Store</a></li>
          <li><a href="cart.html" class="hover:text-yellow-300"><i class="fas fa-shopping-cart"></i> Cart</a></li>
          <li><a href="about.html" class="hover:text-yellow-300"><i class="fas fa-info-circle"></i> About</a></li>
          <li><a href="contact.html" class="hover:text-yellow-300"><i class="fas fa-envelope"></i> Contact</a></li>
        </ul>
      </nav>
    </div>
  </header>

 <!-- Game Cards Section -->
 <section class="py-12 bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900">
  <div class="container mx-auto text-center">
    <h2 class="text-4xl font-extrabold text-yellow-400 mt-7 mb-10">
      <i class="fas fa-gamepad"></i> Available Games
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 justify-center">
      
      <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "game_store";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM games";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="bg-gray-800 p-6 rounded-2xl border border-yellow-400 shadow-lg hover:shadow-2xl transition transform hover:scale-105 relative overflow-hidden group">';
        echo '<div class="relative">';
        echo '<img src="' . $row['image_url'] . '" alt="' . $row['name'] . '" class="rounded-2xl w-full h-40 object-cover transition duration-300 transform group-hover:scale-110">';
        echo '</div>';
        echo '<div class="mt-4">';
        echo '<h3 class="text-2xl font-bold text-yellow-400 mb-2">' . $row['name'] . '</h3>';
        echo '<p class="text-gray-300 mb-4">' . $row['description'] . '</p>';
        echo '</div>';
        echo '<div class="flex justify-between items-center">';
        echo '<p class="text-xl font-extrabold text-blue-400">$' . number_format($row['price'], 2) . '</p>';
        echo '<button onclick="addToCart(' . $row['id'] . ', \'' . addslashes($row['name']) . '\', ' . number_format($row['price'], 2, '.', '') . ')" class="flex items-center bg-yellow-400 text-black px-4 py-2 rounded-full font-medium transition transform hover:bg-yellow-500 hover:scale-110">';
        echo '<i class="fas fa-cart-plus mr-2"></i> Add to Cart';
        echo '</button>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<p class="text-gray-400">No games available at the moment.</p>';
}

$conn->close();
?>
    </div>
  </div>
</section>


 <!-- Footer -->
 <footer class="py-8 bg-gray-900 text-center">
  <div class="container mx-auto">
    <p class="text-gray-400 mb-4">&copy; 2025 Game Store. All rights reserved.</p>
    <div class="flex justify-center space-x-6 mb-4">
      <a href="#" class="text-gray-400 hover:text-yellow-500 transition duration-300">
        <i class="fab fa-twitter fa-2x"></i>
      </a>
      <a href="#" class="text-gray-400 hover:text-yellow-500 transition duration-300">
        <i class="fab fa-instagram fa-2x"></i>
      </a>
      <a href="#" class="text-gray-400 hover:text-yellow-500 transition duration-300">
        <i class="fab fa-facebook fa-2x"></i>
      </a>
    </div>
    <div class="text-gray-500 text-sm">
      <p>Follow us on social media for the latest updates and offers!</p>
    </div>
  </div>
</footer>
  <!-- FontAwesome Icons (Deferred) -->
  <script defer src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <script>
    const menuToggle = document.getElementById("menu-toggle");
    const mobileMenu = document.getElementById("mobile-menu");
  
    menuToggle.addEventListener("click", () => {
      mobileMenu.classList.toggle("hidden");
    });

    function addToCart(gameId, gameName, gamePrice) {
      const currentUser = localStorage.getItem('currentUser');

      if (!currentUser) {
        alert('You need to log in to add items to the cart.');
        return;
      }

      const userData = JSON.parse(currentUser);
      const userId = userData.id;

      // Retrieve the cart from localStorage or initialize it
      let cart = JSON.parse(localStorage.getItem(`cart_${userId}`)) || {};

      // Add the game to the cart or update its quantity
      if (cart[gameId]) {
        cart[gameId].quantity += 1;
      } else {
        cart[gameId] = { gameId: gameId, gameName: gameName, price: parseFloat(gamePrice), quantity: 1 };
      }

      // Save the updated cart back to localStorage
      localStorage.setItem(`cart_${userId}`, JSON.stringify(cart));

      alert(`${gameName} added to cart successfully!`);
    }

    // SQL-based authentication logic
    function checkAuth() {
      const authButton = document.getElementById('authButton');
      const currentUser = localStorage.getItem('currentUser');

      if (currentUser) {
        const userData = JSON.parse(currentUser);
        authButton.innerHTML = `
          <a href="profile.html" class="hover:text-yellow-300">
            <i class="fas fa-user"></i> ${userData.username}
          </a>
          <a href="#" onclick="logout()" class="hover:text-yellow-300">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        `;
      } else {
        authButton.innerHTML = `
          <a href="login.php" class="hover:text-yellow-300">
            <i class="fas fa-user"></i> Login
          </a>
        `;
      }
    }

    function logout() {
      localStorage.removeItem('currentUser');
      checkAuth();
    }

    checkAuth();
  </script>
  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const currentUser = localStorage.getItem('currentUser');
    const authButton = document.getElementById('authButton');

    if (currentUser) {
      const userData = JSON.parse(currentUser);
      authButton.innerHTML = `
        <a href="profile.html" class="hover:text-yellow-300">
          <i class="fas fa-user"></i> ${userData.username}
        </a>
        <a href="#" onclick="logout()" class="hover:text-yellow-300">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      `;
    } else {
      authButton.innerHTML = `
        <a href="login.html" class="hover:text-yellow-300">
          <i class="fas fa-user"></i> Login
        </a>
      `;
    }
  });

  function logout() {
    localStorage.removeItem('currentUser');
    location.reload();
  }
</script>
</body>
</html>
