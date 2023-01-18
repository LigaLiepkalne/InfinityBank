@props(['errors'])

@if ($errors->any())

    <div class="mx-auto text-left {{ $attributes }}">
        <div class="font-medium text-red-600">
            {{ __('Whoops! Something went wrong.') }}
        </div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->getMessages() as $key => $error)
                    <li>{{ ucfirst($key) }}: {{ implode(', ', $error) }}</li>
            @endforeach
        </ul>
    </div>

@endif
