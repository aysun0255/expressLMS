@extends('layouts.master')

@section('content')
<div class="well">
<center>
    <h3>Calendar</h3> 
    <div id="testDiv" style="width: 200px;height: 200px;">
    <div class="calendar_test" ></div>
					
				</div>
		<script type="text/javascript">
			$(document).ready( function(){
				theMonths = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
				theDays = ["S", "M", "T", "W", "T", "F", "S"];

				$('.calendar_test').calendar({
					months: theMonths,
					days: theDays,
					req_ajax: {
						type: 'get',
						url: 'calendar/events'
					}
				});
			});
		</script>
</center></div>
@stop