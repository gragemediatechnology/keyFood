<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern CMS Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js"></script>
    <style>
        /* Custom styles to enhance the form */
        body {
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            font-family: 'Inter', sans-serif;
        }

        .w-full {
            width: 100%;
        }

        .max-w-lg {
            max-width: 32rem;
        }

        .p-8 {
            padding: 2rem;
        }

        .bg-white {
            background-color: #ffffff;
        }

        .rounded-lg {
            border-radius: 0.75rem;
        }

        .shadow-lg {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .text-3xl {
            font-size: 1.875rem;
        }

        .font-bold {
            font-weight: 700;
        }

        .mb-6 {
            margin-bottom: 1.5rem;
        }

        .text-center {
            text-align: center;
        }

        .text-gray-700 {
            color: #4a5568;
        }

        .border {
            border-width: 1px;
        }

        .border-gray-300 {
            border-color: #d2d6dc;
        }

        .rounded-lg {
            border-radius: 0.75rem;
        }

        .focus\:outline-none:focus {
            outline: 2px solid transparent;
            outline-offset: 2px;
        }

        .focus\:ring-4:focus {
            box-shadow: 0 0 0 4px rgba(99, 179, 237, 0.5);
        }

        .focus\:ring-blue-300:focus {
            box-shadow: 0 0 0 4px rgba(99, 179, 237, 0.5);
        }

        .bg-blue-500 {
            background-color: #4299e1;
        }

        .text-white {
            color: #ffffff;
        }

        .hover\:bg-blue-600:hover {
            background-color: #2b6cb0;
        }

        .focus\:ring-blue-300:focus {
            box-shadow: 0 0 0 4px rgba(99, 179, 237, 0.5);
        }

        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .w-full {
            width: 100%;
        }

        .border-dashed {
            border-style: dashed;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .hover\:border-gray-400:hover {
            border-color: #a0aec0;
        }
    </style>
</head>
<body class="bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-lg p-8 bg-white rounded-lg shadow-lg">
        <form id="cmsForm" x-data="formHandler()" @submit.prevent="submitForm">
            <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">CMS Edit</h2>
            <div class="mb-6">
                <label for="title" class="block text-gray-700">Nama Company</label>
                <input type="text" id="title" name="title" class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-300" x-model="title" required>
            </div>
            <div class="mb-6">
                <label for="content" class="block text-gray-700">Alamat Company</label>
                <textarea id="content" name="content" rows="6" class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-300" x-model="content" required></textarea>
            </div>
            <div class="mb-6">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-300" x-model="email" required>
            </div>
            <div class="mb-6">
                <label for="image" class="block text-gray-700">Image 1</label>
                <div class="border-dashed border-2 border-gray-300 p-6 text-center rounded-lg cursor-pointer hover:border-gray-400" @click="$refs.image.click()">
                    <i class="fas fa-image text-gray-500 text-4xl mb-2" x-show="!imagePreview1" loading="lazy"></i>
                    <img :src="imagePreview1" alt="Image Preview" class="w-full h-full object-cover" x-show="imagePreview1">
                    <div x-show="!imagePreview1">Upload Foto 1</div>
                    <input type="file" id="image" name="image" class="hidden" @change="handleFileUpload('image', 'imagePreview1')" x-ref="image">
                </div>
            </div>
            <div class="mb-6">
                <label for="image2" class="block text-gray-700">Image 2</label>
                <div class="border-dashed border-2 border-gray-300 p-6 text-center rounded-lg cursor-pointer hover:border-gray-400" @click="$refs.image2.click()">
                    <i class="fas fa-image text-gray-500 text-4xl mb-2" x-show="!imagePreview2"></i>
                    <img :src="imagePreview2" alt="Image Preview" class="w-full h-full object-cover" x-show="imagePreview2" loading="lazy">
                    <div x-show="!imagePreview2">Upload Foto 2</div>
                    <input type="file" id="image2" name="image2" class="hidden" @change="handleFileUpload('image2', 'imagePreview2')" x-ref="image2">
                </div>
            </div>
            <div class="mb-6">
                <label for="image3" class="block text-gray-700">Image 3</label>
                <div class="border-dashed border-2 border-gray-300 p-6 text-center rounded-lg cursor-pointer hover:border-gray-400" @click="$refs.image3.click()">
                    <i class="fas fa-image text-gray-500 text-4xl mb-2" x-show="!imagePreview3"></i>
                    <img :src="imagePreview3" alt="Image Preview" class="w-full h-full object-cover" x-show="imagePreview3" loading="lazy">
                    <div x-show="!imagePreview3">Upload Foto 3</div>
                    <input type="file" id="image3" name="image3" class="hidden" @change="handleFileUpload('image3', 'imagePreview3')" x-ref="image3">
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="w-full py-4 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-300">Submit</button>
            </div>
        </form>
    </div>
    <script>
        function formHandler() {
            return {
                title: '',
                content: '',
                email: '',
                image: null,
                image2: null,
                image3: null,
                imagePreview1: '',
                imagePreview2: '',
                imagePreview3: '',
                handleFileUpload(refName, previewName) {
                    const file = this.$refs[refName].files[0];
                    const reader = new FileReader();
                    reader.onload = e => {
                        this[previewName] = e.target.result;
                    };
                    reader.readAsDataURL(file);
                    this[refName] = file;
                },
                submitForm() {
                    // Perform form validation
                    if (!this.title || !this.content || !this.email) {
                        alert('Please fill in all required fields.');
                        return;
                    }

                    // Simulate form submission
                    console.log('Form submitted!');
                    console.log('Title:', this.title);
                    console.log('Content:', this.content);
                    console.log('Email:', this.email);
                    console.log('Image 1:', this.image);
                    console.log('Image 2:', this.image2);
                    console.log('Image 3:', this.image3);

                    // You can replace this with actual form submission logic, such as an AJAX request
                }
            }
        }
    </script>
</body>
</html>
