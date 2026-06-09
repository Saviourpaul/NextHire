<x-admin-layout title="Applicant Dashboard">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Applicant Dashboard</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Welcome back, {{ auth()->user()->first_name }}.</h5>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
