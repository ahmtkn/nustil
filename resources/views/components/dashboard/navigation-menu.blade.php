@inject('route',\Illuminate\Support\Facades\Route::class)


<nav>
    <ul>
        <x-dashboard.sidebar-link :href="route('dashboard')" :active="$route::is('dashboard')">
            <div class="link-icon"><i icon-name="home"></i></div>
            <div class="link-text">{{__('Home')}}</div>
        </x-dashboard.sidebar-link>
        @can('users.read')
            <x-dashboard.sidebar-link :href="route('dashboard.users.index')" :active="$route::is('dashboard.users.*')">
                <div class="link-icon"><i icon-name="users"></i></div>
                <div class="link-text">{{__('Users')}}</div>
            </x-dashboard.sidebar-link>
        @endcan
        @can('menus.read')
            <x-dashboard.sidebar-link :href="route('dashboard.menus.index')" :active="$route::is('dashboard.menus.*')">
                <div class="link-icon"><i icon-name="menu"></i></div>
                <div class="link-text">{{__('Menus')}}</div>
            </x-dashboard.sidebar-link>
            <x-dashboard.sidebar-link :href="route('dashboard.slides.index')"
                                      :active="$route::is('dashboard.slides.*')">
                <div class="link-icon"><i icon-name="image"></i></div>
                <div class="link-text">{{__('Slides')}}</div>
            </x-dashboard.sidebar-link>
        @endcan
        <li class="divider animate-y"></li>
        @can('categories.read')
            <x-dashboard.sidebar-link :href="route('dashboard.categories.index')"
                                      :active="$route::is('dashboard.categories.*')">
                <div class="link-icon"><i icon-name="layout-grid"></i></div>
                <div class="link-text">{{__('Categories')}}</div>
            </x-dashboard.sidebar-link>
        @endcan
        @can('products.read')
            <x-dashboard.sidebar-link :href="route('dashboard.products.index')"
                                      :active="$route::is('dashboard.products.*')">
                <div class="link-icon"><i icon-name="sprout"></i></div>
                <div class="link-text">{{__('Products')}}</div>
            </x-dashboard.sidebar-link>
            <x-dashboard.sidebar-link href="{{route('dashboard.ingredients.index')}}"
                                      :active="$route::is('dashboard.ingredients.*')">
                <div class="link-icon"><i icon-name="puzzle"></i></div>
                <div class="link-text">{{__('dashboard.Ingredients')}}</div>
            </x-dashboard.sidebar-link>
        @endcan
        <li class="divider animate-y"></li>

        @can('categories.read')
            <x-dashboard.sidebar-link :href="route('dashboard.blog.categories.index')"
                                      :active="$route::is('dashboard.blog.categories.*')">
                <div class="link-icon"><i icon-name="layout-grid"></i></div>
                <div class="link-text">{{__('Blog Categories')}}</div>
            </x-dashboard.sidebar-link>
        @endcan
        @can('blogs.read')
            <x-dashboard.sidebar-link :href="route('dashboard.blog.posts.index')"
                                      :active="$route::is('dashboard.blog.posts.*')">
                <div class="link-icon"><i icon-name="file-text"></i></div>
                <div class="link-text">{{__('Blog Posts')}}</div>
            </x-dashboard.sidebar-link>
        @endcan
        <x-dashboard.sidebar-link :href="route('dashboard.comments.index')"
                                  :active="$route::is('dashboard.comments.*')"
                                  :indicated="App\Models\Comment::pending()->exists()">
            <div class="link-icon"><i icon-name="message-square"></i></div>
            <div class="link-text">{{__('Comments')}}</div>
        </x-dashboard.sidebar-link>
        @can('settings.update')
            <li class="divider animate-y"></li>
            <x-dashboard.sidebar-link :href="route('dashboard.settings.index')"
                                      :active="$route::is('dashboard.settings.*')">
                <div class="link-icon"><i icon-name="settings"></i></div>
                <div class="link-text">{{__('Settings')}}</div>
            </x-dashboard.sidebar-link>
        @endcan
    </ul>
</nav>


