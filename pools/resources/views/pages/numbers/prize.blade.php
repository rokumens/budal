@extends('layouts.app')

@section('template_title')
  OrchardPools Prize
@endsection

@section('content')
<div class="container">
  <div class="row">

    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <span id="card_title">
              Winner Prize
            </span>
            <span class="float-right">{{ date('d F Y', strtotime($date)) }}</span>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive users-table">
            <table class="table table-striped table-sm data-table">
              <thead class="thead">
                <tr>
                  <th>No</th>
                  <th>Number</th>
                  <th>Prize</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $no = 1;
                @endphp
                @foreach($winner as $value)
                  @php
                    $prize = '-';
                    if($value->prize == 1){
                      $prize = '1st';
                    }elseif($value->prize == 2){
                      $prize = '2nd';
                    }elseif($value->prize == 3){
                      $prize = '3rd';
                    }
                  @endphp
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $value->number }}</td>
                    <td>{{ $prize }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <span id="card_title">
              Starter Prize
            </span>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive users-table">
            <table class="table table-striped table-sm data-table">
              <thead class="thead">
                <tr>
                  <th>No</th>
                  <th>Number</th>
                  <th>Prize</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $no = 1;
                @endphp
                @foreach($starter as $value)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $value->number }}</td>
                    <td>Starter {{ $value->prize }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <span id="card_title">
              Consolation Prize
            </span>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive users-table">
            <table class="table table-striped table-sm data-table">
              <thead class="thead">
                <tr>
                  <th>No</th>
                  <th>Number</th>
                  <th>Prize</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $no = 1;
                @endphp
                @foreach($consolation as $value)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $value->number }}</td>
                    <td>Consolation {{ $value->prize }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@section('footer_scripts')

  <script>
  </script>

@endsection