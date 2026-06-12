<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JobController extends Controller
{
    public function index(Request $request): View
    {
        $sortableColumns = ['title', 'company', 'start_date', 'due_date', 'created_at'];
        $sortColumn = $request->input('sort') && in_array($request->input('sort'), $sortableColumns, true)
            ? $request->input('sort')
            : 'created_at';
        $sortDirection = $request->input('direction') === 'asc' ? 'asc' : 'desc';

        $jobs = Job::query()
            ->where('employer_id', $request->user()->id)
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = '%'.$request->string('search')->trim().'%';

                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', $search)
                        ->orWhere('company', 'like', $search)
                        ->orWhere('description', 'like', $search);
                });
            })
            ->orderBy($sortColumn, $sortDirection)
            ->paginate(15)
            ->withQueryString();

        return view('admin.Jobs', [
            'jobs' => $jobs,
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules($request));

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('job-logos', 'public');
        }

        $request->user()->jobs()->create($data);

        return redirect()
            ->route('jobs')
            ->with('success', 'Job created successfully.');
    }

    public function update(Request $request, Job $job): RedirectResponse
    {
        $this->ensureEmployerOwnsJob($request, $job);

        $data = $request->validate($this->rules($request));

        if ($request->hasFile('logo')) {
            $this->deleteStoredLogo($job);
            $data['logo'] = $request->file('logo')->store('job-logos', 'public');
        } elseif (array_key_exists('logo', $data) && $data['logo'] !== $job->logo) {
            $this->deleteStoredLogo($job);
        }

        $job->update($data);

        return redirect()
            ->route('jobs')
            ->with('success', 'Job updated successfully.');
    }

    public function destroy(Request $request, Job $job): RedirectResponse
    {
        $this->ensureEmployerOwnsJob($request, $job);

        $this->deleteStoredLogo($job);
        $job->delete();

        return redirect()
            ->route('jobs')
            ->with('success', 'Job deleted successfully.');
    }

    public function show(Job $job): View
    {
        return view('job-details', [
            'job' => $job,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(Request $request): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'company' => ['required', 'string', 'max:255'],
            'logo' => $request->hasFile('logo')
                ? ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif,svg', 'max:2048']
                : ['nullable', 'string', 'max:2048'],
            'start_date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after_or_equal:start_date'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }

    private function deleteStoredLogo(Job $job): void
    {
        if ($path = $job->storedLogoPath()) {
            Storage::disk('public')->delete($path);
        }
    }

    private function ensureEmployerOwnsJob(Request $request, Job $job): void
    {
        abort_unless($job->employer_id === $request->user()->id, 403);
    }
}
