@php($generation = $generation ?? 1)
@php($editing = $editing ?? false)
<option value="{{$category->id}}"
        {{$category->id == old('parent_id') || ($editing && $category->id == $editing->parent_id)  ? 'selected' : ''}}>
    ⌞ @for($i=0;$i<($generation-1);$i++) — @endfor
    &emsp;{{$category->name}}
</option>
@if($category->children->count())
    @foreach($category->children as $child)
        @include('dashboard.categories.partials.option', ['category' => $child, 'generation' => $generation+1,'editing'=>$editing])
    @endforeach
@endif
