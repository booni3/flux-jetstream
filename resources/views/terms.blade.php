<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0 bg-zinc-50">
        <div class="mb-6 mt-6">
            <x-application-logo class="h-12 w-auto" />
        </div>

        <div class="w-full sm:max-w-2xl p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
            {!! $terms !!}
        </div>
    </div>
</x-guest-layout>
