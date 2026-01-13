		<!--  Header Start -->
	<header class=" bg-white shadow-md rounded-md w-full text-sm py-4 px-6">
					

<!-- ========== HEADER ========== -->

    <nav class=" w-ful flex items-center justify-between" aria-label="Global">
            <ul class="icon-nav flex items-center gap-4">
                <li class="relative xl:hidden">
                    <a class="text-xl  icon-hover cursor-pointer text-heading"
                        id="headerCollapse" data-hs-overlay="#application-sidebar-brand"
                        aria-controls="application-sidebar-brand" aria-label="Toggle navigation" href="javascript:void(0)">
                        <i class="ti ti-menu-2 relative z-1"></i>
                    </a>
                </li>
           
            <li class="relative">
                
    <div class="hs-dropdown relative inline-flex [--placement:bottom-left] sm:[--trigger:hover]">
        <a class="relative hs-dropdown-toggle inline-flex hover:text-gray-500 text-gray-300" href="#">
            <i class="ti ti-bell-ringing text-xl relative z-[1]"></i>
            <div
                class="absolute inline-flex items-center justify-center  text-white text-[11px] font-medium  bg-blue-600 w-2 h-2 rounded-full -top-[1px] -right-[6px]">
            </div>
        </a>
        <div class="card hs-dropdown-menu transition-[opacity,margin] rounded-md duration hs-dropdown-open:opacity-100 opacity-0 mt-2 min-w-max  w-[300px] hidden z-[12]"
            aria-labelledby="hs-dropdown-custom-icon-trigger">
            <div>
               <h3 class="text-gray-500 font-semibold text-base px-6 py-3">Notification</h3>
               <ul class="list-none  flex flex-col">
                <li>
               <a href="#" class="py-3 px-6 block hover:bg-gray-200">
                <p class="text-sm text-gray-500 font-medium">Roman Joined the Team!</p>
                <p class="text-xs text-gray-400 font-medium">Congratulate him</p>
               </a>
                </li>
                <li>
                <a href="#" class="py-3 px-6 block hover:bg-gray-200">
                    <p class="text-sm text-gray-500 font-medium">New message received</p>
                    <p class="text-xs text-gray-400 font-medium">Salma sent you new message</p>
                </a>
                </li>
                <li>
                  <a href="#" class="py-3 px-6 block hover:bg-gray-200">
                    <p class="text-sm text-gray-500 font-medium">New Payment received</p>
                    <p class="text-xs text-gray-400 font-medium">Check your earnings</p>
                  </a>
                </li>
                <li>
                 <a href="#" class="py-3 px-6 block hover:bg-gray-200">
                    <p class="text-sm text-gray-500 font-medium">Jolly completed tasks</p>
                    <p class="text-xs text-gray-400 font-medium">Assign her new tasks</p>
                 </a>
                </li>
                <li>
                  <a href="#" class="py-3 px-6 block hover:bg-gray-200">
                    <p class="text-sm text-gray-500 font-medium">Roman Joined the Team!</p>
                    <p class="text-xs text-gray-400 font-medium">Congratulate him</p>
                  </a>
                </li>
               </ul>
            </div>
        </div>
    </div>

          </li>
     </ul>


     <style>
      .user-info {
        background: linear-gradient(135deg, #2563eb, #9333ea); /* blue → purple */
        color: #fff !important;
        padding: 1rem 1.5rem;
        border-radius: 1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        display: inline-block;
        text-align: center;
        min-width: 220px;
      }

      .user-name {
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0;
      }

      .user-role {
        font-size: 0.9rem;
        opacity: 0.9;
        margin-top: 4px;
      }

     </style>

        <div class="flex items-center gap-4">
          <x-page-action-button :link="$pageActionLink">
			    	{!! $pageActionText ?? '' !!}
		     </x-page-action-button>

        <div class="user-info p-3 rounded-lg inline-block">
            <p class="text-gray-800 font-semibold">
               <span class="user-name">{{ auth()->user()->full_name ?? 'N/A' }}</span>
                <span class="user-role">| {{ ucfirst(auth()->user()->getRoleNames()->first()) ?? 'No Role' }}</span>
            </p>
       </div>



         @php
            $user = auth()->user();
            $image = '';
            if ($user->hasRole('patient'))
            {
              $image = $user->getFirstMediaUrl('patient-image');
            } else if ($user->hasRole('doctor'))
            {
              $image = $user->getFirstMediaUrl('doctor-image');
            } else if ($user->hasRole('super-admin'))
            {
              $image = $user->getFirstMediaUrl('super-admin-image');
            } else {
              $image = asset('assets/images/profile/user-1.jpg');
            }
         @endphp
     <div class="hs-dropdown relative inline-flex [--placement:bottom-right] sm:[--trigger:hover]">
				<a class="relative hs-dropdown-toggle cursor-pointer align-middle rounded-full">
					<img class="object-cover w-9 h-9 rounded-full" src="{{ $image }}" alt=""
						aria-hidden="true">
				</a>

				<div class="card hs-dropdown-menu transition-[opacity,margin] rounded-md duration hs-dropdown-open:opacity-100 opacity-0 mt-2 min-w-max  w-[200px] hidden z-[12]"
					aria-labelledby="hs-dropdown-custom-icon-trigger">
					<div class="card-body p-0 py-2">
						<a href="javscript:void(0)" class="flex gap-2 items-center font-medium px-4 py-1.5 hover:bg-gray-200 text-gray-400">
							<i class="ti ti-user text-xl "></i>
							<p class="text-sm ">My Profile</p>
						</a>
						<a href="javscript:void(0)" class="flex gap-2 items-center font-medium px-4 py-1.5 hover:bg-gray-200 text-gray-400">
							<i class="ti ti-mail  text-xl"></i>
							<p class="text-sm ">My Account</p>
						</a>
						<a href="javscript:void(0)" class="flex gap-2 items-center font-medium px-4 py-1.5 hover:bg-gray-200 text-gray-400">
							<i class="ti ti-list-check  text-xl "></i>
							<p class="text-sm ">My Task</p>
						</a>
						<div class="px-4 mt-[7px] grid">
              <form action="{{ route('logout') }}" method="POST">
                @csrf
							<button class="btn-outline-primary font-medium text-[15px] w-full hover:bg-blue-600 hover:text-white">Logout</button>
              </form>

						</div>

					</div>
				</div>
			</div>

</div>
    </nav>

  <!-- ========== END HEADER ========== -->
				</header>
				<!--  Header End -->