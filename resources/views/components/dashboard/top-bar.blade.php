<div class="flex items-center justify-between border-b pr-4 py-2 mx-4">
    <div class="animate-x flex items-center gap-4">
        @if(!Route::is('dashboard'))
            <a href="javascript:history.back();" class="animate-x text-emerald-800 hover:text-emerald-900 border-r px-4"
               data-tooltip-target="goBack" data-tooltip-placement="bottom">
                <i icon-name="arrow-left"></i>
            </a>
            <x-tooltip id="goBack">{{__('Back')}}</x-tooltip>
        @endif
        <div class="animate-x">
            {{$slot}}
        </div>
    </div>
    <div class="lg:flex items-center justify-end hidden text-right">

        <div class="animate-x order-3 px-4 border-l text-slate-600 hover:text-red-500"
             data-tooltip-target="logoutTooltip" data-tooltip-placement="bottom">
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <a href="{{route('logout')}}"
                   onclick="event.preventDefault();
                                                this.closest('form').submit();">
                    <i icon-name="log-out"></i>
                </a>
            </form>
        </div>
        <a href="{{route('landing')}}" target="_blank"
           class="animate-x text-slate-600 hover:text-emerald-700 border-l order-2 px-4"
           data-tooltip-target="goToSiteTooltip" data-tooltip-placement="bottom">
            <i icon-name="globe-2"></i>
        </a>
        <x-tooltip id="goToSiteTooltip">{{__('Show the site')}}</x-tooltip>
        <x-tooltip id="logoutTooltip">{{__('Logout')}}</x-tooltip>

        <div class="flex flex-col px-2 leading-tight origin-center transform scale-90 order-1 animate-x">
            <a href="{{route('dashboard.users.settings',Auth::user())}}" class="text-sm font-medium">
                {{Auth::user()->name}}
            </a>
            <a href="{{route('dashboard.users.settings',Auth::user())}}" class="opacity-70 text-xs block h-6">
                {{__('Account Settings')}}
            </a>
        </div>

    </div>

</div>
