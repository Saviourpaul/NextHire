<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JobController extends Controller
{
    public function index(Request $request): View
    {
        $jobs = Job::query()
            ->where('employer_id', $request->user()->id)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.Jobs', [
            'jobs' => $jobs,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());

        $request->user()->jobs()->create($data);

        return redirect()
            ->route('jobs')
            ->with('success', 'Job created successfully.');
    }

    public function update(Request $request, Job $job): RedirectResponse
    {
        $this->ensureEmployerOwnsJob($request, $job);

        $job->update($request->validate($this->rules()));

        return redirect()
            ->route('jobs')
            ->with('success', 'Job updated successfully.');
    }

    public function destroy(Request $request, Job $job): RedirectResponse
    {
        $this->ensureEmployerOwnsJob($request, $job);

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
    private function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'company' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'string', 'max:2048'],
            'start_date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after_or_equal:start_date'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }

    private function ensureEmployerOwnsJob(Request $request, Job $job): void
    {
        abort_unless($job->employer_id === $request->user()->id, 403);
    }
}
