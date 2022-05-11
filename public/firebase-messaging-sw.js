importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

firebase.initializeApp({
    apiKey: "AIzaSyAXrl1eBvdqM_avj82TsWzaQJ8mI_QLzw0",
    projectId: "ican-project",
    messagingSenderId: "896448062962",
    appId: "1:896448062962:web:bcd407314eaf6d1441776b",
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
    return self.registration.showNotification(title,{body,icon});
});
