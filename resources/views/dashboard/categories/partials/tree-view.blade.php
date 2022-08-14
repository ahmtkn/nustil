@php($generation = $generation ?? 1)
@php($isBlog = $isBlog ?? false)
<tr class="animate-x ml-[{{$generation*5}}px]" x-data="{category:{{$category->toJson()}}}">
    <td class="text-center hidden sm:table-cell w-5">
        <div class=""
        @for($i=0;$i<$generation;$i++)
            <span class="w-1 h-1">-</span>
        @endfor
    </td>
    <td>{{$category->name}}</td>
    @canany(['categories.update','categories.delete'])
        <td class="text-center hidden md:table-cell w-20">


            <div class="flex items-center justify-center gap-2">
                @can('categories.update')
                    <a href="{{route('dashboard.'.($isBlog?'blog.':'').'categories.edit',$category)}}"
                       class="btn btn-ghost">
                        <i icon-name="edit"></i>
                        <span class="hidden sm:block">{{__('Edit')}}</span>
                    </a>
                @endcan
                @can('categories.delete')
                    <a href="javascript:;" data-modal-toggle="category-delete-modal"
                       @click="deleting=category;action=url.replace('CATEGORY_ID',{{$category->id}})"
                       class="btn btn-ghost text-red-500">
                        <i icon-name="trash-2"></i>
                        <span class="hidden sm:block">{{__('Delete')}}</span>
                    </a>
                @endcan
            </div>
        </td>
    @endcanany
</tr>
@if($category->children->count())
    @foreach($category->children as $child)
        @include('dashboard.categories.partials.tree-view',['category'=>$child,'generation'=>$generation+1,'isBlog'=>$isBlog])
    @endforeach
@endif
