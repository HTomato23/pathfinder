@props([
    'number' => null,
    'question' => null,
    'name' => null,
])

<div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="reveal p-8 w-full shadow-sm rounded-sm"
    x-data="{ 
         selected: '{{ old($name) }}' || localStorage.getItem('{{ $name }}') || '',
         init() {
             this.$watch('selected', value => {
                 if (value) {
                     localStorage.setItem('{{ $name }}', value);
                 } else {
                     localStorage.removeItem('{{ $name }}');
                 }
                 // Dispatch event whenever selected changes
                 this.$dispatch('answer-changed');
             });
         }
     }">
    <!-- Question Number -->
    <div class="mb-2">
        <span class="text-sm font-semibold text-primary">{{ $number }}</span>
    </div>
    
    <!-- Question Text -->
    <h2 class="text-xl font-medium mb-6">
        {{ $question }}
    </h2>
    
    <!-- Answer Buttons -->
    <div class="flex flex-col gap-3">
        {{ $slot }}
    </div>
    
    <!-- Hidden input to store the selected value -->
    <input type="hidden" name="{{ $name }}" x-model="selected">
    
    <!-- Error Message -->
    @error($name)
        <div class="mt-3 text-error text-sm">
            {{ $message }}
        </div>
    @enderror
</div>