// public/js/firebase-config.js
const firebaseConfig = {
  apiKey: "AIzaSyAt4qk6a7sZNCee7AT1NCG7KPSzjodj8KE",
  authDomain: "permatajatifurniture-pras.firebaseapp.com",
  projectId: "permatajatifurniture-pras",
  storageBucket: "permatajatifurniture-pras.firebasestorage.app",
  messagingSenderId: "655538583549",
  appId: "1:655538583549:web:e6124e9e12863ff23b8b94",
  measurementId: "G-1SX60CDLY6",
};

// Prevent reinitialization
if (!firebase.apps.length) {
  firebase.initializeApp(firebaseConfig);

  // Enable Google Auth Provider
  firebase.auth().useDeviceLanguage();

  console.log("Firebase initialized successfully");
} else {
  console.log("Firebase already initialized");
}

// Export for debugging
window.firebaseApp = firebase;
