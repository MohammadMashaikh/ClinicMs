
<aside id="application-sidebar-brand"
				class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full transform hidden xl:block xl:translate-x-0 xl:end-auto xl:bottom-0 fixed xl:top-[90px] xl:left-auto top-0 left-0 with-vertical h-screen z-[999] shrink-0 w-[270px] shadow-md xl:rounded-md rounded-none bg-white left-sidebar transition-all duration-300" >
				<!-- ---------------------------------- -->
<!-- Start Vertical Layout Sidebar -->
<!-- ---------------------------------- -->
<div class="p-4">
  
  <a href="{{ route('dashboard') }}" class="text-nowrap">
    <img
      src="{{ asset('assets/images/logos/ClinicMS.svg') }}"
      alt="ClinicMS"
    />
  </a>
</div>


<div class="scroll-sidebar" data-simplebar="">
  <nav class=" w-full flex flex-col sidebar-nav px-4 mt-5">
    <ul id="sidebarnav" class="text-gray-600 text-sm">
      <li class="text-xs font-bold pb-[5px]">
        <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
        <span class="text-xs text-gray-400 font-semibold">HOME</span>
      </li>

      <li class="sidebar-item">
        <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md text-gray-500 w-full"
          href="{{ route('dashboard') }}">
          <i class="ti ti-layout-dashboard ps-2  text-2xl"></i> <span>Dashboard</span>
        </a>
      </li>

      <li class="text-xs font-bold mb-4 mt-6">
        <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
        <span class="text-xs text-gray-400 font-semibold">Main</span>
      </li>

      <li class="sidebar-item">
        <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md text-gray-500 w-full"
          href="{{ route('doctor.list') }}">
          <i class="fa fa-user-doctor ps-2 text-2xl"></i> <span>Doctors</span>
        </a>
      </li>

      @can('view patients')
      <li class="sidebar-item">
        <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md text-gray-500 w-full"
          href="{{ route('patient.list') }}">
          <i class="fa fa-hospital-user ps-2 text-2xl"></i> <span>Patients</span>
        </a>
      </li>
      @endcan

      <li class="sidebar-item">
        <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md text-gray-500 w-full"
          href="{{ route('appointment.list') }}">
          <i class="fa fa-calendar-check ps-2 text-2xl"></i> <span>Appointments</span>
        </a>
      </li>

      <li class="sidebar-item">
        <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md text-gray-500 w-full"
          href="{{ route('prescription.list') }}">
          <i class="fa fa-capsules ps-2 text-2xl"></i> <span>Prescriptions</span>
        </a>
      </li>

      @can('view pharmacy')
      <li class="sidebar-item">
        <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md text-gray-500 w-full"
          href="{{ route('pharmacy.list') }}">
          <i class="fa-solid fa-prescription-bottle-medical"></i> <span>Pharmacy</span>
        </a>
      </li>
      @endcan

      @can('view roles')
      <li class="sidebar-item">
        <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md text-gray-500 w-full"
          href="{{ route('role.list') }}">
          <i class="fa-solid fa-hand-sparkles"></i> <span>Roles & Permissions</span>
        </a>
      </li>
      @endcan
      
     
    </ul>
  </nav>
</div>

<!-- </aside> -->
</aside>