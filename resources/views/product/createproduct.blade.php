<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if (isset($singleProduct))
            {{ __('Edit Product') }}
            @else
            {{ __('Add Product') }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Name -->
                    <div>
                        @if (isset($errors))
                            <div>
                                @foreach ($errors as $item)
                                    <div>
                                        {{ $item }}
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <form method="post" enctype="multipart/form-data" @if (isset($singleProduct)) action="{{ route('product.edit', $singleProduct->id) }}" @else action="{{ route('product.store') }}" @endif>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="mt-4">
                                <input type="text" name="name" placeholder="name" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="@if (isset($singleProduct))  {{ $singleProduct->name }}   @endif"/>
                            </div>
                            <div class="mt-4">
                                <input type="text" name="sku" placeholder="sku" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="@if (isset($singleProduct))  {{ $singleProduct->sku }}   @endif"/>
                            </div>

                            <div class="mt-4">
                                <input type="text" name="price" placeholder="price" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"  value="@if (isset($singleProduct))  {{ $singleProduct->price }}   @endif"/>
                            </div>

                            <div class="mt-4">
                                @if (isset($singleProduct))
                                    <img src="{{ asset('images/'. $singleProduct->image) }}" height="200" width="200" />
                                @endif
                                <input type="file" name="image" placeholder="iamge" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"/>
                            </div>

                            <div class="mt-4">
                                <label>Status</label>
                                <input type="checkbox" name="status" value="1"  @if (isset($singleProduct))  {{ $singleProduct->status?'checked':'' }}   @endif" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"/>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
