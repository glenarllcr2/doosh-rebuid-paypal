@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Mydashboard</h1>
    <!-- Success and Error Messages -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="brows-users-tab" data-bs-toggle="tab" href="#brows-users-tabpanel" role="tab"
                aria-controls="brows-tabpanel" aria-selected="true">Browse</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="friends-tab" data-bs-toggle="tab" href="#friends-tabpanel" role="tab"
                aria-controls="friends-tabpanel" aria-selected="true">Friends</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="blocked-users-tab" data-bs-toggle="tab" href="#blocked-users-tabpanel" role="tab"
                aria-controls="blocked-users-tabpanel" aria-selected="false">Blocked Users</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="pending-requests-tab" data-bs-toggle="tab" href="#pending-requests-tabpanel"
                role="tab" aria-controls="pending-requests-tabpanel" aria-selected="false">Pending Friend Requests</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="search-tab" data-bs-toggle="tab" href="#search-tabpanel" role="tab"
                aria-controls="search-tabpanel" aria-selected="false">Search</a>
        </li>

    </ul>

    <!-- Tabs Content -->
    <div class="tab-content" id="tab-content">
        <div class="tab-pane fade show active" id="brows-users-tabpanel" role="tabpanel" aria-labelledby="brows-users-tab">
            @include('friends.partials.browse')
        </div>
        <!-- Friends Tab -->
        <div class="tab-pane fade" id="friends-tabpanel" role="tabpanel" aria-labelledby="friends-tab">
            @include('friends.partials.friends-tabs')
        </div>
        <!-- Blocked Users Tab -->
        <div class="tab-pane fade" id="blocked-users-tabpanel" role="tabpanel" aria-labelledby="blocked-users-tab">
            @include('friends.partials.blocked-friends')
        </div>
        <!-- Pending Friend Requests Tab -->
        <div class="tab-pane fade" id="pending-requests-tabpanel" role="tabpanel" aria-labelledby="pending-requests-tab">
            @include('friends.partials.receive-requesteds')
        </div>
        <!-- Search Tab -->
        <div class="tab-pane fade" id="search-tabpanel" role="tabpanel" aria-labelledby="search-tab">
            @include('friends.partials.search')
        </div>
    </div>

    <div class="modal fade" id="reportUserModal" tabindex="-1" aria-labelledby="reportUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportUserModalLabel">Report User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-danger">
                        Warning: Reporting this user is irreversible. False reports may lead to penalties for you.
                    </p>
                    <form id="reportUserForm">
                        <div class="mb-3">
                            <label for="reportReason" class="form-label">Reason for reporting:</label>
                            <textarea id="reportReason" class="form-control" rows="4"
                                placeholder="Please provide a detailed reason for reporting this user..." required></textarea>
                            <small class="text-muted">The reason must be at least 20 characters.</small>
                        </div>
                        <input type="hidden" id="targetUserId" value="">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="submitReport" data-bs-dismiss="modal">Submit
                        Report</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let reportData = null;

            // دریافت modal و دکمه‌های باز کردن modal
            const reportModal = document.getElementById('reportUserModal');
            const reportUserIdInput = document.getElementById('targetUserId');

            // وقتی modal باز می‌شود
            reportModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // دکمه‌ای که modal را باز کرده
                const userId = button.getAttribute('data-user-id'); // دریافت user_id از دکمه
                reportUserIdInput.value = userId; // تنظیم مقدار hidden input در فرم modal
            });

            // وقتی دکمه Submit Report کلیک می‌شود
            document.getElementById('submitReport').addEventListener('click', function() {
                const reportReason = document.getElementById('reportReason').value.trim();
                const targetUserId = reportUserIdInput.value;

                if (reportReason.length < 20) {
                    showToast('The reason must be at least 20 characters long.', 'danger');
                    return;
                }

                reportData = {
                    target_id: targetUserId,
                    report: reportReason,
                };

                const reportUrl = `{{ route('user-reports.store') }}`;

                fetch(reportUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(reportData),
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            showToast(data.message || 'The user has been reported successfully.',
                                'success');
                        } else {
                            showToast(data.message || 'There was a problem reporting the user.',
                                'danger');
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        showToast('An error occurred. Please try again.', 'danger');
                    });
            });

            function showToast(message, type) {
                const toastElement = document.getElementById('toastMessage');
                const toastBody = toastElement.querySelector('.toast-body');
                toastBody.textContent = message;

                const toast = new bootstrap.Toast(toastElement);
                toastElement.classList.remove('bg-success', 'bg-danger');
                toastElement.classList.add(type === 'success' ? 'bg-success' : 'bg-danger');

                toast.show();
            }
        });
    </script>
@endpush
