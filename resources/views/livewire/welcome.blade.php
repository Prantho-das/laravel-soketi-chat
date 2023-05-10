<div>
    <section class="text-gray-600 body-font relative">
        <div class="absolute inset-0 bg-gray-300">
            <iframe width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0" title="map"
                scrolling="no"
                src="https://maps.google.com/maps?width=100%&amp;height=600&amp;hl=en&amp;q=%C4%B0zmir+(My%20Business%20Name)&amp;ie=UTF8&amp;t=&amp;z=14&amp;iwloc=B&amp;output=embed"
                style="filter: grayscale(1) contrast(1.2) opacity(0.4);"></iframe>
        </div>
        <form wire:submit.prevent='sendFeedBack'>
            <div class="container px-5 py-24 mx-auto flex">
                <div
                    class="lg:w-1/3 md:w-1/2 bg-white rounded-lg p-8 flex flex-col md:ml-auto w-full mt-10 md:mt-0 relative z-10 shadow-md">

                    @if (session()->has('info'))
                    <div
                        class="rounded-md px-2 py-4 <?php echo session('info')['type']=='success'?'text-white bg-green-500':''  ?>">
                        {{ session('info')['message'] }}
                    </div>
                    @endif
                    <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Feedback</h2>
                    <p class="leading-relaxed mb-5 text-gray-600">
                        Tell Us What You Think
                    </p>
                    <div class="relative mb-4">
                        <label for="email" class="leading-7 text-sm text-gray-600">Email</label>
                        <input type="email" id="email" name="email" wire:model='email'
                            class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="relative mb-4">
                        <label for="message" class="leading-7 text-sm text-gray-600">Message</label>
                        <textarea id="message" name="message" wire:model='message'
                            class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                        @error('message') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <button
                        class="text-white bg-blue-500 border-0 py-2 px-6 focus:outline-none hover:bg-blue-600 rounded text-lg">Send</button>
                    <p class="text-xs text-gray-500 mt-3">
                        Click the button to send your message
                    </p>
                </div>

            </div>
        </form>
    </section>
</div>
