<!-- Image Upload -->
<div class="mb-4 image-section">
    <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
    <input type="file" id=""
        class="uploadImage mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
        placeholder="Choose Image" name="">
    <input type="hidden" name="image" id="cropped_image">

    <!-- Image Preview and Remove Button -->
    <div class="previewWrapper mt-4 {{ !$image ? 'hidden' : '' }} ">
        <div class="flex items-center space-x-4">
            <img src="{{ asset($image) }}" class="croppedPreview h-20 object-contain rounded-md"
                alt="Cropped Image Preview">
            @if (!$image)
                <button type="button" id=""
                    class="removeCroppedImage text-red-600 hover:text-red-800 text-sm font-medium focus:outline-none">Remove</button>
            @endif
        </div>
    </div>
    @if ($errors->has('image'))
        <span id="err-msg" class="text-sm text-red-500">{{ $errors->first('image') }}</span>
    @endif
</div>

<!-- Modal -->
<div id="modal" class="absolute inset-0 bg-gray-500 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-2/3 h-[500px] p-8 max-h-[90%] overflow-auto">
        <div id="original-preview-container" class="mt-4">
            <img id="imagePreview" src="" alt="Original Image Preview" style="max-width: 100%; display: none;">
        </div>

        <div class="mt-8 flex justify-end space-x-4">
            <button id="closeModalBtn" class="px-4 py-2 bg-red-500 text-white rounded">Cancel</button>
            <button id="cropButton" class="px-4 py-2 bg-blue-500 text-white rounded">Crop</button>
        </div>
    </div>
</div>

<!-- Cropper.js CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<!-- Cropper.js JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<script>
    $(document).ready(function() {
        var cropper;
        // Preview Image (triggered by Preview button)
        $(document).on('change', '.uploadImage', function() {
            $('#modal').removeClass('hidden');
            var file = $(this)[0].files[0]; // Get the selected file

            if (file) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result);
                    $('#imagePreview').show(); // Show the original image preview

                    // Initialize the cropper
                    if (cropper) {
                        cropper.destroy(); // Destroy the previous cropper instance if it exists
                    }

                    cropper = new Cropper($('#imagePreview')[0], {
                        aspectRatio: 3 / 2, // Maintain a square aspect ratio for cropping
                        viewMode: 1, // Restrict image inside the canvas
                        ready: function() {
                            console.log('Cropper ready!');
                        }
                    });
                };

                console.log(cropper)

                reader.readAsDataURL(file); // Read file as DataURL
            }
        });

        $(document).on('click', '#cropButton', function(e) {
            e.preventDefault();
            $('#modal').addClass('hidden');
            $('.previewWrapper').show();
            $('#err-msg').hide();
            if (cropper) {
                var canvas = cropper.getCroppedCanvas();
                var croppedDataURL = canvas.toDataURL();
                $('#cropped_image').val(croppedDataURL);
                $('.croppedPreview').attr('src', croppedDataURL);
                $('.croppedPreview').show(); // Show the cropped preview

            } else {
                alert('Please preview and crop an image first!');
            }
        });
    });

    $(document).on('click', '#closeModalBtn', function(e) {
        e.preventDefault();
        $('.uploadImage').val('');
        $('#modal').addClass('hidden');
    })

    $(document).on('click', '.removeCroppedImage', function(e) {
        e.preventDefault();
        $(this).closest('.image-section').find('.uploadImage').val('');
        $(this).closest('.image-section').find('#cropped_image').val('');
        $(this).parent().parent().hide();
    })
</script>
