<div wire:poll.500ms>
    @if ($messages)
        <!-- رأس المحادثة -->
        <div class="p-3 bg-white shadow-sm border-bottom">
            <strong>{{ $selectedUser->name }}</strong>
        </div>

        <!-- الرسائل -->
        <div class="p-3 overflow-auto" style="height: 65vh;" id="messagesContainer">
            @forelse ($messages as $msg)
                <div
                    class="d-flex {{ $msg->from_id == auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                    <div
                        class="px-3 py-2 rounded-pill text-white
                        {{ $msg->from_id == auth()->id() ? 'bg-primary' : 'bg-secondary' }}">
                        {{ $msg->body }}
                    </div>


                </div>
                <small
                    class=" text-muted d-block d-flex mb-3 {{ $msg->from_id == auth()->id() ? 'justify-content-end' : 'justify-content-start' }}"
                    style="font-size: 0.75rem;">
                    {{ $msg->created_at->diffForHumans() }}
                </small>
            @empty
                <div class="justify-center align-middle d-flex">
                    <button class="btn btn-primary" wire:click='sayHey("Hey👋🏻")'>
                        <strong>First time to contact with:<br>
                            <span style="color: black !important">
                                {{ $selectedUser->name }}
                            </span>
                            <br>Say Hey👋🏻 to him!
                        </strong>
                    </button>
                </div>
            @endforelse
        </div>

        <!-- إدخال الرسالة -->
        <div class="p-3 bg-white border-top">
            <form wire:submit.prevent="sendMessage">
                <div class="input-group">
                    <input type="text" wire:model="body" class="form-control" placeholder="Type Message...">
                    <button class="btn btn-primary" type="submit">Send</button>
                </div>
            </form>
        </div>
    @else
        <div class="color-blue h-100 d-flex align-items-center justify-content-center text-muted">
            <span style="color:#0d6efd">Choose someone!</span>
        </div>
    @endif

    <script>
        // مراقبة تغيّر مكون Livewire وإعادة التمرير للأسفل
        function scrollDown() {
            document.getElementById('messagesContainer').scrollTop = document.getElementById('messagesContainer')
                .scrollHeight;
        }
        setInterval(scrollDown, 100);
        console.log('a');
        window.addEventListener('clearInput', () => {
            const input = document.querySelector('input[wire\\:model]');
            if (input) input.value = '';
        });
    </script>
</div>
