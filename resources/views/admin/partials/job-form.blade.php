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
    <label>Category</label>
    <input type="text" name="category" class="form-control" value="{{ old('category', $job?->category) }}" placeholder="e.g. Healthcare, Finance, Engineering">
</div>

<div class="form-group">
    <label>Company Logo</label>
    <input type="file" name="logo" class="form-control" accept=".jpg,.jpeg,.png,.webp,.gif,.svg,image/*">
    @if ($job?->logo)
        <div class="d-flex align-items-center gap-2 mt-2">
            <img src="{{ $job->logoUrl() }}" alt="{{ $job->company }} logo" width="44" height="44"
                class="rounded border" style="object-fit: contain;">
            <span class="text-muted small">Current logo</span>
        </div>
    @endif
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
