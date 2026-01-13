  <!-- ========== title-wrapper end ========== -->
          <div class="row">
            <div class="col-xl-3 col-lg-4 col-sm-6">
              <div class="icon-card mb-30">
                <div class="icon purple">
                  <i class="lni lni-cart-full"></i>
                </div>
                <div class="content">
                  <h6 class="mb-10">Total Courses</h6>
                  <h3 class="text-bold mb-10">{{ $total_courses }}</h3>
                  <p class="text-sm text-success">
                    <i class="lni lni-arrow-up"></i> +2.00%
                    <span class="text-gray">(30 days)</span>
                  </p>
                </div>
              </div>
              <!-- End Icon Cart -->
            </div>
            <!-- End Col -->
            <div class="col-xl-3 col-lg-4 col-sm-6">
              <div class="icon-card mb-30">
                <div class="icon success">
                  <i class="lni lni-dollar"></i>
                </div>
                <div class="content">
                  <h6 class="mb-10">Total Income</h6>
                  <h3 class="text-bold mb-10">${{ $total_income }}</h3>
                  <p class="text-sm text-success">
                    <i class="lni lni-arrow-up"></i> +5.45%
                    <span class="text-gray">Increased</span>
                  </p>
                </div>
              </div>
              <!-- End Icon Cart -->
            </div>
            <!-- End Col -->
            <div class="col-xl-3 col-lg-4 col-sm-6">
              <div class="icon-card mb-30">
                <div class="icon primary">
                  <i class="lni lni-user"></i>
                </div>
                <div class="content">
                  <h6 class="mb-10">Total Instructors</h6>
                  <h3 class="text-bold mb-10">{{ $total_instructors }}</h3>
                </div>
              </div>
              <!-- End Icon Cart -->
            </div>
            <!-- End Col -->
            <div class="col-xl-3 col-lg-4 col-sm-6">
              <div class="icon-card mb-30">
                <div class="icon orange">
                  <i class="lni lni-user"></i>
                </div>
                <div class="content">
                  <h6 class="mb-10">Total Students</h6>
                  <h3 class="text-bold mb-10">{{ $total_students }}</h3>
                </div>
              </div>
              <!-- End Icon Cart -->
            </div>
            <!-- End Col -->
          </div>
          <!-- End Row -->
       
          <!-- Start Row -->
          <div class="row">
            <div class="col-lg-5">
                    <div class="card-style"  style="height: 512px">
                        <h6 class="mb-3">System Overview</h6>
                        <canvas id="overviewChart" style="height: 250px;"></canvas>
                    </div>
            </div>
            <!-- End Col -->
            <div class="col-lg-7">
              <div class="card-style mb-30">
                <div class="title d-flex flex-wrap justify-content-between align-items-center">
                  <div class="left">
                    <h6 class="text-medium mb-30">Most Students in a Course</h6>
                  </div>
                </div>
                <!-- End Title -->
                <div class="table-responsive">
                  <table class="table top-selling-table">
                    <thead>
                      <tr>
                        <th>
                          <h6 class="text-sm text-medium">Course</h6>
                        </th>
                        <th class="min-width">
                          <h6 class="text-sm text-medium">Instructor</h6>
                        </th>
                        <th class="min-width">
                          <h6 class="text-sm text-medium">Students Count</h6>
                        </th>
                        <th class="min-width">
                          <h6 class="text-sm text-medium">Price</h6>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($mostStudentsInCourse as $course)
                      <tr>
                        <td>
                          <div class="product">
                            <div class="image">
                              <img src="{{ $course->getFirstMediaUrl('course-image') }}" alt="" />
                            </div>
                            <p class="text-sm">{{ $course->title }}</p>
                          </div>
                        </td>
                        <td>
                          <p class="text-sm">{{ $course->instructor->full_name }}</p>
                        </td>
                         <td>
                          <p class="text-sm">{{ $course->students_count}}</p>
                        </td>
                        <td>
                          <p class="text-sm">${{ $course->price}}</p>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  <!-- End Table -->
                </div>
              </div>
            </div>
            <!-- End Col -->
          </div>
        
          <div class="row">
                <div class="col-lg-6">
                        <div class="card-style mb-30">
                            <h6 class="mb-3">Courses, Instructors & Students</h6>
                            <canvas id="overviewChart" style="height: 300px;"></canvas>
                        </div>
                </div>
                <div class="col-lg-6">
                    <div class="card-style mb-30">
                        <h6 class="mb-3">Total Income Overview</h6>
                        <canvas id="incomeChart" style="height: 300px;"></canvas>
                    </div>
                </div>
         </div>



         @section('custom-js')

         <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Overview chart (Courses, Instructors, Students)
            const ctxOverview = document.getElementById('overviewChart');
            if (ctxOverview) {
                new Chart(ctxOverview, {
                    type: 'bar',
                    data: {
                        labels: ['Courses', 'Instructors', 'Students'],
                        datasets: [{
                            label: 'Count',
                            data: @json([$total_courses, $total_instructors, $total_students]),
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.7)',
                                'rgba(255, 206, 86, 0.7)',
                                'rgba(75, 192, 192, 0.7)'
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            tooltip: { enabled: true }
                        },
                        scales: {
                            y: { beginAtZero: true, precision: 0 }
                        }
                    }
                });
            }

            // Income chart (Monthly)
            const ctxIncome = document.getElementById('incomeChart');
            if (ctxIncome) {
                new Chart(ctxIncome, {
                    type: 'doughnut',
                    data: {
                        labels: [
                            'January','February','March','April','May','June',
                            'July','August','September','October','November','December'
                        ],
                        datasets: [{
                            label: 'Monthly Income',
                            data: @json($income_data),
                            backgroundColor: [
                                '#4e73df','#1cc88a','#36b9cc','#f6c23e',
                                '#e74a3b','#858796','#fd7e14','#20c997',
                                '#6610f2','#6f42c1','#d63384','#198754'
                            ],
                            borderColor: '#fff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'bottom' },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return '$' + context.raw.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
        </script>



         @endsection