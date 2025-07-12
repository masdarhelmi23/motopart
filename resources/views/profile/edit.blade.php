<x-app-layout>
    <x-slot name="header">
        {{-- Perubahan di sini: 'text-gray-800' menjadi 'text-black' --}}
        <h2 class="font-semibold text-xl text-black dark:text-black leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    {{-- Div terluar yang akan membuat latar belakang gelap full width dan full height --}}
    {{-- Perubahan utama ada di sini: bg-gray-900 dan min-h-screen dipindahkan/ditambahkan ke div ini --}}
    <div class="bg-gray-900 min-h-screen">
        {{-- Div ini mempertahankan padding vertikal dan sentrisitas konten --}}
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                {{-- Kartu Profile Information --}}
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        {{-- Ini adalah partial view update-profile-information-form yang Anda edit sebelumnya --}}
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                {{-- Kartu Update Password --}}
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                {{-- Kartu Delete Account --}}
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>