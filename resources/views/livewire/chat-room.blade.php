<div>
    <div class="w-11/12 mx-auto py-4">
        <div class="flex gap-4 flex-wrap">
            <div class="left-box flex-1">
                <h2 class="text-3xl">All Rooms</h2>
                <div class="grid grid-cols-12 gap-4 mt-4">
                    @foreach ($rooms as $room)
                        <div class="lg:col-span-6 col-span-12">
                            <a href="{{ url('/r', ['roomId' => $room->slug]) }}">
                                <div class="card flex p-0 gap-2">
                                    <div class="banner_img">
                                        <img src="{{ $room->banner }}" alt="" class="w-full h-full">
                                    </div>
                                    <div class=" text-center">
                                        <h2 class="text-2xl">{{ $room->name }}</h2>
                                    </div>
                                </div>

                            </a>
                        </div>
                    @endforeach
                </div>
                {{$rooms->links()}}
            </div>
            <div class="right-box">

                <div class="px-6 py-4 shadow-md lg:w-96">
                    <h2 class="text-3xl">Create Room</h2>
                    <form wire:submit.prevent='createRoom'>
                        @if (session()->has('info'))
                            <div class="rounded-md px-2 py-4 <?php echo session('info')['type'] == 'success' ? 'text-white bg-green-500' : ''; ?>">
                                {{ session('info')['message'] }}
                            </div>
                        @endif
                        <p class="leading-relaxed mb-5 text-gray-600">
                            Tell Us What You Think
                        </p>
                        <div class="relative mb-4">
                            <label for="email" class="leading-7 text-sm text-gray-600">Room Name</label>
                            <input type="text" id="email" name="email" wire:model='name'
                                class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            @error('name')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="relative mb-4">
                            <label for="email" class="leading-7 text-sm text-gray-600">Password</label>
                            <input type="password" id="email" name="email" wire:model='password'
                                class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            @error('password')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="relative mb-4">
                            <label for="message" class="leading-7 text-sm text-gray-600">Message</label>
                            <textarea id="message" name="message" wire:model='description'
                                class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                            @error('description')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <button
                            class="text-white bg-blue-500 border-0 py-2 px-6 focus:outline-none hover:bg-blue-600 rounded text-lg">Send</button>
                        <p class="text-xs text-gray-500 mt-3">
                            Click the button to send your message
                        </p>
                    </form>
                </div>

            </div>
        </div>

    </div>

</div>
