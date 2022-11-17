<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('product.create') }}" class="inline-flex items-center px-4 py-2 mb-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">Add Product</a>
                </div>
                <div class="p-6 text-gray-900">
                    <!--  -->
                    @if (isset($products))
                    <table class="w-full">
                        <tr>
                            <th>SKU</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                        @foreach($products as $product)

                        <tr>
                            <th>{{ $product->sku }}</th>
                            <th>{{ $product->name }}</th>
                            <th>{{ $product->price }}</th>
                            <th align="center"><img src="{{ asset('images/'.$product->image) }}" height="200" width="200"/></th>
                            <th>
                                <a href="{{ route('product.update', $product->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">Edit</a>
                                <a href="{{ route('product.delete', $product->id) }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">Delete</a>
                            </th>

                        @endforeach
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
