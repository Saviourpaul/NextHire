@php
    $status = old('status', $job?->status ?? 'active');
@endphp

<div class="form-group">
    <label>Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $job?->title) }}" required>
</div>

<div class="form-group">
    <label>Description</label>
    <textarea class="form-control summernote" name="description">{{ old('description', $job?->description) }}</textarea>
</div>

<div class="form-group">
    <label>Company</label>
    <input type="text" name="company" class="form-control" value="{{ old('company', $job?->company) }}" required>
</div>

<div class="form-group">
    <label>Logo URL or path</label>
    <input type="text" name="logo" class="form-control" value="{{ old('logo', $job?->logo) }}" placeholder="admin/assets/img/company/img-10.png">
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>From Date</label>
            <input class="form-control" name="start_date" type="date" value="{{ old('start_date', $job?->start_date?->format('Y-m-d')) }}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>To Date</label>
            <input class="form-control" name="due_date" type="date" value="{{ old('due_date', $job?->due_date?->format('Y-m-d')) }}" required>
        </div>
    </div>
</div>

<div class="form-group">
    <label>Status</label>
    <select name="status" class="form-control" required>
        <option value="active" @selected($status === 'active')>Active</option>
        <option value="inactive" @selected($status === 'inactive')>Inactive</option>
    </select>
</div>
