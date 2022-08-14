@if($settings->blog['showSidebar'])
    <div class="lg:col-span-2">
        @if($settings->blog['showLatestPosts'])
            <div class="mb-6 space-y-4">
                <h4 class="font-bold font-sans md:text-lg text-slate-600 animate-y tracking-tight leading-tight mb-4">{{__('Latest')}}</h4>
                @foreach($posts->take(5) as $post)
                    <x-post-card :post="$post" :colspan="true" :sidebar="true"/>
                @endforeach
            </div>
        @endif

        @if($settings->blog['showPopularPosts'])
            <div class="mb-6 space-y-4">
                <h4 class="font-bold font-sans md:text-lg  text-slate-600 animate-y tracking-tight leading-tight mb-4">{{__('Most Popular')}}</h4>
                @foreach($popularPosts as $post)
                    <x-post-card :post="$post" :colspan="true" :sidebar="true"/>
                @endforeach
            </div>
        @endif

        <div class="mb-6">
            <h4 class="font-bold font-sans md:text-lg  text-slate-600 animate-y tracking-tight leading-tight mb-4">{{__('Categories')}}</h4>
            <ul>
                @foreach($categories as $category)
                    @if($category->posts_count)
                        <li class="animate-y mb-2 px-4">
                            <a href="{{route('blog.category',$category)}}"
                               class="flex w-full items-center hover:text-emerald-600 justify-between">
                                <span>{{$category->name}}</span>
                                @if($settings->blog['displayPostCountOnCategory'])
                                    <span class="text-sm text-slate-400">{{$category->posts_count}}</span>
                                @endif
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
@endif
