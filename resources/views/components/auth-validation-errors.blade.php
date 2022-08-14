@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        <div class="font-bold text-lg text-red-600">
            {{ __('Error') }}
        </div>
        <ul class="mt-1 list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
