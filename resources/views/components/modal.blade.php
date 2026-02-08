{{-- @props([
    'id',
    'title',
    'message',
    'route',
    'method' => 'POST',
    'buttonText' => 'Confirm',
    'buttonClass' => 'btn-primary'
])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ $route }}" method="{{ strtoupper($method) === 'GET' ? 'GET' : 'POST' }}">
                @csrf
                @if(!in_array(strtoupper($method), ['GET','POST']))
                    @method($method)
                @endif
                <div class="modal-header">
                    <h5 class="modal-title">{{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ $message }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn {{ $buttonClass }}">{{ $buttonText }}</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}


<div class="modal-overlay hidden" id="{{ $id }}">
  <div class="modal-box">
    <button class="close-btn" onclick="closeModal('{{ $id }}')">×</button>

    <div class="modal-icon">
      <i class="{{ $icon }}"></i>
    </div>

    <h2 class="modal-title">{{ $title }}</h2>

    @if(!empty($message))
      <p style="margin-bottom:20px;color:#666;">{{ $message }}</p>
    @endif

    <div class="modal-buttons">
      <button class="btn cancel" onclick="closeModal('{{ $id }}')">
        {{ $cancelText ?? 'Cancel' }}
      </button>

      <form method="POST" action="{{ $route }}">
        @csrf
        @method($method ?? 'POST')
        <button class="btn submit" style="{{ $danger ?? false ? 'background:#ff5252' : '' }}">
          <i class="{{ $buttonIcon }}"></i> {{ $buttonText }}
        </button>
      </form>
    </div>
  </div>
</div>
