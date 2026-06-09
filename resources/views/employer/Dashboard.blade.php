<x-admin-layout title="Dashboard">
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h3 class="page-title">Dashboard</h3>
				<ul class="breadcrumb">
				</ul>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8">
			<div class="row">
				<div class="col-md-4 d-flex">
					<div class="card wizard-card flex-fill">
						<div class="card-body">
							<p class="text-primary mt-0 mb-2">Users</p>
							<h5>1682</h5>
							<p><a href="javascript:void(0);">view details</a></p>
							<span class="dash-widget-icon bg-1">
								<i class="fas fa-users"></i>
							</span>
						</div>
					</div>
				</div>

				<div class="col-md-4 d-flex">
					<div class="card wizard-card flex-fill">
						<div class="card-body">
							<p class="text-primary mt-0 mb-2">Completed Projects</p>
							<h5>15k</h5>
							<p><a href="javascript:void(0);">view details</a></p>
							<span class="dash-widget-icon bg-1">
								<i class="fas fa-th-large"></i>
							</span>
						</div>
					</div>
				</div>

				<div class="col-md-4 d-flex">
					<div class="card wizard-card flex-fill">
						<div class="card-body">
							<p class="text-primary mt-0 mb-2">Active Projects</p>
							<h5>1568</h5>
							<p><a href="javascript:void(0);">view details</a></p>
							<span class="dash-widget-icon bg-1">
								<i class="fas fa-bezier-curve"></i>
							</span>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12 d-flex">
					<div class="card w-100">
						<div class="card-body pt-0 pb-2">
							<div class="card-header">
								<h5 class="card-title">Overview</h5>
							</div>
							<div id="chart" class="mt-4"></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-4 d-flex">
			<div class="card w-100">
				<div class="card-body pt-0">
					<div class="card-header">
						<div class="row">
							<div class="col-7">
								<p>Welcome back,</p>
								<h6 class="text-primary">Super Admin</h6>
							</div>
							<div class="col-5 text-end">
								<span class="welcome-dash-icon bg-1">
									<i class="fas fa-user"></i>
								</span>
							</div>
						</div>
					</div>

					<div class="account-balance">
						<p>Account balance</p>
						<h6>$50,000.00</h6>
					</div>

					<div class="mt-3">
						<h6 class="text-primary">Payments</h6>
						<div class="table-responsive">
							<table class="table table-center table-hover mb-0">
								<thead>
									<tr>
										<th class="text-nowrap">Client or Freelancer</th>
										<th>Amount</th>
										<th class="text-end">Status</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="text-nowrap">Sakib Khan</td>
										<td>$2222</td>
										<td class="text-end">Completed</td>
									</tr>
									<tr>
										<td class="text-nowrap">Pixel Inc Ltd</td>
										<td>$750</td>
										<td class="text-end">Pending</td>
									</tr>
									<tr>
										<td class="text-nowrap">Jon M Mullins</td>
										<td>$3150</td>
										<td class="text-end text-nowrap">Released</td>
									</tr>
									<tr>
										<td class="text-nowrap">Rose M Milewski</td>
										<td>$1455</td>
										<td class="text-end text-nowrap">Returned</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="card bg-white projects-card">
				<div class="card-body pt-0">
					<div class="card-header">
						<h5 class="card-title">Reviews</h5>
					</div>

					<div class="reviews-menu-links">
						<ul role="tablist" class="nav nav-pills card-header-pills nav-justified">
							<li class="nav-item">
								<a href="#tab-all" data-bs-toggle="tab" class="nav-link active">All (272)</a>
							</li>
							<li class="nav-item">
								<a href="#tab-active" data-bs-toggle="tab" class="nav-link">Active (218)</a>
							</li>
							<li class="nav-item">
								<a href="#tab-pending" data-bs-toggle="tab" class="nav-link">Pending Approval (03)</a>
							</li>
							<li class="nav-item">
								<a href="#tab-trash" data-bs-toggle="tab" class="nav-link">Trash (0)</a>
							</li>
						</ul>
					</div>

					<div class="tab-content pt-0">
						<div role="tabpanel" id="tab-all" class="tab-pane fade active show">
							<div class="table-responsive">
								<table class="table table-hover table-center mb-0 datatable">
									<thead>
										<tr>
											<th></th>
											<th>Profile</th>
											<th>Designation</th>
											<th>Comments</th>
											<th>Stars</th>
											<th>Category</th>
											<th class="text-end">Actions</th>
										</tr>
									</thead>
									<tbody>
										@foreach ([
											['avatar' => 'avatar-14.jpg', 'name' => 'Janet Paden', 'role' => 'CEO', 'category' => 'Angular'],
											['avatar' => 'avatar-01.jpg', 'name' => 'George Wells', 'role' => 'Tech Lead', 'category' => 'Node'],
											['avatar' => 'avatar-15.jpg', 'name' => 'Timothy Smith', 'role' => 'Technical Manager', 'category' => 'React'],
										] as $index => $review)
											<tr>
												<td>
													<div class="form-check custom-checkbox">
														<input type="checkbox" class="form-check-input" id="reviewCheck{{ $index }}">
														<label class="form-check-label" for="reviewCheck{{ $index }}"></label>
													</div>
												</td>
												<td>
													<h2 class="table-avatar">
														<a href="javascript:void(0);">
															<img class="avatar-img rounded-circle me-2" src="{{ asset('admin/assets/img/profiles/'.$review['avatar']) }}" alt="User Image">
															{{ $review['name'] }}
														</a>
													</h2>
												</td>
												<td>{{ $review['role'] }}</td>
												<td>
													<div class="desc-info">
														Project delivery was reviewed and approved by the admin team.
													</div>
												</td>
												<td class="text-nowrap">
													<i class="fas fa-star text-primary"></i>
													<i class="fas fa-star text-primary"></i>
													<i class="fas fa-star text-primary"></i>
													<i class="fas fa-star text-primary"></i>
													<i class="fas fa-star text-muted"></i>
												</td>
												<td>{{ $review['category'] }}</td>
												<td class="text-end text-nowrap">
													<a href="javascript:void(0);" class="btn btn-approve text-white me-2">Approve</a>
													<a href="javascript:void(0);" class="btn btn-disable">Enable</a>
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>

						<div role="tabpanel" id="tab-active" class="tab-pane fade">
							<div class="table-responsive">
								<table class="table table-bordered table-hover datatable">
									<thead>
										<tr>
											<th>Profile</th>
											<th>Designation</th>
											<th>Category</th>
											<th class="text-end">Actions</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Active review</td>
											<td>Designer</td>
											<td>UI</td>
											<td class="text-end"><a href="javascript:void(0);" class="btn btn-disable">Enable</a></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>

						<div role="tabpanel" id="tab-pending" class="tab-pane fade">
							<div class="table-responsive">
								<table class="table table-bordered table-hover datatable">
									<thead>
										<tr>
											<th>Profile</th>
											<th>Designation</th>
											<th>Category</th>
											<th class="text-end">Actions</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Pending review</td>
											<td>Developer</td>
											<td>Laravel</td>
											<td class="text-end"><a href="javascript:void(0);" class="btn btn-approve text-white">Approve</a></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>

						<div role="tabpanel" id="tab-trash" class="tab-pane fade">
							<div class="table-responsive">
								<table class="table table-bordered table-hover datatable">
									<thead>
										<tr>
											<th>Profile</th>
											<th>Designation</th>
											<th>Category</th>
											<th class="text-end">Actions</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</x-admin-layout>
