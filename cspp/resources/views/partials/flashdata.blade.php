@if($message = Session::get('success'))
  <div class="alert alert-fade alert-success alert-dismissible fade show" role="alert" id="success-alert">
    <strong>Success!</strong> {{ $message }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif
{!! Session::forget('success') !!}
@if($message = Session::get('error'))
  <div class="alert alert-fade alert-danger alert-dismissible fade show" role="alert" id="danger-alert">
    <strong>Error!</strong> {{ $message }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif
{!! Session::forget('error') !!}
@if($message = Session::get('successNoFade'))
  <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
    <strong>Success!</strong> {{ $message }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif
{!! Session::forget('successNoFade') !!}
@if($message = Session::get('errorNoFade'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert" id="danger-alert">
    <strong>Error!</strong> {!! $message !!}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif
{!! Session::forget('errorNoFade') !!}