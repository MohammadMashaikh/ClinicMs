@extends('layouts.master')


@php
    if ($user->hasRole('instructor')) {
        $user_image = $user->getFirstMediaUrl('instructor-image');
    } else {
        $user_image = $user->getFirstMediaUrl('student-image');
    }
@endphp


@section('custom-js')

<script>
    document.getElementById('profileImage').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const preview = document.getElementById('previewImage');

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
            }

            reader.readAsDataURL(file);
        }
    });
</script>


@endsection

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Card Wrapper -->
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4">Edit Profile</h3>
                    
                    <!-- Profile Picture Upload -->
                    <div class="text-center mb-4">
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        @if ($user_image)
                            <img id="previewImage" src="{{ $user_image }}" class="rounded-circle mb-2" width="100" height="100" alt="Profile Picture">
                        @endif
                        <div>
                            <label for="profileImage" class="btn btn-outline-secondary btn-sm">
                                Change Photo
                                <input type="file" id="profileImage" name="profile_image" class="d-none" accept="image/*">
                            </label>
                        </div>
                    </div>

                    <!-- Form Start -->
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="first_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}">
                        </div>

                        <div class="mb-3">
                            <label for="last_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}">
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password <small class="text-muted"> (leave blank if not changing)</small></label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>

                        <!-- Save Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3">Save Changes</button>
                        </div>
                    </form>
                    <!-- Form End -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection