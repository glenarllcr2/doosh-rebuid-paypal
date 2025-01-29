<h3>Change Password</h3>

@if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form id="changePasswordForm" method="POST" action="{{ route('password.update') }}">
    @csrf
    @method('put')
    <div class="mb-3">
        <label for="currentPassword" class="form-label">Current Password</label>
        <input type="password" class="form-control" id="currentPassword" name="currentPassword" required
            autocomplete="current-password">
    </div>
    <div class="mb-3">
        <label for="newPassword" class="form-label">New Password</label>
        <input type="password" class="form-control" id="newPassword" name="newPassword" required
            autocomplete="new-password">
    </div>
    <div class="mb-3">
        <label for="newPassword_confirmation" class="form-label">Confirm New Password</label>
        <input type="password" class="form-control" id="newPassword_confirmation" name="newPassword_confirmation"
            required autocomplete="new-password">
    </div>
    <button type="submit" class="btn btn-primary">Change Password</button>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // جلوگیری از ارسال فرم و ریفرش صفحه
        document.getElementById("changePasswordForm").addEventListener("submit", function(e) {
            e.preventDefault(); // جلوگیری از ریفرش صفحه

            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const newPasswordConfirmation = document.getElementById('newPassword_confirmation').value;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // ارسال درخواست AJAX
            fetch("{{ route('users-manager.password.update.ajax') }}", {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': csrfToken, // اضافه کردن توکن CSRF به هدر
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    currentPassword: currentPassword,
                    newPassword: newPassword,
                    newPassword_confirmation: newPasswordConfirmation,
                }) // اینجا به درستی بسته شده است
            })
            .then(response => response.json())
            .then(data => {
                console.log(data); // بررسی داده‌های برگشتی از سرور

                // بررسی وضعیت موفقیت
                if (data.status) {
                    showToast('Success', data.status, 'bg-success');
                }
                // بررسی خطاها
                else if (data.errors) {
                    let errorMessages = '';
                    // بررسی اینکه آیا data.errors یک آبجکت است و نحوه دسترسی به پیام‌های خطا
                    if (typeof data.errors === 'object') {
                        for (let key in data.errors) {
                            if (data.errors.hasOwnProperty(key)) {
                                errorMessages += `${data.errors[key].join('<br>')}<br>`;
                            }
                        }
                    } else if (Array.isArray(data.errors)) {
                        // در صورتی که errors یک آرایه باشد
                        data.errors.forEach(error => {
                            errorMessages += `${error}<br>`;
                        });
                    }
                    showToast('Error', errorMessages, 'bg-danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error', 'An unknown error occurred', 'bg-danger');
            });

            // تابع نمایش Toast
            function showToast(title, body, toastClass) {
                const toastTitle = document.getElementById('toastTitle');
                const toastBody = document.getElementById('toastBody');

                if (!toastTitle || !toastBody) {
                    console.error("Toast elements not found");
                    return;
                }

                // تنظیم محتویات Toast
                toastTitle.textContent = title;
                toastBody.innerHTML = body;

                // تنظیم کلاس رنگ برای Toast
                const toastElement = document.getElementById('toast');
                toastElement.classList.remove('bg-success', 'bg-danger');
                toastElement.classList.add(toastClass);

                // نمایش Toast
                const toast = new bootstrap.Toast(toastElement);
                toast.show();
            }
        });
    });
</script>

@endpush
