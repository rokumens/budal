@extends('devtools/layouts/app')

@section('content')
<div class="container-fluid">
  <h2>Devtools</h2>
  <hr>
  <a href="{{ route('devtools/purge/prize') }}">Purge All Number Orchardpools Table</a>
  <br>
  <a href="{{ route('devtools/purge/winner') }}">Purge Winner Orchardpools Table</a>
  <br>
  <a href="{{ route('devtools/purge/starter') }}">Purge Starter Orchardpools Table</a>
  <br>
  <a href="{{ route('devtools/purge/consolation') }}">Purge Consolation Orchardpools Table</a>
  <br>
  <a href="{{ route('devtools/livedraw/generatetimeshow') }}">Update Generate Time Show</a>
  <br>
  <a href="{{ url('devtools/truncate/today') }}">Truncate Today</a>
  <br>
  <a href="{{ url('devtools/truncate/all') }}">Truncate</a>
</div>
@endsection