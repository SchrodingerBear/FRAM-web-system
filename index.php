<?php
require 'DATABASE/function.php'; // Include the function.php file
session_start(); // Start session to store user data


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $db = new DBFunctions();
  $user = $db->select('users', '*', ['email' => $email]);

  if (!empty($user)) {
    // Check if the password matches
    if ($password === $user[0]['password']) {
      $_SESSION['user_id'] = $user[0]['id'];
      $_SESSION['name'] = $user[0]['first_name'];
      $_SESSION['role'] = $user[0]['role'];

      if ($_SESSION['role'] == 'professor') {
        header('Location: attendance.php'); // Redirect to professor dashboard
        exit();
      } else {
        header('Location: dashboard.php'); // Redirect to user dashboard
        exit();
      }
    } else {
      echo "<script>alert('Invalid password. Please try again.');</script>";
    }
  } else {
    echo "<script>alert('No account found with that email.');</script>";
  }
}
?>

<?php require_once "DATABASE/db.php" ?>

<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->

<head>
  <title>
    FRAM WEB-SYSTEM
  </title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta property="og:locale" content="en_US" />
  <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
  <!--begin::Fonts(mandatory for all pages)-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
  <!--end::Fonts-->
  <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
  <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
  <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
  <!--end::Global Stylesheets Bundle-->
  <script>
    // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
  </script>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="app-blank">
  <!--begin::Theme mode setup on page load-->
  <script>
    var defaultThemeMode = "light";
    var themeMode;
    if (document.documentElement) {
      if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
        themeMode =
          document.documentElement.getAttribute("data-bs-theme-mode");
      } else {
        if (localStorage.getItem("data-bs-theme") !== null) {
          themeMode = localStorage.getItem("data-bs-theme");
        } else {
          themeMode = defaultThemeMode;
        }
      }
      if (themeMode === "system") {
        themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches
          ? "dark"
          : "light";
      }
      document.documentElement.setAttribute("data-bs-theme", themeMode);
    }
  </script>
  <!--end::Theme mode setup on page load-->
  <!--begin::Root-->
  <div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
      <!--begin::Body-->
      <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
        <!--begin::Form-->
        <div class="d-flex flex-center flex-column flex-lg-row-fluid">
          <!--begin::Wrapper-->
          <div class="w-lg-500px p-10">
            <!--begin::Form-->
            <form class="form w-100" method="post" action="index.php">
              <!--begin::Heading-->
              <div class="text-center mb-11">
                <!--begin::Title-->
                <h1 class="text-gray-900 fw-bolder mb-3">Sign In</h1>
                <!--end::Title-->

              </div>
              <!--begin::Heading-->
              <!--begin::Input group=-->
              <div class="fv-row mb-8">
                <!--begin::Email-->
                <input type="text" placeholder="Email" name="email" autocomplete="off"
                  class="form-control bg-transparent" required />
                <!--end::Email-->
              </div>
              <!--end::Input group=-->
              <div class="fv-row mb-3">
                <!--begin::Password-->
                <input type="password" placeholder="Password" name="password" autocomplete="off"
                  class="form-control bg-transparent" required />
                <!--end::Password-->
              </div>
              <!--end::Input group=-->
              <!--begin::Wrapper-->
              <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                <div></div>
                <!--begin::Link-->
                <!-- <a href="authentication/layouts/corporate/reset-password.html" class="link-primary">Forgot Password
                  ?</a> -->
                <!--end::Link-->
              </div>
              <!--end::Wrapper-->
              <!--begin::Submit button-->
              <div class="d-grid mb-10">
                <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                  <!--begin::Indicator label-->
                  <span class="indicator-label">Sign In</span>
                  <!--end::Indicator label-->
                  <!--begin::Indicator progress-->
                  <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                  <!--end::Indicator progress-->
                </button>
              </div>
              <!--end::Submit button-->
              <!--begin::Sign up-->
              <!-- <div class="text-gray-500 text-center fw-semibold fs-6">
                Not a Member yet?
                <a href="authentication/layouts/corporate/sign-up.html" class="link-primary">Sign up</a>
              </div> -->
              <!--end::Sign up-->
            </form>
            <!--end::Form-->
          </div>
          <!--end::Wrapper-->
        </div>
        <!--end::Form-->

      </div>
      <!--end::Body-->
      <!--begin::Aside-->
      <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
        style="background-image: url(assets/media/misc/auth-bg.png)">
        <!--begin::Content-->
        <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
          <!--begin::Logo-->
          <!-- <a href="index.html" class="mb-0 mb-lg-12">
            <img alt="Logo" src="assets/media/logos/custom-1.png" class="h-60px h-lg-75px" />
          </a> -->
          <!--end::Logo-->
          <!--begin::Image-->
          <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20"
            src="assets/media/misc/auth-screens.png" alt="" />
          <!--end::Image-->
          <!--begin::Title-->
          <!-- <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">
            Fast, Efficient and Productive
          </h1> -->
          <!--end::Title-->
          <!--begin::Text-->
          <!-- <div class="d-none d-lg-block text-white fs-base text-center">
            In this kind of post,
            <a href="#" class="opacity-75-hover text-warning fw-bold me-1">the blogger</a>introduces a person they’ve
            interviewed <br />and provides some
            background information about
            <a href="#" class="opacity-75-hover text-warning fw-bold me-1">the interviewee</a>and their <br />work
            following this is a transcript of the
            interview.
          </div> -->
          <!--end::Text-->
        </div>
        <!--end::Content-->
      </div>
      <!--end::Aside-->
    </div>
    <!--end::Authentication - Sign-in-->
  </div>
  <!--end::Root-->
  <!--begin::Javascript-->
  <script>
    var hostUrl = "assets/";
  </script>
  <!--begin::Global Javascript Bundle(mandatory for all pages)-->
  <script src="assets/plugins/global/plugins.bundle.js"></script>
  <script src="assets/js/scripts.bundle.js"></script>
  <!--end::Global Javascript Bundle-->
  <!--begin::Custom Javascript(used for this page only)-->
  <script src="assets/js/custom/authentication/sign-in/general.js"></script>
  <!--end::Custom Javascript-->
  <!--end::Javascript-->
</body>
<!--end::Body-->

</html>