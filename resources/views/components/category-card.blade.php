@props(['rows' => '1','category'])
<div
    class="flex items-start hover:bg-emerald-600 font-nunito overflow-hidden transition-all ease-in-out bg-slate-100 group p-4 rounded-xl shadow-sm lg:row-span-{{$rows}} animate-y relative">
    @if($category->children->count())
        <div
            class="absolute bottom-0 inset-x-0 flex items-center  transition-all ease-in-out border-t group-hover:border-emerald-700">
            @foreach($category->children as $child)
                <a href="{{route('category.show',$child)}}"
                   class="text-center w-full p-2 transition-all ease-in-out hover:bg-emerald-700 truncate group-hover:text-white text-nustil-purple font-bold">{{$child->name}}</a>
            @endforeach
        </div>
    @endif
    <a class="absolute flex items-center justify-center top-5 right-4 w-6 h-6 bg-slate-200 group-hover:bg-emerald-700 rounded-full group-hover:bg-emerald-700 transition-all ease-in-out group-hover:shadow-2xl shadow-sm"
       href="{{route('category.show',$category)}}">
        <svg class="w-5 h-5 text-slate-100 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20"
             xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                  clip-rule="evenodd"></path>
        </svg>
    </a>
    <a href="{{route('category.show',$category)}}">
        <div
            class="relative mb-8 pb-4 text-xl text-nustil-purple font-black duration-300 transition-all ease-in-out group-hover:text-white lg:text-3xl transform group-hover:translate-x-8 font-black">
            <span>{{$category->name}}</span>
        </div>
    </a>
</div>
{{--<div--}}
{{--    class="flex items-start  lg:row-span-{{$rows}} animate-y hover:text-white nustil-animation-delay-4 bg-slate-200 hover:bg-emerald-600 rounded-lg p-4">--}}
{{--    <a href="{{route('category.show',$category)}}"--}}
{{--       class="text-base font-black tracking-wide font-nunito">{{$category->name}}</a>--}}
{{--</div>--}}
