<div>
    @if ($selectedConversation)
        <div class="input-group">
            <!-- Text input field for entering a message -->
            <input type="text" class="form-control" wire:model="body" placeholder="Enter Message..."
                aria-label="Example text with button addon" aria-describedby="button-addon1" id="messageInput" autofocus>

            <!-- Microphone button (can be implemented later) -->
            <button class="btn btn-outline-secondary pe-1" type="button" id="button-addon1 ms-2">
                <i class="fa-solid fa-microphone"></i>
            </button>

            <!-- Emoji button (can be implemented later) -->
            <button class="btn btn-outline-secondary pe-1" type="button" id="emojiButton" onclick="emojiPickerOpen()">
                <i class="fa-solid fa-face-smile"></i>
            </button>

            <!-- Attachment button (for file attachments) -->
            <button class="btn btn-outline-secondary pe-1" type="button" id="attachButton"
                onclick="document.getElementById('fileInput').click()">
                <i class="fa-solid fa-paperclip"></i>
            </button>
            <input type="file" id="fileInput" style="display: none;" onchange="handleFileAttach(event)">

            <!-- Send message button -->
            <button class="btn btn-outline-secondary" wire:click="sendMessage" type="button" id="button-addon1 ms-2">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </div>
    @endif
</div>
