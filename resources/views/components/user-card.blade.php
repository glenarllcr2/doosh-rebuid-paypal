@php
    $interesteds = $user->userAnswersWithQuestions();
@endphp

<div class="card bg-light d-flex flex-fill">
    <div class="card-header border-bottom-0">
        <h5 class="card-title">{{ $user->display_name }}</h5>
        <p class="card-text"><small class="text-muted">({{ $user->age }} years old)</small></p>
    </div>
    <div class="card-body pt-2">
        <div class="row">
            <div class="col-7">
                <p class="text-muted text-sm"><b>Interests:</b><br />
                    <strong>Job: </strong> {{ $interesteds['industry'] }}<br />
                    <strong>Location: </strong> {{ $interesteds['country_live'] }}<br />
                    <strong>Denomination: </strong> {{ $interesteds['church'] }}<br />
                    <strong>Education: </strong> {{ $interesteds['education'] }}<br />
                    <strong>Divorced: </strong> {{ $interesteds['married'] }}<br />
                    <strong>Height: </strong> {{ $interesteds['height'] }} ft<br />
                </p>
            </div>
            <div class="col-5 text-center">
                <img src="{{ asset('storage/' . $user->profileImage) }}" alt="user-avatar" class="img-fluid">
            </div>
        </div>
    </div>
    <div class="card-footer">
        @include('components.partials.user-actions', ['user' => $user, 'mode' => $mode])
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
                    <input type="hidden" id="targetUserId" value="{{ $user->id }}">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="submitReport" data-bs-dismiss="modal">Submit Report</button>
            </div>
        </div>
    </div>
</div>
