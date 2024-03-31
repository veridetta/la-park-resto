@if ($message = session('message'))
    <div class="alert alert-{{ $message['success'] ? 'success my-bg text-white' : 'danger' }}" role="alert">
        <i class="fa fa-fw fa-{{ $message['success'] ? 'check-circle' : 'ban' }}"></i> {{ $message['message'] }}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <i class="fa fa-fw fa-ban"></i> Terdapat kesalahan dalam pengisian form :
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
