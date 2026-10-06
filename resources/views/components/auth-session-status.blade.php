@props(['status'])

@if ($status)
    <x-flash-message :message="$status" />
@endif
