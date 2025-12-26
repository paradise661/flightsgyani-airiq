@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')
    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div
                    class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
                    <!-- Header -->
                    <div
                        class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                                Activity Logs
                            </h2>
                        </div>
                        <div>
                            {{-- <a class="delete-record px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400"
                                href="{{ route('v2.admin.truncate.activitylog') }}">
                                Delete All
                            </a> --}}
                        </div>
                    </div>
                    <!-- End Header -->
                    <livewire:admin.activitylog />
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '.delete-record', function(e) {
            e.preventDefault();
            let nthis = $(this).attr('href');

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
                    location.href = nthis;
                }
            });
        });
    </script>
@endsection
