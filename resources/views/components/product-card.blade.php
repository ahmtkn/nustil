<div class="animate-y">
    <div
        class="product-card group relative flex origin-bottom transform flex-col pt-20 transition-all duration-500 ease-in-out hover:-translate-y-8">
        <div
            class="mb-18 absolute inset-x-0 top-0 z-10 h-36 transform text-center">
            <a href="{{route('product.show',$product)}}">
                <img data-src="{{$product->getImage()}}" alt="{{$product->name}}"
                     class="lazy mx-auto h-full w-auto drop-shadow-lg"/>
            </a>
        </div>

        <div
            class="mt-18 pb-8 flex flex-col relative items-center justify-center rounded-xl bg-slate-100 p-4 pt-20 transition-all duration-300 ease-in-out group-hover:shadow-2xl shadow-sm group-hover:bg-nustil-purple group-hover:text-white">
            @if($product->created_at->diff(now())->days < Carbon\Carbon::now()->modify('+'.$settings->product['newProductInterval'])->diff(now())->days)
                <div
                    class="absolute font-splash bg-red-500 text-white -top-4 right-2 z-30 rounded-lg px-3 shadow-sm py-1">{{__('New')}}</div>
            @endif
            <h3 class="mb-3 text-lg font-black leading-6 tracking-wide text-center">
                <a href="{{route('product.show',$product)}}">{{$product->name}}</a>
            </h3>
            <p class="text-center text-xs leading-relaxed opacity-70">{{$product->tagline}}</p>
        </div>
        @if($product->purchase_link)
            <div
                class="absolute group-hover:translate-y-8 bottom-2 transition duration-300 px-4 ease-in-out inset-x-0 group-hover:z-10 -z-10 flex">
                <a href="{{$product->purchase_link}}?ref=nustil.com" target="_blank"
                   class="w-full btn btn-emerald text-center hover:font-extrabold btn-rounded hover:tracking-widest text-base font-nunito font-bold tracking-wide">
                    {{__('Buy')}}
                </a>
            </div>
        @endif
    </div>
</div>
