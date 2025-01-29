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

        #uploadButton {
            margin-top: 10px;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }

        #uploadButton:hover {
            background-color: #0056b3;
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
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .delete-button:hover {
            background-color: #cc0000;
        }
    </style>
@endpush

<h3>Photo Album</h3>
<div class="gallery d-flex gap-3 flex-wrap" id="photoGallery"></div>

<div class="mt-3">
    <input type="file" id="imageUploader" class="form-control" multiple accept="image/*">
    <button id="uploadButton" class="btn btn-primary">Upload Photos</button>
</div>

@push('scripts')
    <script>
        const MAX_PHOTOS = 12; // حداکثر تعداد عکس‌ها

        const userData = {
            gallery: [],
            profilePicture: "https://via.placeholder.com/150", // عکس پروفایل پیش‌فرض
        };

        const photoGallery = document.getElementById("photoGallery");
        const imageUploader = document.getElementById("imageUploader");
        const uploadButton = document.getElementById("uploadButton");
        console.info(uploadButton);

        // لود کردن گالری از سرور
        async function loadGallery() {
            
            const userId = {{ $user->id }}; // استفاده از شناسه کاربر
            try {
                const response = await fetch("{{ route('users-manager.user.all-pictures.show', ['user' => $user->id]) }}");

                const data = await response.json();
                //console.info(response);
                if (Array.isArray(data)) {
                    //console.log("Data received:", data);
                    userData.gallery = data.map(media => ({
                        file_path: media.file_path, // تغییر به file_path
                        id: media.id
                    }));
                    console.log(userData);
                    renderGallery();
                }
            } catch (error) {
                console.error("Error loading gallery:", error);
            }
        }

        // رندر کردن گالری
        function renderGallery() {
            photoGallery.innerHTML = userData.gallery
                .map(
                    (media, index) =>
                    `<div class="gallery-item" id="photo-${index}">
                             <img src="{{ asset('storage') }}/${media.file_path}" alt="Photo ${index + 1}" class="gallery-image" draggable="true" data-index="${index}" onclick="changeProfilePicture(this)" ondragstart="drag(event)" ondragover="allowDrop(event)" ondrop="drop(event)">
                            <button class="delete-button" onclick="deletePhoto(${media.id}, ${index})">Delete</button>
                        </div>`
                )
                .join("");
        }

        // تغییر عکس پروفایل
        function changeProfilePicture(imgElement) {
            const profilePicture = document.getElementById("profilePicture");
            profilePicture.src = imgElement.src;
            userData.profilePicture = imgElement.src;
        }

        // آپلود عکس جدید
        uploadButton.addEventListener("click", () => {
            console.log('click');
            const files = Array.from(imageUploader.files);
            
            if (userData.gallery.length + files.length > MAX_PHOTOS) {
                alert(`You can only upload up to ${MAX_PHOTOS} photos.`);
                return;
            }
            console.log(files);
            const formData = new FormData();
            files.forEach((file) => {
                formData.append('photos[]', file); // 'photos[]' برای ارسال به صورت آرایه
            });

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            //console.log(formData);
            fetch("{{ route('users-manager.upload-photos') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken, // اضافه کردن توکن CSRF
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        //console.log(data);
                        const newPhotos = data.photos.map(media => ({
                            file_path: media.file_path, // تغییر به file_path
                            id: media.id
                        }));
                        userData.gallery.push(...newPhotos); // افزودن به گالری
                        renderGallery();
                        imageUploader.value = ''; // ریست کردن ورودی فایل
                    } else {
                        console.error('Error uploading photos', data.errors);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while uploading photos.');
                });
        });

        // حذف عکس
        function deletePhoto(mediaId, index) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/users-manager/media/${mediaId}`, { // مسیر اصلاح شد
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        userData.gallery.splice(index, 1);
                        renderGallery();
                    } else {
                        alert('Error deleting photo.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the photo.');
                });
        }

        // برای کشیدن و رها کردن تصاویر
        function allowDrop(event) {
            event.preventDefault();
        }

        function drag(event) {
            event.dataTransfer.setData("text", event.target.id);
        }

        function drop(event) {
            event.preventDefault();
            const draggedElementId = event.dataTransfer.getData("text");
            const draggedElement = document.getElementById(draggedElementId);
            const targetElement = event.target;

            if (targetElement.tagName.toLowerCase() !== "img") return;

            const draggedIndex = parseInt(draggedElement.getAttribute("data-index"));
            const targetIndex = parseInt(targetElement.getAttribute("data-index"));

            const temp = userData.gallery[draggedIndex];
            userData.gallery[draggedIndex] = userData.gallery[targetIndex];
            userData.gallery[targetIndex] = temp;

            renderGallery();
        }

        // بارگذاری گالری هنگام بارگذاری صفحه
        loadGallery();
    </script>
@endpush
