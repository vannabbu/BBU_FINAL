@props([
    'title' => 'ផ្ទាំងគ្រប់គ្រង',
    'navigation' => [],
    'doctor' => [],
])

<x-layout.app-layout :title="$title" :navigation="$navigation" :doctor="$doctor">
    {{ $slot }}
</x-layout.app-layout>
