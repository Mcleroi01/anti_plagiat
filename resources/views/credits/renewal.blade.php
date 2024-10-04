<!-- resources/views/credits/renewal.blade.php -->

<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Renouveler les crédits pour {{ $user->name }}</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('credits.renouveler.submit') }}" method="POST" class="space-y-4">
        @csrf

        <input type="hidden" name="user_id" value="{{ $user->id }}">

        <div>
            <label for="credits" class="block font-medium text-sm text-gray-700">Nombre de crédits</label>
            <input type="number" name="credits" id="credits" min="1" value="{{ $credit->monthly_limit ?? 0 }}" required class="form-input mt-1 block w-full" placeholder="Entrez le nombre de crédits">
            @error('credits')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Renouveler les crédits</button>
        </div>
    </form>
</x-app-layout>
