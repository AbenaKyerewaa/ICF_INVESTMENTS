@foreach (['success' => 'success', 'error' => 'danger', 'warning' => 'warning', 'status' => 'info'] as $key => $type)
    @if (session($key))
        <div class="container-fluid pt-3 px-3 px-lg-4"><div class="alert alert-{{ $type }} alert-dismissible fade show mb-0" role="alert">{{ session($key) }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>
    @endif
@endforeach
