<x-admin-layout title="Documents">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Documents</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Uploaded Documents</h5>
                    <p class="text-muted">Manage your CV, certificates, and identification documents here.</p>

                    <div class="alert alert-info mb-3">No documents uploaded yet.</div>

                    <div class="table-responsive">
                        <table class="table table-center table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Document</th>
                                    <th>Status</th>
                                    <th>Uploaded</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">No documents available</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-primary" type="button" disabled>Upload Documents</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Accepted Documents</h5>
                    <ul class="mb-0">
                        <li>CV or Resume</li>
                        <li>Certificates</li>
                        <li>Government-issued ID</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
