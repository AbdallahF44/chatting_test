<div class="p-3 list-group list-group-flush">
    <div class="" wire:poll.depounse.1000ms> </div>
    @foreach ($contacts as $contact)
        <button wire:click="selected({{ $contact->id }})"
            class="{{ $id === $contact->id ? 'active' : '' }} rounded list-group-item list-group-item-action text-start">
            <div class="fw-bold">{{ $contact->name }}</div>
            <div class="small text-muted">
                {{ $contact->from }}:
                {{ Str::limit($contact->last_message, 40) }}
                <br>
                <span class="text-muted fst-italic" style="font-size: 0.75rem">
                    {{ $contact->last_time }}
                </span>
            </div>
        </button>
    @endforeach

</div>
