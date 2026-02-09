<style>
    /* Pastikan gaya ini ada supaya butang modal tidak 'naked' */
    .modal-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
        margin-top: 25px;
    }

    .modal-actions .btn {
        padding: 10px 25px;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s;
    }

    .btn-light {
        background-color: #f3f4f6;
        color: #374151;
    }

    .btn-danger {
        background-color: #ef4444;
        color: white;
    }

    /* Gaya apabila butang di-disable (checkbox belum ditanda) */
    .btn-danger:disabled {
        background-color: #fca5a5;
        cursor: not-allowed;
        opacity: 0.7;
    }

    .modal-title {
        color: #111827;
        font-size: 1.25rem;
        margin-bottom: 10px;
    }
</style>

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
