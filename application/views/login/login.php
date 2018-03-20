<div class="container">
  <link rel="stylesheet" href="/css/login.css"/>

  <script src="/js/login.js"></script>

  <form class="form-signin" onsubmit="asyncLogin(); return false;">
    <h2 class="form-signin-heading">Please sign in</h2>
    <div class="alert alert-info" role="alert">You'll find the sign-in info in your invitation e-mail</div>
    
    <label for="inputEmail" class="sr-only">Email address</label>
    <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="" autocomplete="off">
    
    <label for="inputPassword" class="sr-only">Password</label>
    <input name="hash" type="text" id="inputPassword" class="form-control" placeholder="Password" required="" autocomplete="off">

    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
  </form>
</div>