@unless ($breadcrumbs->isEmpty())
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center text-sm xl:space-x-1">
            @foreach ($breadcrumbs as $breadcrumb)

                @if ($breadcrumb->url && !$loop->last)
                    <li class="inline-flex items-center -animate-x">
                        <a href="{{ $breadcrumb->url }}"
                           class="inline-flex items-center text-sm font-medium text-white opacity-60 hover:opacity-90 transition duration-300 ease-in-out">
                            {{ $breadcrumb->title }}
                        </a>
                    </li>
                @else
                    <li aria-current="page" class="-animate-x">
                        <span
                            class="ml-1 text-sm font-bold text-white md:ml-2">{{ \Illuminate\Support\Str::limit($breadcrumb->title,60) }}</span>
                    </li>
                @endif

                @unless($loop->last)
                    <li class="text-gray-500 px-2 -animate-x">
                        <svg class="w-6 h-6 text-white/60" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </li>
                @endif

            @endforeach
        </ol>
    </nav>
@endunless
