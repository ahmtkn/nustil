@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{__('Products')}}</h2>
@endsection

@section('content')
    <div x-data="{deleting:'',url:'{{route('dashboard.products.delete',['product'=>'PRODUCT_ID'])}}',action:null}">

        @can('products.create')
            <div class="flex items-center justify-end my-4 mx-4">
                <a href="{{route('dashboard.products.create')}}"
                   class="btn btn-emerald">
                    <i icon-name="plus"></i> {{__('Create new product')}}
                </a>
            </div>
        @endcan

        <section class="my-4 mx-auto max-w-7xl">
            <table class="data-table">
                <thead>
                <tr>
                    <th class="whitespace-nowrap -animate-y text-center hidden sm:table-cell">#</th>
                    <th class="whitespace-nowrap -animate-y uppercase">{{__('Name')}}</th>
                    <th class="whitespace-nowrap -animate-y uppercase text-center">{{__('Weight')}}</th>
                    <th class="whitespace-nowrap -animate-y uppercase text-center hidden sm:table-cell">{{__('Locale')}}</th>
                    <th class="whitespace-nowrap -animate-y uppercase hidden sm:table-cell">{{__('Categories')}}</th>
                    <th class="whitespace-nowrap -animate-y uppercase text-center">{{__('Views')}}</th>
                    <th class="whitespace-nowrap uppercase -animate-y text-center">{{__('Actions')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr class="animate-x nustil-animation-delay-5" x-data="{product:{{$product->toJson()}}}">
                        <td class="text-center hidden sm:table-cell">{{$product->id}}</td>
                        <td>{{$product->name}}</td>
                        <td class="text-center">{{$product->weight}}g</td>
                        <td class="text-center hidden sm:table-cell">
                            <x-locale-flag class="w-5" :flag="$product->locale"/>
                        </td>
                        <td class="hidden sm:table-cell">
                            @foreach($product->categories->take(3) as $category)
                                <a href="{{route('dashboard.categories.edit',['category'=>$category->slug])}}"
                                   class="text-sm hover:text-emerald-600 hover:underline text-gray-600">{{$category->name}}</a>
                                @unless($loop->last)
                                    <span class="text-gray-600">•</span>
                                @endunless
                            @endforeach
                        </td>
                        <td class="text-center">{{$product->views()}}</td>
                        <td class="text-center border-l md:w-64 lg:w-72">
                            <a href="{{route('product.show',['product'=>$product->slug])}}"
                               target="_blank"
                               class="btn btn-ghost text-blue-500">
                                <i icon-name="eye" class="w-5 h-5"></i>
                                <span class="hidden sm:block text-xs"> {{__('Show')}}</span>
                            </a>
                            @can('products.update')
                                <a href="{{route('dashboard.products.edit',$product)}}"
                                   class="btn btn-ghost">
                                    <i icon-name="edit" class="w-5 h-5"></i>
                                    <span class="hidden sm:block text-xs"> {{__('Edit')}}</span>
                                </a>
                            @endcan
                            @can('products.delete')
                                <a href="javascript:;" class="btn btn-ghost text-red-500"
                                   data-modal-toggle="product-delete-modal"
                                   @click="deleting = true; action = '{{route('dashboard.products.delete',$product)}}'">
                                    <i icon-name="trash" class="w-5 h-5"></i>
                                    <span class="hidden sm:block text-xs"> {{__('Delete')}}</span>
                                </a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>
        <x-dashboard.modal id="product-delete-modal">
            <x-slot name="heading">{{__('Delete product')}}</x-slot>
            <x-slot name="body">
                <p>{{__('Are you sure you want to delete this product?')}}</p>
            </x-slot>
            <x-slot name="footer">
                <form :action="action" method="post" class="w-full">
                    @method('DELETE')
                    <div class="items-center w-full flex flex-1 justify-between">
                        <div class="btn btn-white btn-sm" data-modal-toggle="user-delete-modal">
                            <i icon-name="chevron-left" class="p-1"></i> {{__('Abort')}}
                        </div>
                        <button class="btn btn-danger btn-sm">
                            <i class="p-1" icon-name="trash-2"></i>
                            {{__('Delete')}}
                        </button>
                        @csrf
                    </div>
                </form>
            </x-slot>

        </x-dashboard.modal>
    </div>
@endsection
