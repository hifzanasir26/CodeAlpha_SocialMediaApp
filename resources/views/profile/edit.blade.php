<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Profile Photo Preview -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                <h2 style="font-size:20px; font-weight:bold; margin-bottom:15px;">
                    Profile Photo
                </h2>

                @if(auth()->user()->profile_photo)

                    <img
                        src="{{ asset('profile_photos/' . auth()->user()->profile_photo) }}"
                        width="120"
                        height="120"
                        style="border-radius:50%; object-fit:cover;">

                @endif

            </div>

            <!-- Update Profile Form -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">

                    <form method="POST"
                          action="{{ route('profile.update') }}"
                          enctype="multipart/form-data">

                        @csrf
                        @method('patch')

                        <!-- Name -->
                        <div>
                            <label>Name</label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;">
                        </div>

                        <br>

                        <!-- Email -->
                        <div>
                            <label>Email</label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;">
                        </div>

                        <br>

                        <!-- Profile Photo -->
                        <div>
                            <label>Profile Photo</label>

                            <br><br>

                            <input type="file" name="profile_photo">
                        </div>

                        <br>

                        <button
                            type="submit"
                            style="background:#1877f2; color:white; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;">

                            Save

                        </button>

                    </form>

                </div>
            </div>

            <!-- Update Password -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete User -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>