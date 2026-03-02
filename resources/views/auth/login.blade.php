<x-guest-layout :hide-header="true">
    <div class="min-h-screen flex items-center justify-center bg-white">
        <div class="max-w-md w-full bg-white/95 backdrop-blur-lg rounded-3xl shadow-2xl overflow-hidden">
            <!-- Header with logo and title -->
            <div class="flex flex-col items-center py-6 bg-emerald-600">
                <div class="bg-white rounded-md p-2 mb-2">
                    <img src="{{ asset('images/logo.png') }}" alt="RS Azra" class="h-16 w-auto">
                </div>
                <h1 class="text-2xl font-bold text-white">Sistem Pengajuan Transportasi</h1>
                <p class="text-sm text-white/80">RS Azra</p>
            </div>

            <form method="POST" action="{{ route('login.store') }}" class="p-8 space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-emerald-900">Nama pengguna</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        class="mt-1 w-full rounded-lg border border-emerald-300 bg-emerald-50 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-150"
                        placeholder="Masukkan nama"
                    >
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-emerald-900">Kata sandi</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        class="mt-1 w-full rounded-lg border border-emerald-300 bg-emerald-50 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-150"
                        placeholder="Masukkan kata sandi"
                    >
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center text-sm text-emerald-900">
                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                            class="h-4 w-4 text-emerald-600 border-emerald-300 rounded focus:ring-emerald-500"
                        >
                        <span class="ml-2">Ingat saya</span>
                    </label>
                    <a href="#" class="text-sm text-emerald-600 hover:underline">Lupa kata sandi?</a>
                </div>

                <button
                    type="submit"
                    class="w-full py-2.5 rounded-lg bg-gradient-to-r from-emerald-600 to-teal-500 text-white font-semibold hover:from-emerald-700 hover:to-teal-600 transition duration-150 shadow-md"
                >
                    Masuk
                </button>

                <p class="text-xs text-center text-emerald-800/80">
                    Akun demo: <span class="font-semibold">Test User</span> / <span class="font-semibold">password</span>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>