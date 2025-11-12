<x-layout.client title="Personal Experience">
    <x-layout.client.client-sidebar></x-layout.client.client-sidebar>
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]">
        <x-layout.client.client-navbar page="Personal Experience"></x-layout.client.client-navbar>

        {{-- Success message --}}
        @if (session('success'))
            <div class="fixed bottom-4 right-4 z-[9999] space-y-2 w-[90%] sm:max-w-md">
                <x-ui.alert type="success" message="{{ session('success') }}" class="mb-3" />
            </div>
        @endif

        {{-- Get all errors --}}
        @if ($errors->any())
            <div class="fixed bottom-4 right-4 z-[9999] space-y-2 w-[90%] sm:max-w-md">
                @foreach ($errors->all() as $index => $error)
                    @if ($index < 2)
                        <x-ui.alert type="error" message="{{ $error }}" class="mb-2" />
                    @endif
                @endforeach
                
                @if ($errors->count() > 2)
                    <x-ui.alert type="error" message="And {{ $errors->count() - 2 }} more unanswered..." class="mb-2" />
                @endif
            </div>
        @endif

        <!-- Questions Form -->
        <form id="personal-test-form" method="POST" action="{{ route('dashboard.assessment.personal.update') }}">
            @csrf
            @method('PATCH')
            <x-layout.client.client-personal-experience />
        </form>

        <!-- Cancel Form -->
        <form id="cancel-form" class="hidden" method="POST" action="{{ route('dashboard.assessment.personal.cancel') }}">
            @csrf
        </form>
    </main>

    @if(session('clearStorage'))
        <script>
            // Save items you want to keep
            const itemsToKeep = {
                'theme': localStorage.getItem('theme'),
            };

            // Clear all localStorage
            localStorage.clear();

            // Restore the items you want to keep
            Object.keys(itemsToKeep).forEach(key => {
                if (itemsToKeep[key] !== null) {
                    localStorage.setItem(key, itemsToKeep[key]);
                }
            });
        </script>
    @endif
</x-layout.client>