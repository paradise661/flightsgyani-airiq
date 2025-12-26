@extends('layouts.user-dashboard')

@section('content')
    <div class="bg-white px-4 py-6 rounded-lg">
        <h4 class="text-2xl font-semibold">General Details</h4>
        <!-- general details form  -->
        <form action="{{ route('change.password') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4 mt-3">
                  <div class="w-full col-span-2 md:col-span-1">
                    <label for="pass" class="block text-sm font-semibold mb-2">Current Password <span class="text-red-600">*</span></label>
                    <input name="current_password" type="password" id="pass" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('current_password') border-red-600  @enderror " placeholder="New Password">
                    @error('current_password')
                      <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="w-full col-span-2 md:col-span-1">
                    <label for="cpass" class="block text-sm font-semibold mb-2">New Password
                      <span class="text-red-600">*</span></label>
                    <input type="password" name="password" id="cpass" 
                    class="@error('password') border-red-600 @enderror py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Password">
                     @error('password')
                      <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="w-full col-span-2 md:col-span-1">
                    <label for="cpass" class="block text-sm font-semibold mb-2">Confirm New Password
                    <span class="text-red-600">*</span></label>
                    <input type="password" name="password_confirmation" id="cpass" 
                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('password_confirmation') border-red-600 @enderror" placeholder="Confirm Password">
                      @error('password_confirmation')
                      <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="w-full col-span-2">
                    <div class="flex justify-end">
                      <button class="bg-primary px-6 py-3 text-white rounded-md">
                        Reset
                      </button>
                    </div>
                  </div>
                </div>
         
        </form>

        <!-- / general details form  -->
    </div>
@endsection
