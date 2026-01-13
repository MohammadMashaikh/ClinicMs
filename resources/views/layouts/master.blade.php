<!DOCTYPE html>
<html lang="en" >

<head>
	<!-- Required meta tags -->
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
<!-- Favicon icon-->
<link rel="shortcut icon" type="image/png" href="{{ asset('/assets/images/logos/favicon.png') }}" />
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
  rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Core Css -->
<link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />
<title>ClinicMS</title>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@livewireStyles

	<style>
/* Fix alignment of Select2 tags and remove button */
.select2-container .select2-selection--multiple {
    min-height: 48px !important;
    border: 1px solid #e5e7eb !important; /* Tailwind gray-200 */
    border-radius: 0.5rem !important; /* rounded-lg */
    padding: 6px !important;
    display: flex !important;
    align-items: center !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #2563eb !important; /* blue-600 */
    border: none !important;
    color: white !important;
    padding: 4px 10px !important;
    margin-top: 5px !important;
    margin-right: 5px !important;
    border-radius: 0.375rem !important; /* rounded-md */
    font-size: 0.875rem !important; /* text-sm */
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: white !important;
    margin-right: 5px !important;
    font-weight: bold;
    position: relative !important;
    top: 0 !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__rendered {
    display: flex !important;
    flex-wrap: wrap !important;
    align-items: center !important;
}
</style>


@yield('custom-css')

</head>

<body class=" bg-surface">
	<main>
		
        @include('layouts.navbar')

		<!--start the project-->
		<div id="main-wrapper" class="flex p-5 xl:pr-0">

      @include('layouts.sidebar')

			<div class="w-full page-wrapper xl:px-6 px-0">

				
	<!-- Main Content -->
	<main class="h-full  max-w-full">
		<div class="container full-container p-0 flex flex-col gap-6">

			@include('layouts.header', [
				'PageActionText' => $pageActionText ?? null,
				'pageActionLink' => $pageActionLink ?? null
			])


			@include('layouts.alert-message')
            @include('layouts.confirmation')

          @yield('content')
			
			</div>
		</div>
		<!--end of project-->
	</main>

	@livewireScripts

	
	
<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/iconify-icon/dist/iconify-icon.min.js') }}"></script>
<script src="{{ asset('assets/libs/@preline/dropdown/index.js') }}"></script>
<script src="{{ asset('assets/libs/@preline/overlay/index.js') }}"></script>
<script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>

<!-- solar icons -->
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
<script src="{{ asset('assets/libs/preline/dist/preline.js') }}"></script>

	<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>

	@yield('custom-js')
</body>

</html>