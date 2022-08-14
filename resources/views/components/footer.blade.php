@if($settings->newsletter['enabled'])
    <section class="bg-nustil-purple/90 mt-16 lg:mt-24">
        <div class="px-4 py-8 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8">
            <div class="flex flex-col lg:flex-row md:items-center md:justify-between w-full">
                <div class="mb-8 lg:mb-0">
                    <h2 class="text-3xl font-black text-center animate-x nustil-animation-delay-4 lg:text-left tracking-tight text-white sm:text-4xl sm:leading-none mb-6 md:mb-8">
                        {{__('Get our recipes')}}
                    </h2>
                    <p class="text-white/70 md:text-lg text-base lg:max-w-md text-center lg:text-left animate-x nustil-animation-delay-5">
                        {{__('In :company, we love to create new and interesting recipes. We are always looking for new and interesting recipes to share with you.',['company' => config('app.name')])}}
                    </p>
                </div>
                <div x-data="{email:null,isLoading:false,response:null,isError:false}"
                     class="w-1/3 flex flex-col justify-end">
                    <div class="-animate-x nustil-animation-delay-8 flex items-center">
                        <input type="email" x-model="email" placeholder="{{__('Your email')}}"
                               @change="isError=false;response:null"
                               class="w-full px-4 py-2 font-medium text-nustil-purple bg-white border-nustil-purple placeholder-nustil-purple/90 ring-2 transition-all ease-in-out duration-300 focus:border-nustil-purple focus:outline-none ring-nustil-purple ring-offset-nustil-purple rounded-l-full shadow-sm">
                        <button
                            :disabled="isLoading"
                            @click="isLoading=true;
                    fetch('{{route('api.newsletter.subscribe')}}',{method:'POST',body:JSON.stringify({email:email})})
                    .then(res=>res.json())
                    .then(res=>{
                        if(res.success){
                            response='{{__('You have been subscribed to our newsletter')}}';
                            isError=false;
                        }else{
                            response=res.message
                            isError=true;
                        }
                        isLoading=false;
                    }).catch(err=>{
                        isError=true;
                        response='{{__('Something went wrong')}}';
                        isLoading=false;
                    })
                    "
                            class="btn btn-purple whitespace-nowrap btn-r-rounded ring-2 ring-offset-nustil-purple ring-nustil-purple">
                            <div x-show="!isLoading">
                                {{__('Subscribe')}}
                            </div>
                            <div x-show="isLoading">
                                <div role="status">
                                    <svg class="inline w-6 h-6 text-white/30 animate-spin fill-white"
                                         viewBox="0 0 100 101"
                                         fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                            fill="currentColor"/>
                                        <path
                                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                            fill="currentFill"/>
                                    </svg>
                                    <div class="sr-only">Loading...</div>
                                </div>
                            </div>
                        </button>

                    </div>
                    <div x-text="response"
                         x-show="response != null"
                         class="rounded-full py-2 px-4 mt-5"
                         :class="{'bg-red-600 text-white':isError,'bg-emerald-600 text-white':!isError}"></div>
                </div>
            </div>
        </div>

    </section>
@endif
<footer class="bg-nustil-purple lg:mt-16">
    <div class="px-4 pt-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8">
        <div class="grid gap-10 row-gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-4">
            <div class="sm:col-span-2">
                <a href="{{route('landing')}}" class="inline-flex items-center -animate-x">
                    <x-application-logo logo="white"/>
                </a>
                <div class="mt-6 lg:max-w-sm space-y-2 text-sm">
                    <div class="flex items-center -animate-x">
                        <i icon-name="map" class="mr-2 w-5 h-5 text-white text-opacity-70 block"></i>
                        <a href="https://www.google.com/maps/search/{{urlencode($settings->address)}}"
                           rel="noopener noreferrer" target="_blank"
                           class="transition-colors duration-300 text-white/60 font-medium hover:text-white">
                            {{$settings->address}}
                        </a>
                    </div>
                    <div class="flex items-center -animate-x">
                        <i icon-name="phone" class="mr-2 w-5 h-5 text-white text-opacity-70 block"></i>
                        <a href="tel:{{Str::replace(' ','',$settings->phone_number)}}"
                           class="transition-colors duration-300 text-white/60 font-medium hover:text-white">
                            {{$settings->phone_number}}
                        </a>
                    </div>
                    <div class="flex items-center -animate-x">
                        <i icon-name="mail" class="mr-2 w-5 h-5 text-white text-opacity-70 block"></i>
                        <a href="mailto:{{$settings->contact_email}}"
                           class="transition-colors duration-300 text-white/60 font-medium hover:text-white">
                            {{$settings->contact_email}}
                        </a>
                    </div>
                </div>
            </div>
            <div class="space-y-2 animate-x">
                <span class="text-base font-bold tracking-wide text-white">{{__('Keep in touch')}}</span>
                <div class="flex items-center mt-1 space-x-3">
                    @foreach($settings->social_media as $platform => $url)
                        <a href="https://{{$platform}}.com/{{$url}}"
                           rel="noopener noreferrer" target="_blank"
                           class="transition-colors duration-300 hover:text-white text-white/70">
                            <i icon-name="{{$platform}}" class="w-5 h-5 block"></i>
                        </a>
                    @endforeach
                </div>
                <p class="mt-4 text-sm text-white text-opacity-50">
                    {{__('Follow us on social media.')}}
                </p>
            </div>
            <div class="space-y-2 text-sm animate-x">
                <p class="text-base font-bold tracking-wide text-white">{{__('Useful Links')}}</p>
                @menu('useful-links')
            </div>

        </div>
        <div class="flex flex-col-reverse justify-between pt-5 pb-10 border-t border-white/[.1] lg:flex-row">
            <p class="text-sm text-white/50">
                © Copyright {{date('Y')}}  {{$settings->site_name}}. {{__('All rights reserved.')}}
            </p>
            @menu('footer')
        </div>
    </div>
</footer>
