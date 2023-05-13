<div>
    <div class="w-11/12 mx-auto py-4">
        <div class="flex gap-3">

            <div class="h-14 w-14 overflow-hidden rounded-full border-2 border-indigo-600">
                <img src="{{ $receiverInfo->avatar ?? env('AVATAR_URL') . $receiverInfo->name . '.png' }}" alt="">
            </div>
            <div class="group_info">
                <h1 class="text-xl">{{ $receiverInfo->name }}</h1>
                <h1 class="text-md">{{ $receiverInfo->email }}</h1>
                <h1 class="text-md">{{ $receiverInfo->isActive?'active':'' }}</h1>

            </div>

        </div>
        <h4 />


        <div id="messages"
            class="h-80 overflow-y-scroll flex flex-col space-y-4 p-3 scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch">
            @foreach ($messageList as $msg)
                @if ($msg['sender_id'] == auth()->user()->id)
                    <div class="chat-message">
                        <div class="flex items-end justify-end">
                            <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-1 items-end">
                                <div><span
                                        class="px-4 py-2 rounded-lg inline-block rounded-br-none bg-blue-600 text-white ">{{ $msg['message'] }}</span>
                                </div>
                            </div>
                            <img src="{{ $msg['sender_avatar'] }}" alt="My profile"
                                class="w-6 h-6 rounded-full order-2">
                        </div>
                    </div>
                @else
                    <div class="chat-message">
                        <div class="flex items-end">
                            <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-2 items-start">
                                <div><span
                                        class="px-4 py-2 rounded-lg inline-block rounded-bl-none bg-gray-300 text-gray-600">
                                        {{ $msg['message'] }}
                                    </span></div>
                            </div>
                            <img src="{{ $msg['sender_avatar'] }}" alt="My profile"
                                class="w-6 h-6 rounded-full order-1">
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <hr />
        <form wire:submit.prevent='sendMessage'>
            <label for="chat" class="sr-only">Your message</label>
            <div class="flex items-center py-2 px-3 bg-gray-50 rounded-lg dark:bg-gray-700">
                <button type="button"
                    class="inline-flex justify-center p-2 text-gray-500 rounded-lg cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <button type="button"
                    class="p-2 text-gray-500 rounded-lg cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 100-2 1 1 0 000 2zm7-1a1 1 0 11-2 0 1 1 0 012 0zm-.464 5.535a1 1 0 10-1.415-1.414 3 3 0 01-4.242 0 1 1 0 00-1.415 1.414 5 5 0 007.072 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <textarea wire:model="message" id="chat" rows="1"
                    class="block mx-4 p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Your message..."></textarea>
                <button type="submit"
                    class="inline-flex justify-center p-2 text-blue-600 rounded-full cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600">
                    <svg class="w-6 h-6 rotate-90" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z">
                        </path>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>
@push('scripts')
    <script>
        const showNotification = (title, body) => {
            // create a new notification
            const notification = new Notification(title, {
                body: body,
                icon: <?php env('AVATAR_URL'); ?> + title + '.png',
            });

            // close the notification after 10 seconds
            setTimeout(() => {
                notification.close();
            }, 10 * 1000);

            // navigate to a URL when clicked
            notification.addEventListener('click', () => {

                window.open('https://www.javascripttutorial.net/web-apis/javascript-notification/',
                    '_blank');
            });
        }

        (async () => {
            // create and show the notification

            // show an error message
            const showError = () => {
                const error = document.querySelector('.error');
                error.style.display = 'block';
                error.textContent = 'You blocked the notifications';
            }

            // check notification permission
            let granted = false;

            if (Notification.permission === 'granted') {
                granted = true;
            } else if (Notification.permission !== 'denied') {
                let permission = await Notification.requestPermission();
                granted = permission === 'granted' ? true : false;
            }


        })();

        let messages = document.querySelector('#messages')
        messages.scrollTo(0, messages.scrollHeight);

        Livewire.on("messageSentRefresh", user => {
            if (!user) {
                showNotification('lara-sok', 'You have a new message')

            }
            messages.scrollTo(0, messages.scrollHeight);
        })
    </script>
@endpush
