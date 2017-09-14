<!DOCTYPE html>
<html ng-app="app">
<head>
  <base href="/">
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
  <title>Role Based Authentication</title>
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
  <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script type="text/javascript" src='https://code.jquery.com/jquery-3.1.1.min.js'></script>
  <style type="text/css">
  html,
  body {
    background: #efefef;
    padding: 10px;
    font-family: 'Varela Round';
  }
  /*=== 2. Anchor Link ===*/
  a {
    color: #aaaaaa;
    transition: all ease-in-out 200ms;
  }
  a:hover {
    color: #333333;
    text-decoration: none;
  }
  /*=== 3. Text Outside the Box ===*/
  .etc-login-form {
    color: #919191;
    padding: 10px 20px;
  }
  .etc-login-form p {
    margin-bottom: 5px;
  }
  /*=== 4. Main Form ===*/
  .login-form-1 {
    max-width: 300px;
    border-radius: 5px;
    display: inline-block;
  }
  .main-login-form {
    position: relative;
  }
  .login-form-1 .form-control {
    border: 0;
    box-shadow: 0 0 0;
    border-radius: 0;
    background: transparent;
    color: #555555;
    padding: 7px 0;
    font-weight: bold;
    height:auto;
  }
  .login-form-1 .form-control::-webkit-input-placeholder {
    color: #999999;
  }
  .login-form-1 .form-control:-moz-placeholder,
  .login-form-1 .form-control::-moz-placeholder,
  .login-form-1 .form-control:-ms-input-placeholder {
    color: #999999;
  }
  .login-form-1 .form-group {
    margin-bottom: 0;
    border-bottom: 2px solid #efefef;
    padding-right: 20px;
    position: relative;
  }
  .login-form-1 .form-group:last-child {
    border-bottom: 0;
  }
  .login-group {
    background: #ffffff;
    color: #999999;
    border-radius: 8px;
    padding: 10px 20px;
  }
  .login-group-checkbox {
    padding: 5px 0;
  }
  /*=== 5. Login Button ===*/
  .login-form-1 .login-button {
    position: absolute;
    right: -25px;
    top: 50%;
    background: #ffffff;
    color: #999999;
    padding: 11px 0;
    width: 50px;
    height: 50px;
    margin-top: -25px;
    border: 5px solid #efefef;
    border-radius: 50%;
    transition: all ease-in-out 500ms;
  }
  .login-form-1 .login-button:hover {
    color: #555555;
    transform: rotate(450deg);
  }
  .login-form-1 .login-button.clicked {
    color: #555555;
  }
  .login-form-1 .login-button.clicked:hover {
    transform: none;
  }
  .login-form-1 .login-button.clicked.success {
    color: #2ecc71;
  }
  .login-form-1 .login-button.clicked.error {
    color: #e74c3c;
  }
  /*=== 6. Form Invalid ===*/
  label.form-invalid {
    position: absolute;
    top: 0;
    right: 0;
    z-index: 5;
    display: block;
    margin-top: -25px;
    padding: 7px 9px;
    background: #777777;
    color: #ffffff;
    border-radius: 5px;
    font-weight: bold;
    font-size: 11px;
  }
  label.form-invalid:after {
    top: 100%;
    right: 10px;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
    border-color: transparent;
    border-top-color: #777777;
    border-width: 6px;
  }
  /*=== 7. Form - Main Message ===*/
  .login-form-main-message {
    background: #ffffff;
    color: #999999;
    border-left: 3px solid transparent;
    border-radius: 3px;
    margin-bottom: 8px;
    font-weight: bold;
    height: 0;
    padding: 0 20px 0 17px;
    opacity: 0;
    transition: all ease-in-out 200ms;
  }
  .login-form-main-message.show {
    height: auto;
    opacity: 1;
    padding: 10px 20px 10px 17px;
  }
  .login-form-main-message.success {
    border-left-color: #2ecc71;
  }
  .login-form-main-message.error {
    border-left-color: #e74c3c;
  }
  /*=== 8. Custom Checkbox & Radio ===*/
  /* Base for label styling */
  [type="checkbox"]:not(:checked),
  [type="checkbox"]:checked,
  [type="radio"]:not(:checked),
  [type="radio"]:checked {
    position: absolute;
    left: -9999px;
  }
  [type="checkbox"]:not(:checked) + label,
  [type="checkbox"]:checked + label,
  [type="radio"]:not(:checked) + label,
  [type="radio"]:checked + label {
    position: relative;
    padding-left: 25px;
    padding-top: 1px;
    cursor: pointer;
  }
  /* checkbox aspect */
  [type="checkbox"]:not(:checked) + label:before,
  [type="checkbox"]:checked + label:before,
  [type="radio"]:not(:checked) + label:before,
  [type="radio"]:checked + label:before {
    content: '';
    position: absolute;
    left: 0;
    top: 2px;
    width: 17px;
    height: 17px;
    border: 0px solid #aaa;
    background: #f0f0f0;
    border-radius: 3px;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3);
  }
  /* checked mark aspect */
  [type="checkbox"]:not(:checked) + label:after,
  [type="checkbox"]:checked + label:after,
  [type="radio"]:not(:checked) + label:after,
  [type="radio"]:checked + label:after {
    position: absolute;
    color: #555555;
    transition: all .2s;
  }
  /* checked mark aspect changes */
  [type="checkbox"]:not(:checked) + label:after,
  [type="radio"]:not(:checked) + label:after {
    opacity: 0;
    transform: scale(0);
  }
  [type="checkbox"]:checked + label:after,
  [type="radio"]:checked + label:after {
    opacity: 1;
    transform: scale(1);
  }
  /* disabled checkbox */
  [type="checkbox"]:disabled:not(:checked) + label:before,
  [type="checkbox"]:disabled:checked + label:before,
  [type="radio"]:disabled:not(:checked) + label:before,
  [type="radio"]:disabled:checked + label:before {
    box-shadow: none;
    border-color: #8c8c8c;
    background-color: #878787;
  }
  [type="checkbox"]:disabled:checked + label:after,
  [type="radio"]:disabled:checked + label:after {
    color: #555555;
  }
  [type="checkbox"]:disabled + label,
  [type="radio"]:disabled + label {
    color: #8c8c8c;
  }
  /* accessibility */
  [type="checkbox"]:checked:focus + label:before,
  [type="checkbox"]:not(:checked):focus + label:before,
  [type="checkbox"]:checked:focus + label:before,
  [type="checkbox"]:not(:checked):focus + label:before {
    border: 1px dotted #f6f6f6;
  }
  /* hover style just for information */
  label:hover:before {
    border: 1px solid #f6f6f6 !important;
  }
  /*=== Customization ===*/
  /* radio aspect */
  [type="checkbox"]:not(:checked) + label:before,
  [type="checkbox"]:checked + label:before {
    border-radius: 3px;
  }
  [type="radio"]:not(:checked) + label:before,
  [type="radio"]:checked + label:before {
    border-radius: 35px;
  }
  /* selected mark aspect */
  [type="checkbox"]:not(:checked) + label:after,
  [type="checkbox"]:checked + label:after {
    content: '✔';
    top: 0;
    left: 2px;
    font-size: 14px;
  }
  [type="radio"]:not(:checked) + label:after,
  [type="radio"]:checked + label:after {
    content: '\2022';
    top: 0;
    left: 3px;
    font-size: 30px;
    line-height: 25px;
  }
  /*=== 9. Misc ===*/
  .logo {
    padding: 15px 0;
    font-size: 25px;
    color: #aaaaaa;
    font-weight: bold;
  }
  .register-form {
    margin-left:150px;
  }
</style>

</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12" ui-view="mainView" autoscroll="false">
        
      </div>
    </div>
  </div>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.4/angular.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-sanitize/1.6.4/angular-sanitize.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/1.0.3/angular-ui-router.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/ngStorage/0.3.11/ngStorage.min.js"></script>
  <script src="js/angular-jwt.min.js"></script>
  <script type="text/javascript" src="/app/app.js"></script>
  <script type="text/javascript" src="/app/controllers.js"></script>
  <script type="text/javascript" src="/app/directives.js"></script>
  <script type="text/javascript" src="/app/services.js"></script>
</body>
</html>