@push('styles')
    <style>
        .profile-header .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #007bff;
        }

        .gallery img {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            object-fit: cover;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .gallery img:hover {
            transform: scale(1.1);
        }

        .gallery-item {
            position: relative;
            display: inline-block;
        }

        .delete-button {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: red;
            color: white;
            padding: 5px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
        }

        .delete-button:hover {
            background-color: darkred;
        }
    </style>
@endpush



<h3 class="mt-4">Photo Album</h3>
<div class="gallery d-flex gap-3 flex-wrap" id="photoGallery"></div>

<div class="mt-3">
    <input type="file" id="fileInput" class="form-control" multiple accept="image/*">
    <button id="uploadButton" class="btn btn-primary mt-2">Upload Photos</button>
</div>

<div id="toastContainer"></div>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const MAX_PHOTOS = 10; // تعداد حداکثر عکس‌ها
            const userData = {
                gallery: [],
                profilePicture: "https://via.placeholder.com/150",
            };

            const photoGallery = document.getElementById("photoGallery");
            const imageUploader = document.getElementById("fileInput");
            const uploadButton = document.getElementById("uploadButton");
            const profilePicture = document.getElementById("profilePicture");

            // بارگذاری گالری از سرور
            async function loadGalleryFromServer() {
                try {
                    const response = await fetch(
                        "{{ route('users-manager.user.all-pictures.show', ['user' => $user->id]) }}");
                    if (!response.ok) {
                        const errorData = await response.json();
                        showToast(errorData.message || "Failed to load gallery.", "danger");
                        return;
                    }

                    const data = await response.json();
                    userData.gallery = data.map(photo => ({
                        file_path: photo.file_path,
                        is_profile: photo.is_profile,
                        url: photo.is_profile ? `{{ asset('storage') }}/${photo.file_path}` :
                            `{{ asset('storage') }}/${photo.file_path}`
                    }));

                    // تنظیم عکس پروفایل
                    const profilePhoto = data.find(photo => photo.is_profile);
                    if (profilePhoto) {
                        profilePicture.src = `{{ asset('storage') }}/${profilePhoto.file_path}`;
                        userData.profilePicture = profilePicture.src;
                    }

                    renderGallery();
                    showToast("Gallery loaded successfully.", "success");
                } catch (error) {
                    console.error("Error loading gallery:", error);
                    showToast("An error occurred while loading the gallery.", "danger");
                }
            }

            // نمایش پیش‌نمایش عکس‌ها قبل از آپلود
            imageUploader.addEventListener("change", function(event) {
                const files = event.target.files;
                const fileArray = Array.from(files);

                // اطمینان از اینکه تعداد تصاویر بیشتر از حد مجاز نمی‌شود
                if (fileArray.length + userData.gallery.length > MAX_PHOTOS) {
                    showToast(`You can upload up to ${MAX_PHOTOS} photos.`, "warning");
                    return;
                }

                // پیش‌نمایش فایل‌های انتخابی
                fileArray.forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement("img");
                        img.src = e.target.result; // URL موقتی برای پیش‌نمایش
                        img.classList.add("gallery-image");
                        img.style.width = "100px";
                        img.style.height = "100px";
                        img.style.objectFit = "cover";
                        img.style.marginRight = "10px";

                        // ایجاد شیء برای نگهداری اطلاعات عکس و افزودن آن به گالری
                        const photoItem = {
                            file: file,
                            previewUrl: e.target.result,
                        };

                        // ذخیره اطلاعات عکس در آرایه گالری
                        userData.gallery.push(photoItem);
                        photoGallery.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            });

            // رندر گالری بعد از ارسال به سرور
            function renderGallery() {
                photoGallery.innerHTML = userData.gallery
                    .map((photo, index) => `
                <div class="gallery-item" id="photo-${index}">
                    <img src="${photo.previewUrl || photo.url}" alt="Photo ${index + 1}" class="gallery-image" draggable="true" data-index="${index}" data-src="${photo.previewUrl || photo.url}">
                    <button class="delete-button" onclick="confirmDeletePhoto(${index})">&times;</button>
                </div>`)
                    .join("");

                // اتصال به گالری برای تغییر عکس پروفایل
                const images = document.querySelectorAll(".gallery-item img");
                images.forEach(img => {
                    img.addEventListener("click", function() {
                        changeProfilePicture(img.getAttribute("data-src"));
                    });
                });
            }

            // تغییر عکس پروفایل
            function changeProfilePicture(newSrc) {
                profilePicture.src = newSrc;
                userData.profilePicture = newSrc;
                showToast("Profile picture updated successfully.", "success");
            }

            // ارسال فایل‌های جدید به سرور
            uploadButton.addEventListener("click", function() {
                const formData = new FormData();
                const files = imageUploader.files;

                if (files.length === 0) {
                    showToast("Please select photos to upload.", "warning");
                    return;
                }

                // اضافه کردن تمام فایل‌ها به formData
                Array.from(files).forEach(file => {
                    formData.append("photos[]", file); // ارسال فایل‌ها به صورت آرایه
                });

                // ارسال عکس‌ها به سرور
                fetch("{{ route('users-manager.user.upload-photo', ['user' => $user->id]) }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast(data.message, "success");

                            // به روز رسانی گالری با عکس‌های جدید
                            const newPhotos = data
                            .photos; // فرض کنید در پاسخ سرور یک آرایه از عکس‌ها وجود دارد
                            userData.gallery.push(...newPhotos); // اضافه کردن عکس‌ها به گالری

                            // رندر دوباره گالری
                            renderGallery();
                        } else {
                            showToast(data.message || "Failed to upload photos.", "danger");
                        }
                    })
                    .catch(error => {
                        console.error("Error uploading photos:", error);
                        showToast("Failed to upload photos.", "danger");
                    });
            });

            // نمایش Toast
            function showToast(message, type = "info") {
                const toastId = `toast-${Date.now()}`;
                const toast = document.createElement("div");
                toast.id = toastId;
                toast.className = `toast align-items-center text-bg-${type} border-0`;
                toast.role = "alert";
                toast.ariaLive = "assertive";
                toast.ariaAtomic = "true";
                toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;

                document.getElementById("toastContainer").appendChild(toast);

                const bootstrapToast = new bootstrap.Toast(toast);
                bootstrapToast.show();

                toast.addEventListener("hidden.bs.toast", () => {
                    toast.remove();
                });
            }

            // بارگذاری گالری هنگام بارگذاری صفحه
            loadGalleryFromServer();
        });
    </script>
@endpush
