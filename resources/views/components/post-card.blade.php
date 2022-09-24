@props(['post','colspan','sidebar'])
@php($colspan = $colspan ?? false)
@php($sidebar = $sidebar ?? false)
@php($link = route('blog.post',['category'=>$post->categories->first(),'post'=>$post]))
@php($colspanClass = $colspan ? 'xl:col-span-2'.($sidebar?' mb-2 text-xs':'') : '')
<div class="animate-y {{$colspanClass}}">
    <div {{$attributes->merge(['class'=>'bg-white border border-slate-100 shadow-sm hover:shadow-md h-full rounded-xl transform transition-all duration-300 ease-in-out hover:-translate-y-2 '])}}>
        <div
            class="flex @if($colspan && !$sidebar) xl:flex-row @endif @if($sidebar) flex-row @else flex-col @endif items-stretch">
            <a
                href="{{$link}}"
                class="@if($colspan && !$sidebar) xl:rounded-t-none xl:rounded-l-xl xl:w-2/5 sm:h-48 @endif @if($sidebar) rounded-xl m-2 w-10 h-10 sm:w-20 sm:h-20 @else rounded-t-xl @endif relative overflow-hidden object-cover ">
                <img data-src="{{$post->image ? $post->image->url : asset('img/placeholder.png')}}"
                     class="lazy @if($colspan && !$sidebar) xl:rounded-t-none xl:rounded-l-xl @endif w-full h-full @if($colspan || $sidebar) flex-1 @endif object-cover">
            </a>

            <div
                class="p-2 xl:p-3 flex flex-col justify-between @if($colspan || $sidebar) flex-1 @else relative min-h-fit lg:h-40 @endif">
                <div>
                    <div class="flex items-center gap-1 text-xs">
                        @foreach($post->categories->take($colspan ? 10 : 1) as $category)
                            <a href="{{route('blog.category',$category)}}"
                               class="font-bold text-emerald-600 hover:underline">
                                {{$category->name}}
                            </a>
                            @unless($loop->last)
                                <span class="text-slate-400 mx-0.5">•</span>
                            @endunless
                        @endforeach
                    </div>
                    <a href="{{$link}}"
                       class="font-bold tracking-tight @if($colspan && !$sidebar) xl:text-lg @endif">
                        {{\Illuminate\Support\Str::limit($post->title,40)}}
                    </a>
                    <p class="text-slate-500">
                        {!! \Illuminate\Support\Str::limit(strip_tags(Str::markdown($post->body)),$colspan && !$sidebar ? 90:50)!!}
                    </p>
                </div>
                <div
                    class="relative flex items-center justify-between bottom-0 origin-bottom-center translate scale-90 text-xs">
                    @if($settings->blog['showPublishedAt'])
                        <div class="flex items-center text-slate-700/60">
                            <div class="text-xs mr-2">
                                <i icon-name="calendar" class="w-3 font-bold"></i>
                            </div>
                            <b>{{$post->publishTimeDiff()}}</b>
                        </div>
                    @endif
                    @if($settings->blog['showViewCount'])
                        <div class="flex items-center text-slate-700/60 ">
                            <div class="text-xs mr-2">
                                <i icon-name="eye" class="w-3 font-bold"></i>
                            </div>
                            <b>{{$post->view_count}}</b>
                        </div>
                    @endif
                    @if($settings->blog['showReadTime'])
                        <div class="flex items-center text-slate-700/60">
                            <div class="text-xs mr-2">
                                <i icon-name="hourglass" class="w-3 font-bold"></i>
                            </div>
                            <b>{{$post->read_time}} {{__('min')}}</b>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
