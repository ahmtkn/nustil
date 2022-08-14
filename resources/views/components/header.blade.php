<header class="border-b border-slate-300 bg-slate-50 z-[5000] fixed w-full top-0" x-data="{menuExpanded:false}">
    <div class="flex items-center justify-between p-4 container mx-auto">
        <div class="-animate-x select-none">
            <a href="{{route('landing')}}">
                <img src="{{asset('img/logos/logo-dark.png')}}" class="h-10 lg:h-12">
            </a>
        </div>
        <div class="block lg:hidden">
            <button @click="menuExpanded=!menuExpanded"
                    class="cursor-pointer flex items-center justify-center text-4xl z-[30]">
                <ion-icon name="menu-outline"></ion-icon>
            </button>
            <div class="fixed inset-y-0 transform right-0 w-full max-w-[75vw] md:max-w-[50vw] bg-white shadow-lg p-4"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-x-1"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 -translate-x-1"
                 @click.away="menuExpanded=false"
                 x-show="menuExpanded"
                 style="display:none;">
                <div class="flex items-center justify-between mb-4">
                    <x-language-switch align="left"/>

                    <button @click="menuExpanded=!menuExpanded"
                            class="cursor-pointer flex items-center justify-center text-4xl z-[30]">
                        <ion-icon name="close-outline"
                                  class="text-slate-500 hover:text-slate-800 transition-all duration-300"></ion-icon>
                    </button>
                </div>
                <div class="text-center z-10">
                    @menu('main')
                </div>
            </div>
        </div>
        <div class="hidden lg:flex items-center gap-4">
            @menu('main')
            {{--            <x-language-selector/>--}}
            <x-language-switch/>
        </div>
    </div>
</header>
