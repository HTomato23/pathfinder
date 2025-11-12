@props([
    'personality_start_line' => false,
    'personality_check' => false,
    'personality_end_line' => false,
    'softskill_start_line' => false,
    'softskill_check' => false,
    'softskill_end_line' => false,
    'academic_start_line' => false,
    'academic_check' => false,
    'academic_end_line' => false,
    'experience_start_line' => false,
    'experience_check' => false,
    'experience_end_line' => false,
    'skill_start_line' => false,
    'skill_check' => false,
])

@php
    // Convert string 'true'/'false' to actual boolean
    $personality_start_line = filter_var($personality_start_line, FILTER_VALIDATE_BOOLEAN);
    $personality_check = filter_var($personality_check, FILTER_VALIDATE_BOOLEAN);
    $personality_end_line = filter_var($personality_end_line, FILTER_VALIDATE_BOOLEAN);
    $softskill_start_line = filter_var($softskill_start_line, FILTER_VALIDATE_BOOLEAN);
    $softskill_check = filter_var($softskill_check, FILTER_VALIDATE_BOOLEAN);
    $softskill_end_line = filter_var($softskill_end_line, FILTER_VALIDATE_BOOLEAN);
    $academic_start_line = filter_var($academic_start_line, FILTER_VALIDATE_BOOLEAN);
    $academic_check = filter_var($academic_check, FILTER_VALIDATE_BOOLEAN);
    $academic_end_line = filter_var($academic_end_line, FILTER_VALIDATE_BOOLEAN);
    $experience_start_line = filter_var($experience_start_line, FILTER_VALIDATE_BOOLEAN);
    $experience_check = filter_var($experience_check, FILTER_VALIDATE_BOOLEAN);
    $experience_end_line = filter_var($experience_end_line, FILTER_VALIDATE_BOOLEAN);
    $skill_start_line = filter_var($skill_start_line , FILTER_VALIDATE_BOOLEAN);
    $skill_check = filter_var($skill_check, FILTER_VALIDATE_BOOLEAN);
@endphp

<ul class="timeline timeline-vertical flex-1">
    {{-- Start --}}
    <li class="flex-1">
        <div class="timeline-start timeline-box">Start</div>
        <div class="timeline-middle">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-success h-5 w-5">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
            </svg>
        </div>
        <hr class="flex-1 {{ $personality_start_line ? 'bg-success' : '' }}" />
    </li>

    {{-- Personality Test --}}
    <li class="flex-1">
        <hr class="flex-1 {{ $personality_start_line ? 'bg-success' : '' }}" />
        <div class="timeline-end timeline-box">Personality Test</div>
        <div class="timeline-middle {{ $personality_check ? 'text-success' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5"> 
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
            </svg>
        </div>
        <hr class="flex-1 {{ $personality_end_line ? 'bg-success' : '' }}" />
    </li>

    {{-- Soft Skill Test --}}
    <li class="flex-1">
        <hr class="flex-1 {{ $softskill_start_line ? 'bg-success' : '' }}" />
        <div class="timeline-middle {{ $softskill_check ? 'text-success' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="timeline-start timeline-box">Soft Skills Test</div>
        <hr class="flex-1 {{ $softskill_end_line ? 'bg-success' : '' }}" />
    </li>

    {{-- Academic Performance --}}
    <li class="flex-1">
        <hr class="flex-1 {{ $academic_start_line ? 'bg-success' : '' }}" />
        <div class="timeline-middle {{ $academic_check ? 'text-success' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="timeline-end timeline-box">Academic</div>
        <hr class="flex-1 {{ $academic_end_line ? 'bg-success' : '' }}" />
    </li>

    {{-- Personal Experience --}}
    <li class="flex-1">
        <hr class="flex-1 {{ $experience_start_line ? 'bg-success' : '' }}" />
        <div class="timeline-start timeline-box">Personal Experience</div>
        <div class="timeline-middle {{ $experience_check ? 'text-success' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
            </svg>
        </div>
        <hr class="flex-1 {{ $experience_end_line ? 'bg-success' : '' }}" />
    </li>

    {{-- Practical Test --}}
    <li class="flex-1">
        <hr class="flex-1 {{ $skill_start_line ? 'bg-success' : '' }}"  />
        <div class="timeline-end timeline-box">Skill Scale</div>
        <div class="timeline-middle {{ $skill_check ? 'text-success' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
            </svg>
        </div>
    </li>
</ul>