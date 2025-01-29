@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <div class="card">
            <div class="card-header">
                <h5>Report Details</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6 d-flex align-items-center">
                        <h6 class="fw-bold me-2">Complainant</h6>
                        <a href="{{ route('users-manager.show', $report->reporter->id) }}" class="d-flex align-items-center">
                            @if ($report->reporter->profile_image)
                                <img src="{{ asset('storage/' . $report->reporter->profile_image) }}" alt="Complainant Image"
                                    class="rounded-circle" width="40" height="40">
                            @else
                                <i class="bi bi-person-circle" style="font-size: 40px;"></i>
                            @endif
                            <p class="ms-2">{{ $report->reporter_name }}</p>
                        </a>
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <h6 class="fw-bold me-2">Defendant</h6>
                        <a href="{{ route('users-manager.show', $report->target->id) }}" class="d-flex align-items-center">
                            @if ($report->target->profile_image)
                                <img src="{{ asset('storage/' . $report->target->profile_image) }}" alt="Defendant Image"
                                    class="rounded-circle" width="40" height="40">
                            @else
                                <i class="bi bi-person-circle" style="font-size: 40px;"></i>
                            @endif
                            <p class="ms-2">{{ $report->target_name }}</p>
                        </a>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="fw-bold">Created At</h6>
                        <p>{{ \Carbon\Carbon::parse($report->created_at)->format('Y-m-d H:i:s') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">Status</h6>
                        <span
                            class="badge
                        @if ($report->status == 'accepted') bg-success
                        @elseif($report->status == 'rejected') bg-danger
                        @else bg-warning @endif
                    ">
                            {{ ucfirst($report->status) }}
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    <h6 class="fw-bold">Report</h6>
                    <p>{{ $report->report }}</p>
                </div>

                <div class="mb-3">
                    <h6 class="fw-bold">Answer</h6>
                    <p>{{ $report->answer ? $report->answer : 'No answer provided' }}</p>
                </div>

                <div class="mb-3">
                    <h6 class="fw-bold">Page URL</h6>
                    <p>{{ $report->page_url ? $report->page_url : 'No URL provided' }}</p>
                </div>

                <div class="mb-3">
                    <h6 class="fw-bold">User Agent</h6>
                    <p>{{ $report->user_agent ? $report->user_agent : 'No user agent provided' }}</p>
                </div>

                <div class="mb-3">
                    <h6 class="fw-bold">Review Date</h6>
                    <p>{{ $report->review_date ? \Carbon\Carbon::parse($report->review_date)->format('Y-m-d H:i:s') : 'No review date provided' }}
                    </p>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('user-reports.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Reports
                    </a>
                    <div>
                        <button type="button" class="btn btn-success" id="acceptReport" data-action="accept">
                            <i class="bi bi-check-lg"></i> Accept
                        </button>
                        <button type="button" class="btn btn-danger" id="rejectReport" data-action="reject">
                            <i class="bi bi-x-lg"></i> Reject
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="adminMessageModal" tabindex="-1" aria-labelledby="adminMessageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="adminMessageModalLabel">Admin Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea id="adminMessage" class="form-control" rows="4" placeholder="Enter your message here..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmAction">Submit</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let action = null; // ذخیره نوع اکشن (accept یا reject)

            // باز کردن مودال و ذخیره اکشن
            document.getElementById('acceptReport').addEventListener('click', function() {
                action = 'accept';
                const modal = new bootstrap.Modal(document.getElementById('adminMessageModal'));
                modal.show();
            });

            document.getElementById('rejectReport').addEventListener('click', function() {
                action = 'reject';
                const modal = new bootstrap.Modal(document.getElementById('adminMessageModal'));
                modal.show();
            });

            // ارسال درخواست AJAX
            document.getElementById('confirmAction').addEventListener('click', function() {
                const adminMessage = document.getElementById('adminMessage').value.trim();
                const reportId = {{ $report->id }}; // ID گزارش

                // اطمینان از اینکه پیام خالی نیست
                if (!adminMessage) {
                    alert('Please enter a message before submitting.');
                    return;
                }

                const url = `{{ route('user-reports.index') }}/${reportId}/${action}`;

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            answer: adminMessage
                        }) // ارسال پیام ادمین
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        if (data.success) {
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Something went wrong.');
                    });

                // بستن مودال
                const modal = bootstrap.Modal.getInstance(document.getElementById('adminMessageModal'));
                modal.hide();
            });
        });
    </script>
@endpush
