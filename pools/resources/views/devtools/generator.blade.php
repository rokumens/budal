@extends('devtools/layouts/app')

@section('custom_css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css" integrity="sha256-VVbO1uqtov1mU6f9qu/q+MfDmrqTfoba0rAE07szS20=" crossorigin="anonymous" />
@endsection

@section('content')
<div class="container-fluid">
  <h2>Generator</h2>
  <hr>
  <div class="row">
    <div class="col-md-7">
      <form action="{{ url('devtools/generator/generate') }}" method="post">
        <div class="form-group">
          <label for="daterange">Range date</label>
          <input type="text" class="form-control" name="daterange" value="01/01/2020 - 04/25/2020" />
        </div>
        <button type="submit" class="btn btn-primary">Generate</button>
      </form>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="">Current Min Date</label>
        <input readonly type="text" class="form-control" value="{{ $firstDate }}">
      </div>
      <div class="form-group">
        <label for="">Current Max Date</label>
        <input readonly type="text" class="form-control" value="{{ $lastDate }}">
      </div>
    </div>
  </div>

</div>
@endsection

@section('custom_js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.js" integrity="sha256-iacRP5fv2z3yGk6gnwi/CjK8GRrr5MROIurU7iwYXRM=" crossorigin="anonymous"></script>
  <script>
    $(function() {
      $('input[name="daterange"]').daterangepicker({
        opens: 'left',
        showDropdowns: true
      }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
      });
    });
  </script>
@endsection