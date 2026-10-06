@props(['message' => null, 'type' => null])

@php
    $messages = [];

    if ($message !== null) {
        $messages[] = ['type' => $type ?? 'success', 'message' => $message];
    } else {
        foreach (['success', 'error'] as $flashType) {
            if (session()->has($flashType)) {
                $messages[] = ['type' => $flashType, 'message' => session($flashType)];
            }
        }

        if ($errors->any()) {
            $messages[] = ['type' => 'error', 'message' => implode(' ', $errors->all())];
        }
    }
@endphp

@foreach ($messages as $flash)
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show"
        x-transition.opacity.duration.300ms role="{{ $flash['type'] === 'error' ? 'alert' : 'status' }}"
        aria-live="{{ $flash['type'] === 'error' ? 'assertive' : 'polite' }}"
        class="mb-6 flex min-h-24 items-center justify-between gap-5 rounded-[20px] border border-[#e3a900] bg-[#fff8db] px-6 py-5 text-amber-700 shadow-sm sm:px-8">
        <div class="flex min-w-0 items-center gap-5">
            <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#b38612] text-white">
                @if ($flash['type'] === 'error')
                    <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-11.5a.75.75 0 0 0-1.5 0v4a.75.75 0 0 0 1.5 0v-4Zm-.75 7.75a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                            clip-rule="evenodd" />
                    </svg>
                @else
                    <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M16.704 5.29a1 1 0 0 1 .006 1.414l-7.2 7.26a1 1 0 0 1-1.42 0l-3.8-3.83a1 1 0 0 1 1.42-1.408l3.09 3.113 6.493-6.543a1 1 0 0 1 1.411-.006Z"
                            clip-rule="evenodd" />
                    </svg>
                @endif
            </span>
            <span class="text-base font-semibold text-[#ad8618] sm:text-lg">{{ $flash['message'] }}</span>
        </div>
        <button type="button" @click="show = false" aria-label="Fermer le message"
            class="shrink-0 text-[#ad8618] transition hover:text-amber-900">
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path
                    d="M5.22 5.22a.75.75 0 0 1 1.06 0L10 8.94l3.72-3.72a.75.75 0 1 1 1.06 1.06L11.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06L10 11.06l-3.72 3.72a.75.75 0 1 1-1.06-1.06L8.94 10 5.22 6.28a.75.75 0 0 1 0-1.06Z" />
            </svg>
        </button>
    </div>
@endforeach
