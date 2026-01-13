<!DOCTYPE html>
<html   lang="en" dir="ltr" >

<head>
	<!-- Required meta tags -->
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<!-- Favicon icon-->
<link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
  rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">
<!-- Core Css -->
<link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />
	<title>ClinicMS Login Page</title>
</head>

<body class="DEFAULT_THEME ">
	<main>
				<!-- Main Content -->
                <div class="flex flex-col w-full overflow-hidden relative min-h-screen radial-gradient items-center justify-center g-0 px-4">
                  
                    <div class="justify-center items-center w-full card lg:flex max-w-md ">
                        <div class=" w-full card-body">
                                <a href="{{ route('login') }}" class="py-4 block"><img src="{{ asset('assets/images/logos/ClinicMS_Purple.svg') }}" alt=""/></a>
                                <p class="mb-4 text-gray-400 text-sm text-center">Your Mental Campaigns</p>

                                @if ($errors->any())
                                  <div class="" style="background-color: #9B8FFA; padding: 6px; margin: 8px auto; text-align: center;">
                                      <ul class="mb-0">
                                      @foreach ($errors->all() as $error)
                                          <li>{{ $error }}</li>
                                      @endforeach
                                      </ul>
                                  </div>
                              @endif


                            <!-- form -->
                            <form action="{{ route('login') }}" method="POST">
                              @csrf
                                <!-- email -->
                                <div class="mb-4">
                                    <label for="email"
                                    class="block text-sm mb-2 text-gray-400">Email</label>
                                <input type="email" id="email" name="email"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0" aria-describedby="hs-input-helper-text">
                                </div>
                                <!-- password -->
                                <div class="mb-6">
                                    <label for="password"
                                    class="block text-sm  mb-2 text-gray-400">Password</label>
                                <input type="password" id="password" name="password"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 " aria-describedby="hs-input-helper-text">
                                </div>
                                <!-- checkbox -->
                                  <div class="flex justify-between">
                                    <div class="flex">
                                        <input type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded-[4px] text-blue-600 focus:ring-blue-500 " id="hs-default-checkbox" checked>
                                        <label for="hs-default-checkbox" class="text-sm text-gray-500 ms-3">Remeber this Device</label>
                                      </div>
                                        <a href="../" class="text-sm font-semibold text-blue-600 hover:text-blue-700" style="color: #9B8FFA">Forgot Password ?</a>
                                  </div>
                                    <!-- button -->
                                      <div class="grid my-6">
                                        <button type="submit" class="btn py-[10px] text-base text-white font-medium hover:bg-blue-700" style="background-color: #9B8FFA">Sign In</button>
                                      </div>
                                </div>
                            </form>
                        </div>
                    </div>
				
			</div>
		<!--end of project-->
	</main>


	
<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/iconify-icon/dist/iconify-icon.min.js') }}"></script>
<script src="{{ asset('assets/libs/@preline/dropdown/index.js') }}"></script>
<script src="{{ asset('assets/libs/@preline/overlay/index.js') }}"></script>
<script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>

<!-- solar icons -->
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
<script src="{{ asset('assets/libs/preline/dist/preline.js') }}"></script>

</body>

</html>