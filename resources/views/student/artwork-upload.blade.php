@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-slate-100 via-white to-slate-200 py-8 sm:py-16">
<div class="max-w-3xl mx-auto px-4 sm:px-6">

    <!-- Back Button -->
    <div class="mb-5 sm:mb-6">
        <a href="{{ route('student.dashboard') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Dashboard
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700 shadow-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700 shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Card -->
    <div class="backdrop-blur-xl bg-white/80 border border-white/40 shadow-2xl rounded-3xl p-6 sm:p-10">

        <div class="mb-7 sm:mb-10">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">
                Submit Artwork
            </h1>
            <p class="text-slate-500 mt-2 text-sm">
                Choose a competition and upload your creative work.
            </p>
        </div>

        <form method="POST" action="{{ route('student.artworks.store') }}"
              enctype="multipart/form-data" class="space-y-6 sm:space-y-8">
            @csrf

            <!-- Competition -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Competition</label>
                <select name="competition_id" id="competitionSelect" required
                        class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm
                               focus:outline-none focus:ring-2 focus:ring-slate-900 transition">
                    <option value="">-- Select a competition --</option>
                    @foreach ($competitions as $competition)
                        @if(now()->lte($competition->deadline))
                            <option value="{{ $competition->id }}"
                                    data-fee="{{ $competition->fee }}"
                                    data-paid="{{ in_array($competition->id, $paidCompetitionIds ?? []) ? 'true' : 'false' }}"
                                    {{ (isset($selectedCompetition) && $selectedCompetition == $competition->id) ? 'selected' : '' }}>
                                {{ $competition->title }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('competition_id')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Payment Box -->
            <div id="paymentBox" class="text-sm font-medium"></div>

            <!-- Artwork Fields -->
            <div id="artworkFields" class="space-y-5 sm:space-y-6" style="display:none;">

                <!-- Title -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Artwork Title</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                           placeholder="Sunset Over the Mountains" required
                           class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-slate-900 transition">
                    @error('title')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Description</label>
                    <textarea name="description" rows="4"
                              placeholder="Describe your artwork in detail (minimum 50 characters)..."
                              required
                              class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm
                                     focus:outline-none focus:ring-2 focus:ring-slate-900 transition">{{ old('description') }}</textarea>
                    <p class="text-xs text-slate-400 mt-2">Minimum 50 characters required</p>
                    @error('description')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Art Style -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Art Style</label>
                    <select name="art_style" required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-slate-900 transition">
                        <option value="">-- Select art style --</option>
                        <option value="Sketching" {{ old('art_style')=='Sketching' ? 'selected' : '' }}>Sketching</option>
                        <option value="Watercolour" {{ old('art_style')=='Watercolour' ? 'selected' : '' }}>Watercolour</option>
                        <option value="Digital" {{ old('art_style')=='Digital' ? 'selected' : '' }}>Digital</option>
                        <option value="Oil Pastels" {{ old('art_style')=='Oil Pastels' ? 'selected' : '' }}>Oil Pastels</option>
                        <option value="Acrylics" {{ old('art_style')=='Acrylics' ? 'selected' : '' }}>Acrylics</option>
                        <option value="Madhubani" {{ old('art_style')=='Madhubani' ? 'selected' : '' }}>Madhubani</option>
                        <option value="Warli" {{ old('art_style')=='Warli' ? 'selected' : '' }}>Warli</option>
                    </select>
                    @error('art_style')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Upload -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Upload Image</label>
                    <input type="file" name="image" required
                           accept="image/png, image/jpeg, image/jpg, image/webp"
                           class="w-full rounded-2xl border border-dashed border-slate-300
                                  px-4 py-5 sm:py-6 bg-slate-50 text-sm
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-xl file:border-0
                                  file:bg-slate-900 file:text-white
                                  hover:file:bg-black transition">
                    <p class="text-xs text-slate-500 mt-2">Upload your artwork (JPG & PNG • Max 5MB)</p>
                    @error('image')
                        <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit"
                        class="w-full py-3 rounded-2xl bg-slate-900 text-white
                               font-semibold hover:bg-black transition shadow-lg text-sm sm:text-base">
                    Submit Artwork
                </button>

            </div>
        </form>
    </div>
</div>
</div>

<script>
function updateSubmissionUI() {
    const select = document.getElementById('competitionSelect');
    const selectedOption = select.options[select.selectedIndex];
    const competitionId = selectedOption.value;
    const fee = selectedOption.getAttribute('data-fee');
    const hasPaid = selectedOption.getAttribute('data-paid') === 'true';
    const paymentBox = document.getElementById('paymentBox');
    const artworkFields = document.getElementById('artworkFields');

    paymentBox.innerHTML = "";
    artworkFields.style.display = "none";

    if (!competitionId) return;

    if (!fee || parseFloat(fee) === 0) {
        paymentBox.innerHTML = "<div class='rounded-2xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-emerald-700 text-sm'>Free Entry — You can submit artwork now.</div>";
        artworkFields.style.display = "block";
        return;
    }

    if (hasPaid) {
        paymentBox.innerHTML = "<div class='rounded-2xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-emerald-700 text-sm'>You have already paid for this competition.</div>";
        artworkFields.style.display = "block";
        return;
    }

    paymentBox.innerHTML = `
        <div class="rounded-2xl bg-red-50 border border-red-200 px-4 py-4 text-red-700 text-sm">
            Paid Competition — Payment required before submission.
            <div class="mt-4">
                <a href="/student/checkout/${competitionId}"
                   class="inline-block bg-slate-900 hover:bg-black text-white font-semibold py-2 px-6 rounded-xl transition shadow text-sm">
                    Pay ₹${fee} to Unlock
                </a>
            </div>
        </div>
    `;
}

document.getElementById('competitionSelect').addEventListener('change', updateSubmissionUI);
window.onload = updateSubmissionUI;
</script>

@endsection