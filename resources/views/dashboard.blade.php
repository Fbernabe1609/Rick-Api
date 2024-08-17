<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-gray-100">Characters</h1>

            <form method="GET" action="{{ route('characters.index') }}" class="flex space-x-2">
                <input type="text" name="name" placeholder="Name" value="{{ $filters['name'] ?? '' }}"
                       class="border rounded px-8 py-2">
                <select name="status" class="border rounded px-8 py-2">
                    <option value="">Status</option>
                    <option
                        value="alive" {{ (isset($filters['status']) && $filters['status'] == 'alive') ? 'selected' : '' }}>
                        Alive
                    </option>
                    <option
                        value="dead" {{ (isset($filters['status']) && $filters['status'] == 'dead') ? 'selected' : '' }}>
                        Dead
                    </option>
                    <option
                        value="unknown" {{ (isset($filters['status']) && $filters['status'] == 'unknown') ? 'selected' : '' }}>
                        Unknown
                    </option>
                </select>
                <select name="species" class="border rounded px-8 py-2">
                    <option value="">Species</option>
                    <option
                        value="human" {{ (isset($filters['species']) && $filters['species'] == 'human') ? 'selected' : '' }}>
                        Human
                    </option>
                    <option
                        value="alien" {{ (isset($filters['species']) && $filters['species'] == 'alien') ? 'selected' : '' }}>
                        Alien
                    </option>
                </select>
                <select name="gender" class="border rounded px-8 py-2">
                    <option value="">Gender</option>
                    <option
                        value="male" {{ (isset($filters['gender']) && $filters['gender'] == 'male') ? 'selected' : '' }}>
                        Male
                    </option>
                    <option
                        value="female" {{ (isset($filters['gender']) && $filters['gender'] == 'female') ? 'selected' : '' }}>
                        Female
                    </option>
                    <option
                        value="genderless" {{ (isset($filters['gender']) && $filters['gender'] == 'genderless') ? 'selected' : '' }}>
                        Genderless
                    </option>
                    <option
                        value="unknown" {{ (isset($filters['gender']) && $filters['gender'] == 'unknown') ? 'selected' : '' }}>
                        Unknown
                    </option>
                </select>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Filter</button>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($characters as $character)
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                    <img src="{{ $character['image'] }}" alt="{{ $character['name'] }}"
                         class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">{{ $character['name'] }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">Status: {{ $character['status'] }}</p>
                        <p class="text-gray-600 dark:text-gray-400">Species: {{ $character['species'] }}</p>
                        <p class="text-gray-600 dark:text-gray-400">Gender: {{ $character['gender'] }}</p>
                        <button data-id="{{ $character['id'] }}"
                                class="toggle-favorite mt-4 w-full px-4 py-2 text-white {{ in_array($character['id'], $favorites) ? 'bg-red-500' : 'bg-blue-500' }} rounded">
                            {{ in_array($character['id'], $favorites) ? 'Remove from Favorites' : 'Add to Favorites' }}
                        </button>
                    </div>
                </div>
            @empty
                <p class="text-gray-600 dark:text-gray-400">No characters found.</p>
            @endforelse
        </div>

        @if($pagination)
            <div class="mt-6 flex justify-between">
                @if ($pagination['prevPage'])
                    <a href="{{ route('characters.index', array_merge($filters, ['page' => $pagination['prevPage']])) }}"
                       class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded">Previous</a>
                @else
                    <span
                        class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded opacity-50 cursor-not-allowed">Previous</span>
                @endif

                @if ($pagination['nextPage'])
                    <a href="{{ route('characters.index', array_merge($filters, ['page' => $pagination['nextPage']])) }}"
                       class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded">Next</a>
                @else
                    <span
                        class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded opacity-50 cursor-not-allowed">Next</span>
                @endif
            </div>
        @endif
    </div>

    <script>
        document.querySelectorAll('.toggle-favorite').forEach(button => {
            button.addEventListener('click', function () {
                const characterId = this.getAttribute('data-id');
                const button = this;

                axios.post(`{{ url('/characters/favorite/') }}/${characterId}`, {}, {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => {
                        if (response.data.status === 'added') {
                            button.classList.remove('bg-blue-500');
                            button.classList.add('bg-red-500');
                            button.textContent = 'Remove from Favorites';
                        } else if (response.data.status === 'removed') {
                            button.classList.remove('bg-red-500');
                            button.classList.add('bg-blue-500');
                            button.textContent = 'Add to Favorites';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
</x-app-layout>
