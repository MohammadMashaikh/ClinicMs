<div class="row">
  <div class="col-xl-3 col-lg-4 col-sm-6">
    <div class="icon-card mb-30">
      <div class="icon primary"><i class="lni lni-book"></i></div>
      <div class="content">
        <h6 class="mb-10">My Courses</h6>
        <h3 class="text-bold mb-10">{{ $my_courses }}</h3>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-4 col-sm-6">
    <div class="icon-card mb-30">
      <div class="icon success"><i class="lni lni-users"></i></div>
      <div class="content">
        <h6 class="mb-10">Students Enrolled</h6>
        <h3 class="text-bold mb-10">{{ $students_enrolled }}</h3>
      </div>
    </div>
  </div>
</div>

<div class="card-style mb-30">
  <h6 class="mb-3">Recent Submissions</h6>
  <ul class="list-group">
    @foreach($recent_submissions as $submission)
      <li class="list-group-item">
        {{ $submission->user->full_name }} submitted 
        <strong>{{ $submission->assignment->title }}</strong>
      </li>
    @endforeach
  </ul>
</div>
