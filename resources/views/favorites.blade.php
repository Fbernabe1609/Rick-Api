<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-gray-100">Favorite Characters</h1>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($characters as $character)
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                    <img src="{{ $character['image'] }}" alt="{{ $character['name'] }}"
                         class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">{{ $character['name'] }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">Status: {{ $character['status'] }}</p>
                        <p class="text-gray-600 dark:text-gray-400">Species: {{ $character['species'] }}</p>
                        <p class="text-gray-600 dark:text-gray-400">Gender: {{ $character['gender'] }}</p>
                        <button data-id="{{ $character['id'] }}"
                                class="remove-favorite mt-4 w-full px-4 py-2 text-white bg-red-500 rounded">
                            Remove from Favorites
                        </button>
                    </div>
                </div>
            @endforeach

            @if (count($characters) === 0)
                <div class="col-span-full text-center text-gray-500">
                    No favorite characters found.
                </div>
            @endif
        </div>
    </div>

    <script>
        document.querySelectorAll('.remove-favorite').forEach(button => {
            button.addEventListener('click', function () {
                const characterId = this.getAttribute('data-id');

                axios.post(`{{ url('/characters/favorite/') }}/${characterId}`, {}, {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => {
                        if (response.data.status === 'removed') {
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
</x-app-layout>
