<x-admin-layout title="Applicant Dashboard">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title"> Dashboard</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
           
            <div class="">
                <div class="card-body">
                    <h5 class="card-title">Welcome, <strong>{{ auth()->user()->first_name }}</strong></h5>

                </div>
            </div>
             @include('profile.partials.completion-tracker', ['user' => auth()->user()])
        </div>
    </div>
</x-admin-layout>
