<!doctype html>
<html lang="en">
  <head>
  	<title>Sistem Payroll - Warehouse DC Parung</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="{{ asset('assets/pages/login/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/pages/login/css/style-custom.css') }}">

	</head>
	<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">Warehouse DC Parung</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last">
							<div class="text w-100">
							</div>
			            </div>
						<div class="login-wrap p-4 p-lg-5">
        			      	<div class="d-flex">
        			      		<div class="w-100">
        			      			<h3 class="mb-4">Login</h3>
        			      		</div>
        						<div class="w-100">
        							<p class="social-media d-flex justify-content-end">
        								<img src="{{ asset('assets/images/logo-inverse.png') }}" style="max-width: 100px">
        							</p>
        						</div>
        			      	</div>
    						<form action="{{ route('login') }}" class="signin-form" method="POST">
                                @csrf
        			      		<div class="form-group mb-3">
        			      			<label class="label" for="email">E-mail</label>
        			      			<input type="text" name="email" class="form-control" placeholder="E-mail" required>
        			      		</div>
                                @error('email')
                                <div class="form-group mb-3">
                        	        <span for="email" style="color: var(--danger);">{{ $message }}</span>
                                </div>
                                @enderror
            		            <div class="form-group mb-3">
                        	        <label class="label" for="password">Password</label>
            	                    <input type="password" name="password" class="form-control" placeholder="Password" required>
            		            </div>
                                @error('password')
                                <div class="form-group mb-3">
                        	        <span for="password" style="color: var(--danger);">{{ $message }}</span>
                                </div>
                                @enderror
            		            <div class="form-group">
            		            	<button type="submit" class="form-control btn btn-primary submit px-3">Sign In</button>
            		            </div>
            		            <div class="form-group d-md-flex">
            		            	<div class="w-50 text-left">
            			            	<label class="checkbox-wrap checkbox-primary mb-0">Remember Me
            								<input type="checkbox" name="remember_me" checked>
            								<span class="checkmark"></span>
            							</label>
            						</div>
            		            </div>
    		                </form>
		                </div>
		            </div>
				</div>
			</div>
		</div>
	</section>

  <script src="{{ asset('assets/pages/login/js/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/pages/login/js/popper.js') }}"></script>
  <script src="{{ asset('assets/pages/login/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/pages/login/js/main.js') }}"></script>

	</body>
</html>
