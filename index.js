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
    authButton.innerHTML = `<a href='profile.html' class='hover:text-yellow-300'><i class='fas fa-user'></i> Profile</a>`;
  } else {
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