
<x-admin-layout title="Dashboard">
	
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col-md-7">
				<h3 class="page-title">Dashboard</h3>
				<p class="text-muted mb-0">
					Recruitment insights for <strong>{{ $dateRange->label() }}</strong>
				</p>
			</div>
			<div class="col-md-5">
				
			</div>
		</div>
	</div>

	<div class="row mb-4">
		<div class="col-md-4 d-flex">
			<div class="card w-100">
				<div class="card-body pt-0">
					<div class="card-header border-0 pb-0">
						<div class="row align-items-center">
							<div class="col-8">
								<p class="mb-1 text-muted">Welcome back,</p>
								<h6 class="text-primary mb-0">
									<strong>{{ auth()->user()->first_name }}</strong>
								</h6>
							</div>
							<div class="col-4 text-end">
								<span class="welcome-dash-icon bg-1">
									<i class="fas fa-user-shield"></i>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	
</x-admin-layout>
