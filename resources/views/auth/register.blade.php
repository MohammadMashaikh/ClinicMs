 
 <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon" />
    <title>Sign Up</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/lineicons.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/fullcalendar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/fullcalendar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />

    
  </head>

  <body>

 <!-- ========== signup-section start ========== -->
      <section class="signin-section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30">
            <!-- end row -->
          </div>
          <!-- ========== title-wrapper end ========== -->

          <div class="row g-0 auth-row">
            <div class="col-lg-6">
              <div class="auth-cover-wrapper bg-primary-100">
                <div class="auth-cover">
                  <div class="title text-center">
                    <h1 class="text-primary mb-10">Get Started</h1>
                    <p class="text-medium">
                      We offer thousands of available Courses
                      <br class="d-sm-block" />
                      with all fields.
                    </p>
                  </div>
                  <div class="cover-image">
                    <img src="{{ asset('assets/images/auth/signin-image.svg') }}" alt="" />
                  </div>
                  <div class="shape-image">
                    <img src="{{ asset('assets/images/auth/shape.svg') }}" alt="" />
                  </div>
                </div>
              </div>
            </div>
            <!-- end col -->
            <div class="col-lg-6">
              <div class="signup-wrapper">
                <div class="form-wrapper">
                  <h6 class="mb-15">Sign Up Form</h6>
                  <p class="text-sm mb-25">
                    Start creating the best possible user experience for you
                    customers.
                  </p>
                     @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            </ul>
                        </div>
                        @endif
                  <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="row">
                      <div class="col-12">
                        <div class="input-style-1">
                          <label for="first_name">First Name</label>
                          <input type="text" name="first_name" id="first_name" placeholder="First Name" value="{{ old('first_name') }}"/>
                        </div>
                        <x-input-error :messages="$errors->get('first_name')" class="mt-2 text-sm text-danger" />
                      </div>

                      <div class="col-12">
                        <div class="input-style-1">
                          <label for="last_name">Last Name</label>
                          <input type="text" name="last_name" id="last_name" placeholder="Last Name" value="{{ old('last_name') }}"/>
                        </div>
                        <x-input-error :messages="$errors->get('last_name')" class="mt-2 text-sm text-danger" />
                      </div>

                      <!-- end col -->
                      <div class="col-12">
                        <div class="input-style-1">
                          <label for="email">Email</label>
                          <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}"/>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-danger" />
                      </div>
                      <!-- end col -->
                      <div class="col-12">
                        <div class="input-style-1">
                          <label for="password">Password</label>
                          <input type="password" name="password" id="password" placeholder="Password" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-danger" />
                      </div>

                       <div class="col-12">
                        <div class="input-style-1">
                          <label for="password">Confirm Password</label>
                          <input type="password" name="password_confirmation" id="password" placeholder="Confirm Password" />
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-danger" />
                      </div>

                      <div class="col-12">
                        <div class="input-style-1">
                          <label for="phone">Phone</label>
                          <input type="text" name="phone" id="phone" placeholder="Phone" value="{{ old('phone') }}"/>
                        </div>
                        <x-input-error :messages="$errors->get('phone')" class="mt-2 text-sm text-danger" />
                      </div>

                      <div class="col-lg-12">
                          <div class="select-style-1">
                              <label>Gender</label>
                              <div class="select-position">
                                  <select name="gender">
                                      <option value="">Select Gender</option>
                                      <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                      <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                  </select>
                              </div>
                              <x-input-error :messages="$errors->get('gender')" class="mt-2 text-sm text-danger" />
                          </div>
                      </div>
                      <!-- end col -->
                      <div class="col-12 mb-5">
                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                      </div>
                      <!-- end col -->
                      <div class="col-12">
                        <div class="button-group d-flex justify-content-center flex-wrap">
                          <button class="main-btn primary-btn btn-hover w-100 text-center">
                            Sign Up
                          </button>
                        </div>
                      </div>
                    </div>
                    <!-- end row -->
                  </form>
                  <div class="singup-option pt-40">
                    <p class="text-sm text-medium text-center text-gray">
                      Easy Sign Up With
                    </p>
                     <div class="button-group pt-40 pb-40 d-flex justify-content-center flex-wrap">

                      <a href="{{ route('auth.github') }}" class="text-decoration-none main-btn dark-btn-outline m-2">
                            <i class="lni lni-github-original mr-10"></i>
                            Github
                        </a>
                        
                        <a href="{{ route('auth.google') }}" class="text-decoration-none main-btn danger-btn-outline m-2">
                            <i class="lni lni-google mr-10"></i>
                            Google
                        </a>
                     
                    </div>
                    <p class="text-sm text-medium text-dark text-center">
                      Already have an account? <a href="{{ route('login') }}">Sign In</a>
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <!-- end col -->
          </div>
          <!-- end row -->
        </div>
      </section>
      <!-- ========== signup-section end ========== -->

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

        </body>
    </html>
