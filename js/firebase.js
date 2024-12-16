// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.11.1/firebase-app.js";
import { getAuth, createUserWithEmailAndPassword, signInWithEmailAndPassword, GoogleAuthProvider, FacebookAuthProvider, signInWithPopup } from "https://www.gstatic.com/firebasejs/10.11.1/firebase-auth.js";
import { getFirestore, setDoc, doc } from "https://www.gstatic.com/firebasejs/10.11.1/firebase-firestore.js";

const firebaseConfig = {
    apiKey: "AIzaSyAisl1ATsP-iXvzvO9wcqWE1LTHQLpcjOo",
    authDomain: "rentright-c4245.firebaseapp.com",
    projectId: "rentright-c4245",
    storageBucket: "rentright-c4245.appspot.com",
    messagingSenderId: "406623931729",
    appId: "1:406623931729:web:4ea58bd5f1e13e1068d770",
    measurementId: "G-4GGQXT9748"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

function showMessage(message, divId) {
    var messageDiv = document.getElementById(divId);
    messageDiv.style.display = "block";
    messageDiv.innerHTML = message;
    messageDiv.style.opacity = 1;
    setTimeout(function () {
        messageDiv.style.opacity = 0;
    }, 5000);
}

const auth = getAuth();
const db = getFirestore();

// Sign Up
const signUp = document.getElementById('submitSignUp');
signUp.addEventListener('click', (event) => {
    event.preventDefault();
    const email = document.getElementById('rEmail').value;
    const password = document.getElementById('rPassword').value;
    const firstName = document.getElementById('fName').value;
    const phoneNumber = document.getElementById('phone').value;

    createUserWithEmailAndPassword(auth, email, password)
        .then((userCredential) => {
            const user = userCredential.user;
            const userData = {
                email: email,
                firstName: firstName,
                phoneNumber: phoneNumber
            };
            showMessage('Account Created Successfully', 'signUpMessage');
            const docRef = doc(db, "users", user.uid);
            setDoc(docRef, userData)
                .then(() => {
                    window.location.href = 'login.html';
                })
                .catch((error) => {
                    console.error("error writing document", error);
                });
        })
        .catch((error) => {
            const errorCode = error.code;
            if (errorCode == 'auth/email-already-in-use') {
                showMessage('Email Address Already Exists !!!', 'signUpMessage');
            } else {
                showMessage('Unable to create User', 'signUpMessage');
            }
        });
});

// Sign In
const signIn = document.getElementById('submitSignIn');
signIn.addEventListener('click', (event) => {
    event.preventDefault();
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    signInWithEmailAndPassword(auth, email, password)
        .then((userCredential) => {
            showMessage('Login is successful', 'signInMessage');
            const user = userCredential.user;
            localStorage.setItem('loggedInUserId', user.uid);
            window.location.href = 'admin/index.php';
        })
        .catch((error) => {
            const errorCode = error.code;
            if (errorCode === 'auth/wrong-password') {
                showMessage('Incorrect Email or Password', 'signInMessage');
            } else if (errorCode === 'auth/user-not-found') {
                showMessage('Account does not exist', 'signInMessage');
            } else {
                showMessage('Unable to login', 'signInMessage');
            }
        });
});

// Google Sign In
const googleProvider = new GoogleAuthProvider();
const googleSignIn = document.getElementById('googleSignIn');
const googleSignUp = document.getElementById('googleSignUp');

googleSignUp.addEventListener('click', () => {
    signInWithPopup(auth, googleProvider)
        .then((result) => {
            const user = result.user;
            localStorage.setItem('loggedInUserId', user.uid);
            window.location.href = 'admin/index.php';
        })
        .catch((error) => {
            console.error("Error with Google Sign-Up", error);
            showMessage('Google Sign-Up Failed', 'signUpMessage');
        });
});



googleSignIn.addEventListener('click', () => {
    signInWithPopup(auth, googleProvider)
        .then((result) => {
            const user = result.user;
            localStorage.setItem('loggedInUserId', user.uid);
            window.location.href = 'admin/index.php';
        })
        .catch((error) => {
            console.error("Error with Google Sign-In", error);
            showMessage('Google Sign-In Failed', 'signInMessage');
        });
});


// Facebook Sign Un & In
const facebookProvider = new FacebookAuthProvider();
const facebookSignIn = document.getElementById('facebookSignIn');
const facebookSignUp = document.getElementById('facebookSignUp');


facebookSignUp.addEventListener('click', () => {
    signInWithPopup(auth, facebookProvider)
        .then((result) => {
            const user = result.user;
            localStorage.setItem('loggedInUserId', user.uid);
            window.location.href = 'admin/index.php';
        })
        .catch((error) => {
            console.error("Error with Facebook Sign-Ip", error);
            showMessage('Facebook Sign-Up Failed', 'signUpMessage');
        });
});




facebookSignIn.addEventListener('click', () => {
    signInWithPopup(auth, facebookProvider)
        .then((result) => {
            const user = result.user;
            localStorage.setItem('loggedInUserId', user.uid);
            window.location.href = 'admin/index.php';
        })
        .catch((error) => {
            console.error("Error with Facebook Sign-Up", error);
            showMessage('Facebook Sign-In Failed', 'signInMessage');
        });
});

