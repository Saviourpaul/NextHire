<x-admin-layout title="Pending Approval">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Pending Approval</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Your account is waiting for admin approval.</h5>
                    <p class="mb-0">
                        Thanks for registering, {{ $user->first_name }}. You will be able to access your dashboard after an administrator activates your account.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
