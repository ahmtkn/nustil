@php($generation = $generation ?? 1)
<option value="{{$category->id}}"
        {{$product->categories->contains($category->id) ? 'selected' : ''}}>
    ⌞ @for($i=0;$i<($generation-1);$i++) — @endfor
    &emsp;{{$category->name}}
</option>
@if($category->has('children'))
    @foreach($category->children as $child)
        @include('dashboard.product.partials.category-option',['category'=>$child,'product' =>$product])
    @endforeach
@endif
