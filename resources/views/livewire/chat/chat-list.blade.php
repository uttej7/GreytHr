<div class="sidebar-list-contacts" id="contacts">
    <div class="top">
        <a href="/">
            <div class="nav-toggle btn">
                <span class="material-icons">keyboard_backspace</span>
            </div>
        </a>
        <div class="title">Contacts</div>
    </div>

    <div class="body">
        <div class="input-group mb-3">
            <span class="input-group-text bg-white pe-0" id="basic-addon1">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input type="text" class="contSearch form-control" wire:model.live="search"
                placeholder="Search for a name, email, or phone number" aria-label="Search"
                aria-describedby="basic-addon1">
        </div>

        <div class="list-users">
            <!-- Display Filtered Conversations -->
            @forelse ($conversations as $conversation)
                @php
                    $otherUser =
                        $conversation->sender_id === auth()->user()->emp_id
                            ? $conversation->receiver
                            : $conversation->sender;
                    $lastMessage = $conversation->messages()->latest()->first();
                @endphp
                <div class="item @if ($otherUser->isOnline()) active @endif">
                    <div class="avatar-chart">
                        <img src="{{ $otherUser->image
                            ? 'data:image/jpeg;base64,' . $otherUser->image
                            : ($otherUser->gender === 'MALE'
                                ? asset('images/male-default.png')
                                : asset('images/female-default.jpg')) }}"
                            alt="Avatar">
                        <span class="dot @if ($otherUser->isOnline()) -online @else -offline @endif"></span>
                    </div>
                    <div class="text-content" wire:key='{{ $otherUser->emp_id }}'
                        wire:click="$dispatch('chatUserSelected', { senderId: '{{ auth()->user()->emp_id }}', receiverId: '{{ $otherUser->emp_id }}' })">
                        <div class="name">{{ $otherUser->first_name }} {{ $otherUser->last_name }}</div>
                        <div class="last-message">
                            {{ $lastMessage ? $lastMessage->body : 'No messages yet.' }}
                        </div>
                    </div>

                    <div class="actions">
                        <button class="btn" wire:key='{{ $otherUser->emp_id }}'
                            wire:click="$dispatch('chatUserSelected', { senderId: '{{ auth()->user()->emp_id }}', receiverId: '{{ $otherUser->emp_id }}' })">
                            <span class="material-icons position-relative">
                                question_answer
                                @if ($conversation->unreadMessagesCount(auth()->user()->emp_id) > 0)
                                    <span class="msgCount badge rounded-pill text-bg-danger">
                                        {{ $conversation->unreadMessagesCount(auth()->user()->emp_id) }}
                                    </span>
                                @endif
                        </button>
                    </div>
                </div>
            @empty
                <p class="text-center">No contacts found.</p>
            @endforelse
        </div>
    </div>
</div>
