<div class="row">
  <div class="col-xl-3 col-lg-4 col-sm-6">
    <div class="icon-card mb-30">
      <div class="icon purple"><i class="lni lni-book"></i></div>
      <div class="content">
        <h6 class="mb-10">Enrolled Courses</h6>
        <h3 class="text-bold mb-10">{{ $enrolled_courses }}</h3>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-4 col-sm-6">
    <div class="icon-card mb-30">
      <div class="icon orange"><i class="lni lni-target"></i></div>
      <div class="content">
        <h6 class="mb-10">Assignments Due</h6>
        <h3 class="text-bold mb-10">{{ $pending_assignments }}</h3>
      </div>
    </div>
  </div>
</div>

<div class="card-style mb-30">
  <h6 class="mb-3">Upcoming Deadlines</h6>
  <ul class="list-group">
    @foreach($deadlines as $deadline)

      <li class="list-group-item">
        <strong>{{ $deadline->title }}</strong> 
        - Due {{ $deadline->due_date->format('d M, Y') }}
      </li>
    @endforeach
  </ul>
</div>
