
<!DOCTYPE HTML>
<html lang="en">

<!-- Mirrored from www.enableds.com/products/sticky30/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 05 May 2020 06:53:57 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
<title>StickyMobile BootStrap</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>/assets/styles/style.css">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i|Source+Sans+Pro:300,300i,400,400i,600,600i,700,700i,900,900i&amp;display=swap" rel="stylesheet">

<link rel="manifest" href="_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
<link rel="apple-touch-icon" sizes="180x180" href="app/icons/icon-192x192.png">
<script src="https://www.gstatic.com/firebasejs/6.3.3/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/6.3.3/firebase-auth.js"></script>

</head>
<div class="page-content header-clear-medium">
<div class="card card-style">
<div class="content mt-4 mb-0">
<h1 class="text-center font-900 font-40 text-uppercase mb-0">Login</h1>
<p class="bottom-0 text-center color-highlight font-11">Let's get you logged in</p>

<div class="input-style has-icon input-style-1 input-required pb-1">
<i class="input-icon fa fa-user color-theme"></i>
<span>Mobile number</span>
<em>(required)</em>
<input type="tel" id="phoneNumber" name="number" placeholder="Enter Mobile number">
</div>
<div id="otp-div" class="input-style has-icon input-style-1 input-required pb-1" style="display: none;">
<i class="input-icon fa fa-lock color-theme"></i>
<span>OTP</span>
<em>(required)</em>
<input type="text" name="password" id="code" placeholder="Enter OTP">
</div>

<button type="submit" id="hidebutton"  onclick="googleSignin()" class="btn btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s bg-green1-dark">Get otp</button>

<button type="submit" id="submitOtp"  onclick="submitPhoneNumberAuthCode()" class="btn btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s bg-green1-dark" style="display: none">Confirm</button>
</div>
</div>

<div id="menu-warning-1" class="menu menu-box-modal rounded-m" data-menu-height="300" data-menu-width="310">
<h1 class="text-center mt-4"><i class="fa fa-3x fa-times color-red2-dark"></i></h1>
<h1 class="text-center mt-3 text-uppercase font-900">Wooops!</h1>
<p class="boxed-text-l">
Check your username and password.<br> Try again.
</p>
<a href="<?php echo base_url();?>user/login" class="close-menu btn btn-m btn-center-m button-s shadow-l rounded-s text-uppercase font-900 bg-red1-light">Go Back</a>
</div>
<div id="menu-warning-2" class="menu menu-box-modal bg-red2-dark rounded-m" data-menu-height="300" data-menu-width="310">
<h1 class="text-center mt-4"><i class="fa fa-3x fa-times-circle color-white shadow-xl rounded-circle"></i></h1>
<h1 class="text-center mt-3 text-uppercase color-white font-900">Wooops!</h1>
<p class="boxed-text-l color-white opacity-70">
You can continue with your previous actions.<br> Easy to attach these to success calls.
</p>
<a href="#" class="close-menu btn btn-m btn-center-m button-s shadow-l rounded-s text-uppercase font-900 bg-white">Go Back</a>
</div>
  <div id="recaptcha-container"></div>


    <script>
      // Paste the config your copied earlier
     const firebaseConfig = {
  apiKey: "AIzaSyBEAzaw4UdtN-110RFcEiD1IGWTIAD0Wgs",
  authDomain: "nearme-bd535.firebaseapp.com",
  databaseURL: "https://nearme-bd535.firebaseio.com",
  projectId: "nearme-bd535",
  storageBucket: "nearme-bd535.appspot.com",
  messagingSenderId: "807407970976",
  appId: "1:807407970976:web:b540e6dc5a1b66d75b77c5",
  measurementId: "G-Q3TYF4R8P6"
};

      firebase.initializeApp(firebaseConfig);


      function googleSignin() {
      	base_proveider =new firebase.auth.GoogleAuthProvider()
      	firebase.auth().signInWithRedirect(base_proveider).then(function(result){
      		console.log(result)
      		console.log("success google account linked")
      	}).catch(function(err){
      		console.log(err)
      		console.log('fialed to do')

      	})
      }
      // Create a Recaptcha verifier instance globally
      // Calls submitPhoneNumberAuth() when the captcha is verified
      window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier(
        "recaptcha-container",
        {
          size: "normal",
          callback: function(response) {
            submitPhoneNumberAuth();
          }
        }
      );

      // This function runs when the 'sign-in-button' is clicked
      // Takes the value from the 'phoneNumber' input and sends SMS to that phone number
      function submitPhoneNumberAuth() {
		var divId = document.getElementById("otp-div");
		var getOtpbutton = document.getElementById("hidebutton");
		var confirmButton = document.getElementById("submitOtp");


        var phoneNumber = document.getElementById("phoneNumber").value;
        var appVerifier = window.recaptchaVerifier;
            divId.style.display = "block";
            getOtpbutton.style.display = "none";
            confirmButton.style.display = "block";


        firebase
          .auth()
          .signInWithPhoneNumber(phoneNumber, appVerifier)
          .then(function(confirmationResult) {
            window.confirmationResult = confirmationResult;
          })
          .catch(function(error) {
            console.log(error);
          });
      }

      // This function runs when the 'confirm-code' button is clicked
      // Takes the value from the 'code' input and submits the code to verify the phone number
      // Return a user object if the authentication was successful, and auth is complete
      function submitPhoneNumberAuthCode() {
        var code = document.getElementById("code").value;

        confirmationResult
          .confirm(code)
          .then(function(result) {
            var user = result.user;
            console.log(user);
          })
          .catch(function(error) {
            console.log(error);
          });
      }

      //This function runs everytime the auth state changes. Use to verify if the user is logged in
      firebase.auth().onAuthStateChanged(function(user) {
        if (user) {
          console.log("USER LOGGED IN");
        } else {
          // No user is signed in.
          console.log("USER NOT LOGGED IN");
        }
      });
    </script>



<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/custom.js"></script>
</body>
<?php if($this->uri->segment(2) == 'login'){ ?>
	<script type="text/javascript">
       <?php echo $this->session->flashdata('login_failed'); ?>
<?php if($this->input->get('auth') == 'failed'){ ?>
    $(window).on('load',function(){
     $('#menu-warning-1').showMenu();
     });

</script>
<?php } ?>
<?php } ?>

  