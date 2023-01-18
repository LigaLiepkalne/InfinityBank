@props(['errors'])

@if ($errors->any())

    <div class="mx-auto text-left {{ $attributes }}">
        <div class="font-medium text-red-600">
            {{ __('Whoops! Something went wrong.') }}
        </div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->getMessages() as $key => $error)
                @if (ucfirst($key) == 'From_account')
                    <li>Pay from account: {{ implode(', ', $error) }}</li>
                @elseif (ucfirst($key) == 'To_account')
                    <li>Beneficiary's account: {{ implode(', ', $error) }}</li>
                @else
                    <li>{{ ucfirst($key) }}: {{ implode(', ', $error) }}</li>
                @endif
            @endforeach
        </ul>
    </div>

@endif

