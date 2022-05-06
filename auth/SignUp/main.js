const signupBtn = document.getElementById("signupBtn");

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
// setInterval(function () {
//     firebase.auth().onAuthStateChanged(function(user) {
//         console.log(user)
//         // firebase.auth().currentUser.reload();
//         if(user){
//              var user = firebase.auth().currentUser;
//              if(user != null && user.emailVerified == true) {
//                 sendToast("User created");
//              }
//         }
//         // window.user = user; // user is undefined if no user signed in
//        });
// },1000)

const signupFun = (e) => {
  e.preventDefault();
  const email = document.getElementById("email").value;
  const firstName = document.getElementById("firstName").value;
  const lastName = document.getElementById("lastName").value;
  const password = document.getElementById("password").value;
  const cpassword = document.getElementById("cpassword").value;

  if (password === cpassword) {
    firebase
      .auth()
      .createUserWithEmailAndPassword(email, password)
      .then(function () {
        firebase
          .auth()
          .currentUser.sendEmailVerification()
          .then(function () {
            sendToast("Verification link has been sent to your email");
            storeData(firstName, lastName, email, password);
          })
          .catch(function (err) {
            // Handle errors
            var errmsg = err.message;
            sendToast(errmsg);
          });
      })
      .catch(function (err) {
        // Handle errors
        var errmsg = err.message;
        sendToast(errmsg);
      });
  } else {
    sendToast("Password and confirm password do not match");
  }
};

const storeData = (firstName, lastName, email, password) => {
  var data = new FormData();
  data.append("fname", firstName);
  data.append("lname", lastName);
  data.append("email", email);
  data.append("password", password);
  data.append("verification_status", false);

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "main.php", true);
  xhr.onload = function () {
    // do something to response
    console.log(this.responseText);
    if (this.responseText == "true") {
      setTimeout(() => {
        window.location.assign("/webproj/auth/Login");
      }, 3000);
    } else {
      sendToast("Something went wrong");
    }
  };
  xhr.send(data);
};
