<div {{ $attributes->merge(['class' => 'rounded-full overflow-hidden h-fit']) }}>
    @if ($user->avatar_path)
        <img class="object-cover object-center aspect-square" src="{{ asset('storage/' . $user->avatar_path) }}"
            alt="{{ $user->name }}" />
    @else
        <div class="flex items-center justify-center bg-red-100">
            <span class="text-2xl font-medium text-red-800 ">
                {{ $user->name[0] }}
            </span>
        </div>
    @endif
</div>
