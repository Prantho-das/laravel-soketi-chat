<div>
    @php
        $allRoom = App\Models\ChatRoom::all();
        $myRoom = App\Models\ChatRoom::where('created_by', auth()->user()->id)->get();
        $totalUser = App\Models\User::all();
        $myMessages = App\Models\Message::where('sender_id', auth()->user()->id)->get();

    @endphp
    <div class="w-11/12 mx-auto py-4">
        <div class="grid grid-cols-12 gap-4">
            <div class="md:col-span-4 lg:col-span-3 col-span-12">
                <a href="{{ url('rooms') }}">
                    <div class="card text-center">
                        <h2 class="text-2xl">All Rooms</h2>
                        <h5 class="text-4xl text-bold mt-4 d-block">
                            {{ $allRoom->count() }}
                        </h5>
                    </div>
                </a>
            </div>

            <div class="md:col-span-4 lg:col-span-3 col-span-12">
                <div class="card text-center">
                    <a href="{{ url('rooms') }}?room=mine">
                        <h2 class="text-2xl">My Chat Rooms</h2>
                        <h5 class="text-4xl text-bold mt-4 d-block">
                            {{ $myRoom->count() }}
                        </h5>
                    </a>
                </div>
            </div>
            <div class="md:col-span-4 lg:col-span-3 col-span-12">
                <div class="card text-center">
                    <a href="{{ url('rooms') }}?room=mine">
                        <h2 class="text-2xl">Personal Message</h2>
                        <h5 class="text-4xl text-bold mt-4 d-block">
                            {{ count($myMessages) }}
                        </h5>
                    </a>
                </div>
            </div>
            <div class="md:col-span-4 lg:col-span-3 col-span-12">
                <div class="card text-center">                    <a href="{{ url('users') }}">

                    <h2 class="text-2xl">All User</h2>
                    <h5 class="text-4xl text-bold mt-4 d-block">
                        {{ count($totalUser) }}
                    </h5>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
