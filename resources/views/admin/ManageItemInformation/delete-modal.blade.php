@props([
    'id',
    'title' => 'ARE YOU SURE?',
    'message' => 'This action cannot be undone.',
    'route',
    'method' => 'DELETE',
])

<div id="{{ $id }}" class="modal-overlay hidden" role="dialog" aria-modal="true">
    <div class="delete-modal">
        <button type="button" class="close-btn" onclick="closeModal('{{ $id }}')" aria-label="Close">
            &times;
        </button>

        <div class="icon-circle">
            <i class="bi bi-trash"></i>
        </div>

        <div class="modal-title">{{ $title }}</div>
        <div class="modal-text">{{ $message }}</div>

        <div class="confirm-check">
            <input type="checkbox" id="confirmCheck{{ $id }}">
            <label for="confirmCheck{{ $id }}">I understand this action is permanent.</label>
        </div>

        <div class="modal-actions">
            <button type="button" class="btn-cancel" onclick="closeModal('{{ $id }}')">Cancel</button>

            <form action="{{ $route }}" method="POST" style="margin:0;">
                @csrf
                @if(strtoupper($method) !== 'POST')
                    @method($method)
                @endif

                <button type="submit" class="btn-delete" id="deleteBtn{{ $id }}" disabled>
                    <i class="bi bi-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>
</div>
