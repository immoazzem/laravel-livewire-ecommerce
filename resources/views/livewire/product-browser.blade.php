<div class="mx-auto sm:px-6 lg:px-8 max-w-7xl py-12 grid grid-cols-6 gap-4">
    <div class="col-span-1">
        <div class="space-y-1">
            <ul>
                <li>
                    <a href="" class="text-indigo-500">
                        category child
                    </a>
                </li>
            </ul>
        </div>
        <div class="space-y-6">
            <div class="space-y-1">
                <div class="font-semibold">Max price (BDT0)</div>
                <div class="flex items-center space-x-2">
                    <input type="range" min="0" max="">
                </div>
            </div>
            <div class="space-y-1">
                <div class="font-semibold">Filter title</div>
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="" value=""> <label for="">Variation type (0) </label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-span-5 sm:px-6 lg:px-8">
        <div class="mb-6">
            Found 0 products
        </div>
        <div class="overflow-hidden sm:rounded-lg grid lg:grid-cols-3 md:grid-cols-2 gap-4">
            @foreach ($products as $product)
            <a href="/products/{{ $product->slug }}" class="p-6 bg-white border-b border-gray-200 space-y-4">
                <img src="{{ $product->getFirstMediaUrl() }}" alt="" class="w-full">
                <div class="space-y-1">
                    <div>{{ $product->title }}</div>
                    <div class="font-semibold text-lg">
                        {{ $product->formattedPrice() }}
                    </div>
                </div>
            </a>
            @endforeach

        </div>
    </div>
</div>