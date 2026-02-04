<div id="{{ $id }}" class="modal-overlay hidden">
    <div class="delete-modal">
        <button class="close-btn" onclick="closeModal('{{ $id }}')">&times;</button>

        <div class="icon-circle">
            <i class="bi bi-trash-fill"></i>
        </div>

        <h2 class="modal-title"><strong>{{ $title }}</strong></h2><br>
        <p class="modal-text">{{ $message }}</p>

        <label class="confirm-check">
            <input type="checkbox" id="confirmCheck{{ $id }}">
            I understand this action is permanent.
        </label>

        <div class="modal-actions">
            <button class="btn btn-light" onclick="closeModal('{{ $id }}')">
                Cancel
            </button>

            <form action="{{ $route }}" method="POST">
                @csrf
                @method($method)
                <button type="submit"
                        class="btn btn-danger"
                        id="deleteBtn{{ $id }}"
                        disabled>
                    <i class="bi bi-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>
</div>
