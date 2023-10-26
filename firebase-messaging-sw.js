// this file must be in root folder
importScripts('https://www.gstatic.com/firebasejs/9.14.0/firebase-app-compat.js')
importScripts('https://www.gstatic.com/firebasejs/9.14.0/firebase-messaging-compat.js')

const firebaseConfig = {
    apiKey: "AIzaSyDuQap5naiFqC5cZhXnE7Lc3__Ocs9ii5c",
    authDomain: "buildela-16a22.firebaseapp.com",
    projectId: "buildela-16a22",
    storageBucket: "buildela-16a22.appspot.com",
    messagingSenderId: "26239317888",
    appId: "1:26239317888:web:b23fc9e04db2c62af1b365",
    measurementId: "G-SCB20XRVHG"
};
console.log('firebaseConfig',firebaseConfig);
// receiving messages in background
const app = firebase.initializeApp(firebaseConfig)
const messaging = firebase.messaging()

// get this type of message in background
messaging.onBackgroundMessage(function (payload) {
    console.log('Received background message ', payload);
    if (!payload.hasOwnProperty('notification')) {
        const notificationTitle = payload.data.title
        const notificationOptions = {
            body: payload.data.body,
            icon: payload.data.icon,
            image: payload.data.image
        }
        self.registration.showNotification(notificationTitle, notificationOptions);
        self.addEventListener('notificationclick', function (event) {
            const clickedNotification = event.notification
            clickedNotification.close();
            event.waitUntil(
                clients.openWindow(payload.data.click_action)
            )
        })
    }
})