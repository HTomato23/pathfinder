<x-layout.client title="Personality Test">
    <x-layout.client.client-sidebar></x-layout.client.client-sidebar>
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]">
        <x-layout.client.client-navbar page="Personality Test"></x-layout.client.client-navbar>

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
        <form id="personality-test-form" method="POST" action="{{ route('dashboard.assessment.personality.update') }}">
            @csrf
            @method('PATCH')
            <x-layout.client.client-personality-test :personality_question="$personality_question" :likert_scale="$likert_scale" />
        </form>

        <!-- Cancel Form -->
        <form id="cancel-form" class="hidden" method="POST" action="{{ route('dashboard.assessment.personality.cancel') }}">
            @csrf
        </form>

        <!-- Scroll to Top/Bottom Button -->
        <div x-data="{ 
                atTop: true,
                updatePosition() {
                    this.atTop = window.pageYOffset < 300;
                }
            }" 
            @scroll.window="updatePosition()"
            x-init="updatePosition()"
            class="fab">
            <button 
                type="button" 
                @click="atTop ? window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' }) : window.scrollTo({ top: 0, behavior: 'smooth' })" 
                class="btn btn-lg btn-circle btn-primary">
                <x-heroicon-o-chevron-double-down x-show="atTop" class="w-5 h-5"/>
                <x-heroicon-o-chevron-double-up x-show="!atTop" class="w-5 h-5"/>
            </button>
        </div>
    </main>
</x-layout.client>