var sendToast = (msg) => {
  const div = document.createElement("div");
  div.classList.add("snackbar");

  div.id = "emailToast";
  div.innerHTML = msg;
  document.body.appendChild(div);
  var x = document.getElementById("emailToast");
  x.className = "show";
  setTimeout(function () {
    x.className = x.className.replace("show", "");
    document.body.removeChild(div);
  }, 3000);
};

// firebase.auth().onAuthStateChanged(function (user) {
//   console.log(user);
//   // firebase.auth().currentUser.reload();
//   if (user) {
//     var user = firebase.auth().currentUser;
//     if (user != null && user.emailVerified == true) {
//       createSessionAndSignIn(user.email);
//     } else {
//       sendToast("Email is not verified please verify email");
//     }
//   }
//   // window.user = user; // user is undefined if no user signed in
// });

const signin = (e) => {
  e.preventDefault();
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;
  firebase
    .auth()
    .signInWithEmailAndPassword(email, password)
    .then(() => {
      var user = firebase.auth().currentUser;
      if (user != null && user.emailVerified == true) {
        console.log("signed in");
        updateStatus(email);
      } else {
        sendToast("Email is not verified please verify email");
      }
    })
    .catch(function (err) {
      // Handle errors
      sendToast(err.message);
    });
};

var updateStatus = (email) => {
  var data = new FormData();
  data.append("email", email);

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "main.php", true);
  xhr.onload = function () {
    // do something to response
    console.log(this.responseText);
    if (this.responseText == "true") {
      createSessionAndSignIn(email);
    } else {
      sendToast("Something went wrong");
    }
  };
  xhr.send(data);
};

const createSessionAndSignIn = (email) => {
  var data = new FormData();
  data.append("createSessionAndSignIn", "createSessionAndSignIn");
  data.append("email_id", email);

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "main.php", true);
  xhr.onload = function () {
    // do something to response
    console.log(this.responseText);
    if (this.responseText == "true") {
      console.log("signed in");
      sendToast("Sign in successful");
      setTimeout(function () {
        window.location.assign("/webproj/index.php");
      }, 3000);
    } else {
      sendToast("Something went wrong");
    }
  };
  xhr.send(data);
};
