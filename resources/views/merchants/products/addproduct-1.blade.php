<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Harkatshop</title>
</head>

<body>
    <div class="w-screen h-screen">
        <x-header></x-header>
        <div class="flex flex-row w-screen mt-2 h-5/6">
            <x-merchant.sidebar></x-merchant.sidebar>
            <div class="w-full m-6">
                <div class="flex justify-between pr-32 pl-12">
                    <h2 class="font-bold">ADD NEW PRODUCT</h2>
                    <a href="{{url('product')}}">
                        <h3 class="flex items-center font-bold text-xl"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                            </svg>PRODUCT LIST</h3>
                    </a>
                </div>
                <div class="grid grid-cols-2 gap-2 justify-items-center p-6">
                    <div>
                        <h3 class="p-2">NAME</h3>
                        <input type="text" placeholder="Name" class="w-80">
                    </div>
                    <div>
                        <h3 class="p-2">NAME(Arabic)</h3>
                        <input type="text" placeholder="Name" class="w-80">
                    </div>
                    <div>
                        <h3 class="p-2">Price</h3>
                        <input type="text" placeholder="Price" class="w-80">
                    </div>
                    <div>
                        <h3 class="p-2">Quantity</h3>
                        <input type="text" placeholder="Quantity" class="w-80">
                    </div>
                    <div>
                        <h3 class="p-2">Size</h3>
                        <input type="text" placeholder="Size" class="w-80">
                    </div>
                    <div>
                        <h3 class="p-2">Color</h3>
                        <input type="text" placeholder="Color" class="w-80">
                    </div>
                    <div>
                        <h3 class="p-2">DISCRIPTION</h3>
                        <input type="text" placeholder="Discription" class="w-80 h-32 rounded-xl">
                    </div>
                    <div>
                        <h3 class="p-2">DISCRIPTON(Arabic)</h3>
                        <input type="text" placeholder="Discription" class="w-80 h-32 rounded-xl">
                    </div>
                    <div>
                        <h3 class="p-2">Promotion Price</h3>
                        <input type="text" placeholder="Promotion Price" class="w-80">
                    </div>
                    <div>
                        <h3 class="p-2">Discount Rate</h3>
                        <input type="text" placeholder="Discount Rate" class="w-80">
                    </div>
                </div>
                <div class="pl-12 flex justify-between items-center pr-32">
                    <div>
                        <h2 class="font-bold">APP IMAGE</h2>
                        <div class="w-28 h-28"><img src="{{URL::asset('/images/user.png')}}" alt="logo"></div>
                    </div>
                    <a href="{{url('editproduct')}}"><button class="w-32 h-10 rounded-lg text-white bg-blue-600">submit</button></a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>