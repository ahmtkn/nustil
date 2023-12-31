@props(['title'])
@php($title = $title??__('Dialog'))
<div
    {{$attributes->merge(['class' => "hidden overflow-y-auto backdrop-blur-[1px] transition-all overflow-x-hidden z-[5000] fixed top-0 right-0 left-0 w-full md:inset-0 md:h-full"])}} tabindex="-1"
    aria-hidden="true">

    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto z-[5000] animate-y">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-700">
            <!-- Modal header -->
            @isset($heading)
                <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        {{$heading}}
                    </h3>
                    <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="{{$attributes->get('id')}}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            @endisset
            <!-- Modal body -->
            <div class="p-6 space-y-6">
                {{$body ?? ''}}
            </div>
            <!-- Modal footer -->
            @isset($footer)
                <div
                    class="flex items-center justify-between p-4 rounded-b border-t border-gray-200 dark:border-gray-600">
                    {{$footer ?? ''}}
                </div>
            @endisset
        </div>
    </div>

</div>
