// Initialize Firebase
const firebaseConfig = {
  apiKey: "AIzaSyA0YRgZSh9RL1AN19DRXVFFayUuEwAUgfI",
  authDomain: "gamestore-220f3.firebaseapp.com",
  projectId: "gamestore-220f3",
  storageBucket: "gamestore-220f3.firebasestorage.app",
  messagingSenderId: "623697954306",
  appId: "1:623697954306:web:25954c14bc49bf34bdc91b"
};

firebase.initializeApp(firebaseConfig);

firebase.auth().onAuthStateChanged((user) => {
  const authButton = document.getElementById('authButton');
  if (user) {
    // Store user_id in localStorage
    localStorage.setItem('user_id', user.uid);

    authButton.innerHTML = `<a href='profile.html' class='hover:text-yellow-300'><i class='fas fa-user'></i> Profile</a>`;
  } else {
    // Clear user_id from localStorage
    localStorage.removeItem('user_id');

    authButton.innerHTML = `<a href='login.html' class='hover:text-yellow-300'><i class='fas fa-user'></i> Login</a>`;
  }
});

function handleLogin(email, password) {
  firebase.auth().signInWithEmailAndPassword(email, password)
    .then(() => {
      window.location.href = 'profile.html';
    })
    .catch((error) => {
      alert('Login failed: ' + error.message);
    });
}

function addToCart(gameName, gamePrice, gameImage) {
  // Get the cart from localStorage or initialize it
  let cart = JSON.parse(localStorage.getItem('cart')) || [];

  // Add the new game to the cart
  const game = {
    name: gameName,
    price: gamePrice,
    image: gameImage,
    quantity: 1
  };

  // Check if the game already exists in the cart
  const existingGameIndex = cart.findIndex(item => item.name === gameName);
  if (existingGameIndex !== -1) {
    // Update the quantity of the existing game
    cart[existingGameIndex].quantity += 1;
  } else {
    // Add new game to the cart
    cart.push(game);
  }

  // Save the updated cart back to localStorage
  localStorage.setItem('cart', JSON.stringify(cart));

  // Alert the user
  alert(`${gameName} has been added to your cart.`);
}

// Function to handle checkout
function handleCheckout() {
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  const checkoutItemsContainer = document.getElementById('checkoutItems');
  const checkoutTotal = document.getElementById('checkoutTotal');

  // Clear existing items in the modal
  checkoutItemsContainer.innerHTML = '';

  // Calculate total and populate modal
  let total = 0;
  cart.forEach(item => {
    total += item.price * item.quantity;
    const itemElement = document.createElement('div');
    itemElement.className = 'flex justify-between items-center';
    itemElement.innerHTML = `
      <span>${item.name} (x${item.quantity})</span>
      <span>$${(item.price * item.quantity).toFixed(2)}</span>
    `;
    checkoutItemsContainer.appendChild(itemElement);
  });

  // Update total
  checkoutTotal.textContent = total.toFixed(2);

  // Show the modal
  document.getElementById('checkoutModal').classList.remove('hidden');
}

// Function to confirm purchase
function confirmPurchase() {
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  const userId = firebase.auth().currentUser ? firebase.auth().currentUser.uid : null;

  if (!userId) {
    alert('You must be logged in to complete the purchase.');
    return;
  }

  fetch('add_purchase.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      user_id: userId,
      cart: cart.map(item => ({
        game_id: item.id, // Ensure each game has a unique ID in your database
        quantity: item.quantity,
      })),
    }),
  })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        // Clear the cart
        localStorage.removeItem('cart');

        // Redirect to profile with a thank-you message
        alert('Thanks for your purchase!');
        window.location.href = 'profile.html';
      } else {
        alert('Purchase failed: ' + data.message);
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('An error occurred while processing your purchase.');
    });
}

// Function to load purchased games in profile
function loadPurchasedGames() {
  const purchasedGames = JSON.parse(localStorage.getItem('purchasedGames')) || [];
  const purchasedGamesContainer = document.getElementById('purchasedGames');

  // Clear existing items
  purchasedGamesContainer.innerHTML = '';

  // Add each purchased game
  purchasedGames.forEach(game => {
    const gameElement = document.createElement('div');
    gameElement.className = 'flex justify-between items-center bg-gray-800 p-4 rounded-lg';
    gameElement.innerHTML = `
      <span>${game.name}</span>
      <span>$${game.price.toFixed(2)}</span>
    `;
    purchasedGamesContainer.appendChild(gameElement);
  });
}

// Event listeners
if (document.getElementById('checkoutButton')) {
  document.getElementById('checkoutButton').addEventListener('click', handleCheckout);
}

if (document.getElementById('confirmPurchaseButton')) {
  document.getElementById('confirmPurchaseButton').addEventListener('click', confirmPurchase);
}

if (document.getElementById('purchasedGames')) {
  document.addEventListener('DOMContentLoaded', loadPurchasedGames);
}