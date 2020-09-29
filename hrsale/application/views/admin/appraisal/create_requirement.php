<div class="">
  <div class="col-md-6">
    <div class="form-group">
      <label for="min_daily_grade">Minimum Daily Requirement</label>
      <input class="form-control dailyRequirement" name="min_daily_grade" type="number" />
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="min_monthly_grade">Minimum Monthly Requirement</label>
      <input class="form-control monthlyRequirement" name="min_monthly_grade" type="number" />
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  $('.dailyRequirement').bind('keyup mouseup', function () {
			var dailyRequirement = this.value;
			let result = Math.round(dailyRequirement*30);
			$('.monthlyRequirement').val(result);
	});
  $('.monthlyRequirement').bind('keyup mouseup', function () {
			var monthlyRequirement = this.value;
			let result = Math.round(monthlyRequirement/30);
			$('.dailyRequirement').val(result);
	});
});
</script>
