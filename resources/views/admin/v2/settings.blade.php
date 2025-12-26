@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')
    <div class="max-w-full mx-auto">
        <!-- left column -->
        <div class="w-full">
            <!-- general form elements -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-800">Site Settings</h3>
                </div>

                <form id="form" role="form" action="{{ route('v2.admin.site.setting.update') }}" method="POST"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                        <!-- First Row -->
                        <div class="form-group">
                            <label class="text-gray-700" for="name">Name</label>
                            <input class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" id="name"
                                type="text" name="name" value="{{ $site->name ?? '' }}" required>
                            @if ($errors->has('name'))
                                <span class="text-sm text-red-600">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="text-gray-700" for="title">Title</label>
                            <input class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" id="title"
                                type="text" name="title" value="{{ $site->title ?? '' }}" required>
                            @if ($errors->has('title'))
                                <span class="text-sm text-red-600">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="text-gray-700" for="map">Embed Contact Map</label>
                            <textarea class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" name="map" id=""
                                cols="30" rows="5">{{ $site->map }}</textarea>
                            @if ($errors->has('map'))
                                <span class="text-sm text-red-600">{{ $errors->first('map') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="text-gray-700" for="whatsapplink">Whatsapp Link</label>
                            <textarea class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" name="whatsapplink" id=""
                                cols="30" rows="5">{{ $site->whatsapplink }}</textarea>
                            @if ($errors->has('whatsapplink'))
                                <span class="text-sm text-red-600">{{ $errors->first('whatsapplink') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <!-- Image Field -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="image">Primary Logo
                                    (100X54px)
                                </label>
                                <input
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm image @error('image') border-red-500 @enderror"
                                    id="image" type="file" name="primary_logo">
                                <span class="flex items-center gap-4">
                                    <img class="view-image mt-2"
                                        src="{{ $site->primary_logo ? asset('uploads/site/' . $site->primary_logo) : asset('frontend/images/logo.png') }}"
                                        style="max-height: 100px; width: auto;">
                                    @if ($site->primary_logo)
                                        @can('update sitesetting')
                                            <a href="{{ route('v2.admin.site.setting.remove.file', ['filename' => $site->primary_logo, 'type' => 'primary_logo']) }}"
                                                class="bg-red-500 p-1 px-2 text-white rounded-md btnRemoveFile">Remove</a>
                                        @endcan
                                    @endif
                                </span>

                                @error('image')
                                    <span class="text-sm text-red-500">*{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- Image Field -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="image">Secondary Logo
                                    (250X60px)
                                </label>
                                <input
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm image @error('image') border-red-500 @enderror"
                                    id="image" type="file" name="secondary_logo">

                                <span class="flex items-center gap-4">
                                    <img class="view-image mt-2"
                                        src="{{ $site->secondary_logo ? asset('uploads/site/' . $site->secondary_logo) : asset('frontend/images/footer_logo.png') }}"
                                        style="max-height: 100px; width: auto;">
                                    @if ($site->secondary_logo)
                                        @can('update sitesetting')
                                            <a href="{{ route('v2.admin.site.setting.remove.file', ['filename' => $site->secondary_logo, 'type' => 'secondary_logo']) }}"
                                                class="bg-red-500 p-1 px-2 text-white rounded-md btnRemoveFile">Remove</a>
                                        @endcan
                                    @endif
                                </span>

                                @error('image')
                                    <span class="text-sm text-red-500">*{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <!-- Image Field -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="image">Payment Partners
                                    (300X100px)
                                </label>
                                <input
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm image @error('image') border-red-500 @enderror"
                                    id="image" type="file" name="payment_partners_image">

                                <span class="flex items-center gap-4">
                                    <img class="view-image mt-2"
                                        src="{{ $site->payment_partners_image ? asset('uploads/site/' . $site->payment_partners_image) : asset('frontend/images/footer-payment.jpg') }}"
                                        style="max-height: 100px; width: auto;">
                                    @if ($site->payment_partners_image)
                                        @can('update sitesetting')
                                            <a href="{{ route('v2.admin.site.setting.remove.file', ['filename' => $site->payment_partners_image, 'type' => 'payment_partners_image']) }}"
                                                class="bg-red-500 p-1 px-2 text-white rounded-md btnRemoveFile">Remove</a>
                                        @endcan
                                    @endif
                                </span>
                                @error('image')
                                    <span class="text-sm text-red-500">*{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- Image Field -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="image">Affiliated Partners
                                    (300X100px)
                                </label>
                                <input
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm image @error('image') border-red-500 @enderror"
                                    id="image" type="file" name="affiliated_partners_image">

                                <span class="flex items-center gap-4">
                                    <img class="view-image mt-2"
                                        src="{{ $site->affiliated_partners_image ? asset('uploads/site/' . $site->affiliated_partners_image) : asset('frontend/images/footer-affiliate.jpg') }}"
                                        style="max-height: 100px; width: auto;">
                                    @if ($site->affiliated_partners_image)
                                        @can('update sitesetting')
                                            <a href="{{ route('v2.admin.site.setting.remove.file', ['filename' => $site->affiliated_partners_image, 'type' => 'affiliated_partners_image']) }}"
                                                class="bg-red-500 p-1 px-2 text-white rounded-md btnRemoveFile">Remove</a>
                                        @endcan
                                    @endif
                                </span>
                                @error('image')
                                    <span class="text-sm text-red-500">*{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <!-- Image Field -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="image">Homepage Mobile Ad
                                    (412X130px)
                                </label>
                                <input
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm image @error('image') border-red-500 @enderror"
                                    id="image" type="file" name="homepage_mobile_ad">

                                <span class="flex items-center gap-4">
                                    <img class="view-image mt-2"
                                        src="{{ $site->homepage_mobile_ad ? asset('uploads/site/' . $site->homepage_mobile_ad) : '' }}"
                                        style="max-height: 100px; width: auto;">
                                    @if ($site->homepage_mobile_ad)
                                        @can('update sitesetting')
                                            <a href="{{ route('v2.admin.site.setting.remove.file', ['filename' => $site->homepage_mobile_ad, 'type' => 'homepage_mobile_ad']) }}"
                                                class="bg-red-500 p-1 px-2 text-white rounded-md btnRemoveFile">Remove</a>
                                        @endcan
                                    @endif
                                </span>
                                @error('image')
                                    <span class="text-sm text-red-500">*{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- Image Field -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="image">Loader Ad
                                    (450X450px)
                                </label>
                                <input
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm image @error('image') border-red-500 @enderror"
                                    id="image" type="file" name="loader_ad">

                                <span class="flex items-center gap-4">
                                    <img class="view-image mt-2"
                                        src="{{ $site->loader_ad ? asset('uploads/site/' . $site->loader_ad) : '' }}"
                                        style="max-height: 100px; width: auto;">
                                    @if ($site->loader_ad)
                                        @can('update sitesetting')
                                            <a href="{{ route('v2.admin.site.setting.remove.file', ['filename' => $site->loader_ad, 'type' => 'loader_ad']) }}"
                                                class="bg-red-500 p-1 px-2 text-white rounded-md btnRemoveFile">Remove</a>
                                        @endcan
                                    @endif
                                </span>
                                @error('image')
                                    <span class="text-sm text-red-500">*{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- Image Field -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="image">Desktop Modify Ad
                                    (950X80px)
                                </label>
                                <input
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm image @error('image') border-red-500 @enderror"
                                    id="image" type="file" name="desktop_modify_ad">

                                <span class="flex items-center gap-4">
                                    <img class="view-image mt-2"
                                        src="{{ $site->desktop_modify_ad ? asset('uploads/site/' . $site->desktop_modify_ad) : '' }}"
                                        style="max-height: 100px; width: auto;">
                                    @if ($site->desktop_modify_ad)
                                        @can('update sitesetting')
                                            <a href="{{ route('v2.admin.site.setting.remove.file', ['filename' => $site->desktop_modify_ad, 'type' => 'desktop_modify_ad']) }}"
                                                class="bg-red-500 p-1 px-2 text-white rounded-md btnRemoveFile">Remove</a>
                                        @endcan
                                    @endif
                                </span>
                                @error('image')
                                    <span class="text-sm text-red-500">*{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <!-- Image Field -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="image">Homepage Popup
                                </label>
                                <input
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm image @error('image') border-red-500 @enderror"
                                    id="image" type="file" name="homepage_popup">

                                <span class="flex items-center gap-4">
                                    <img class="view-image mt-2"
                                        src="{{ $site->homepage_popup ? asset('uploads/site/' . $site->homepage_popup) : '' }}"
                                        style="max-height: 100px; width: auto;">
                                    @if ($site->homepage_popup)
                                        <a href="{{ route('v2.admin.site.setting.remove.file', ['filename' => $site->homepage_popup, 'type' => 'homepage_popup']) }}"
                                            class="bg-red-500 p-1 px-2 text-white rounded-md btnRemoveFile">Remove</a>
                                    @endif
                                </span>

                                @error('image')
                                    <span class="text-sm text-red-500">*{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}

                        <!-- Submit Button -->
                    </div>
                    <div class="mt-5">
                        @can('update sitesetting')
                            <button
                                class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none"
                                type="submit">
                                Save Changes
                            </button>
                        @endcan
                    </div>


                </form>

            </div>

        </div>
    </div>

    <script>
        $(".image").change(function() {
            input = this;
            var nthis = $(this);
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    nthis.siblings('span').find('.view-image').attr('src', e.target.result);
                    nthis.siblings('span').find('a').hide();
                }
                reader.readAsDataURL(input.files[0]);
            }
        });

        $('.btnRemoveFile').click(function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            Swal.fire({
                title: "Are you sure?",
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = url;
                }
            });
        })
    </script>
@endsection
