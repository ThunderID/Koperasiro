<button class="btn btn-link dropdown-toggle text-center p-r-lg p-l-none" type="a" data-toggle="dropdown">
	<i class="fa fa-bell fa-md" style="font-size: 15px;"></i>
</button>
<ul class="dropdown-menu">
	<?php 
	// @foreach(\App\Web\Services\Notification::all() as $value)
	// 	<li><a href="{{$value->link}}" target="_blank"><span class="label label-primary">{{$value->when->diffForHumans()}}</span> {{substr($value->description, 0, 45)}}...</a></li>
	// 	<li role="presentation" class="divider"></li>
	// @endforeach
	?>
	<li><a href="#" target="_blank" class="text-center"><i>Nothing here</i></a></li>
	<!-- <li><a href="{{route('notification.index')}}" target="_blank" class="text-center">View All</a></li> -->
</ul>
