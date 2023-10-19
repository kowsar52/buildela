
importScripts('https://www.gstatic.com/firebasejs/9.14.0/firebase-app-compat.js')
importScripts('https://www.gstatic.com/firebasejs/9.14.0/firebase-messaging-compat.js')

const firebaseConfig ={
    apiKey: "AIzaSyDuQap5naiFqC5cZhXnE7Lc3__Ocs9ii5c",
    authDomain: "buildela-16a22.firebaseapp.com",
    projectId: "buildela-16a22",
    storageBucket: "buildela-16a22.appspot.com",
    messagingSenderId: "26239317888",
    appId: "1:26239317888:web:b23fc9e04db2c62af1b365",
    measurementId: "G-SCB20XRVHG"
};

const app = firebase.initializeApp(firebaseConfig)
const messaging = firebase.messaging()