@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-6 sm:mt-12 px-4 sm:px-6">
    <div class="bg-white shadow-xl rounded-3xl p-6 sm:p-12 border border-gray-100">

        <!-- Page Header -->
        <div class="mb-8 sm:mb-10 border-b border-gray-100 pb-5 sm:pb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div>
                <h1 class="text-xl sm:text-3xl font-bold text-gray-900">
                    Certificate Template Settings
                </h1>
                <p class="text-gray-500 mt-2 text-sm">
                    Upload your official certificate background and academy signature.
                </p>
            </div>

            <!-- Back Button -->
            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center gap-2 px-4 sm:px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold transition self-start sm:self-auto">
                ← Back to Dashboard
            </a>

        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-gray-100 border border-gray-200 text-gray-800 px-5 py-4 rounded-xl mb-6 sm:mb-8 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Validation Errors -->
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl mb-6 sm:mb-8">
                <strong class="block mb-2 text-sm">Something went wrong:</strong>
                <ul class="list-disc ml-5 text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>
                            @if(str_contains($error, 'may not be greater'))
                                Uploaded file must not be larger than 5 MB.
                            @else
                                {{ $error }}
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('admin.templates.update') }}" enctype="multipart/form-data">
            @csrf

            <!-- Certificate Background Upload -->
            <div class="mb-10 sm:mb-12">
                <h2 class="text-base sm:text-lg font-semibold text-gray-900 mb-4">
                    Certificate Background Template
                </h2>

                <!-- Preview -->
                <div class="mb-5 sm:mb-6">
                    <p class="text-sm text-gray-500 mb-3">Current Template Preview:</p>
                    <div class="border border-gray-200 rounded-2xl overflow-hidden shadow-sm bg-gray-50">
                        <img
                            src="{{ asset('storage/templates/cert_template.png') }}"
                            alt="Certificate Template"
                            class="w-full object-cover"
                            onerror="this.style.display='none';"
                        >
                    </div>
                </div>

                <!-- Upload -->
                <div class="p-5 sm:p-6 bg-gray-50 border-2 border-dashed rounded-2xl
                    {{ $errors->has('certificate_bg') ? 'border-red-300 bg-red-50' : 'border-gray-300' }}">

                    <label class="block font-medium text-gray-700 mb-3 text-sm">
                        Upload New Background (PNG / JPG)
                    </label>

                    <input
                        type="file"
                        name="certificate_bg"
                        accept="image/png, image/jpeg"
                        class="block w-full text-sm text-gray-700
                               file:mr-4 file:py-2 file:px-4 sm:file:py-2.5 sm:file:px-5
                               file:rounded-xl file:border
                               file:border-gray-300
                               file:text-sm file:font-semibold
                               file:bg-white file:text-gray-900
                               hover:file:bg-gray-100 transition"
                    >

                    <p class="text-xs text-gray-500 mt-3">
                        Required ratio: <b>A4 Landscape</b> (1123×794 px or larger). Maximum file size: <b>5 MB</b>.
                    </p>

                    @error('certificate_bg')
                        <p class="mt-3 text-sm text-red-600 font-medium">
                            @if(str_contains($message, 'may not be greater'))
                                Certificate background must not be larger than 5 MB.
                            @else
                                {{ $message }}
                            @endif
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Signature Upload -->
            <div class="mb-10 sm:mb-12">
                <h2 class="text-base sm:text-lg font-semibold text-gray-900 mb-4">
                    Academy Signature (Optional)
                </h2>

                <!-- Preview -->
                <div class="mb-5 sm:mb-6">
                    <p class="text-sm text-gray-500 mb-3">Current Signature Preview:</p>
                    <div class="border border-gray-200 rounded-2xl p-4 sm:p-5 bg-gray-50 shadow-sm inline-block">
                        <img
                            src="{{ asset('storage/templates/signature.png') }}"
                            alt="Signature"
                            class="h-16 sm:h-20 object-contain"
                            onerror="this.style.display='none';"
                        >
                    </div>
                </div>

                <!-- Upload -->
                <div class="p-5 sm:p-6 bg-gray-50 border-2 border-dashed rounded-2xl
                    {{ $errors->has('signature') ? 'border-red-300 bg-red-50' : 'border-gray-300' }}">

                    <label class="block font-medium text-gray-700 mb-3 text-sm">
                        Upload Signature (PNG only)
                    </label>

                    <input
                        type="file"
                        name="signature"
                        accept="image/png"
                        class="block w-full text-sm text-gray-700
                               file:mr-4 file:py-2 file:px-4 sm:file:py-2.5 sm:file:px-5
                               file:rounded-xl file:border
                               file:border-gray-300
                               file:text-sm file:font-semibold
                               file:bg-white file:text-gray-900
                               hover:file:bg-gray-100 transition"
                    >

                    <p class="text-xs text-gray-500 mt-3">
                        Transparent PNG works best. Maximum file size: <b>5 MB</b>.
                    </p>

                    @error('signature')
                        <p class="mt-3 text-sm text-red-600 font-medium">
                            @if(str_contains($message, 'may not be greater'))
                                Signature file must not be larger than 5 MB.
                            @else
                                {{ $message }}
                            @endif
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-gray-900 hover:bg-black text-white font-semibold py-3 sm:py-3.5 rounded-xl shadow-sm hover:shadow-lg transition duration-200 text-sm sm:text-base">
                Save Templates
            </button>

        </form>
    </div>
</div>
@endsection