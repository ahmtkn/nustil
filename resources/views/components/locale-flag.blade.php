@php($flag = $flag == 'en' ? 'us' : $flag)
<img {{$attributes->merge(['class'=>''])}}
     src="https://hatscripts.github.io/circle-flags/flags/{{\Illuminate\Support\Str::lower($flag)}}.svg">
