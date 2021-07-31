<div class="col-md-4 col-lg-3">
	<div class="user-left-nav">
		<ul class="list-unstyled user-nav-list">
            <li class="list-item {{ Request::is('notification_sub') ? 'active' : '' }}" style=" background:#7aceaf;">
				<a href="{{ url('/')}}/purchase_new_subscription" class="link" style="color: #000 !important; font-weight:600">
                <!-- <img src="{{url('/')}}/uploads/images/purchasing.png" style="width:32px;">-->  New Subscription </a> 
			</li>
            <li class="list-item {{ Request::is('profile') ? 'active' : '' }}">
				<a href="{{ url('/')}}/profile" class="link"> 
                <i class="fa fa-th-large mr-2"></i> Dashboard</a>
			</li>
			<li class="list-item {{ Request::is('notification_sub') ? 'active' : '' }}">
				<a href="{{ url('/')}}/notification_sub" class="link">
                <i class="icon fa icon fa-bell mr-2"></i> Notification 
                <span class="notif-count circle_notification"></span></a>
			</li>
			
			<li class="list-item {{ Request::is('mysubscription') ? 'active' : '' }}" >
                <a href="{{ url('/')}}/mysubscription" class="link">
                <i class="fa fa-shopping-basket mr-2"></i> My Subscriptions</a> 
            </li>
			<li class="list-item {{ Request::is('mealprogram') ? 'active' : '' }}">
				<a href="{{ url('/')}}/mealprogram" class="link">
                <i class="icon fa icon fa-cutlery mr-2"></i>Meal Prograram </a>
			</li>
            <li class="list-item {{ Request::is('health-history') ? 'active' : '' }}">
                <a href="{{ url('/')}}/health-history " class="link"><i class="fa fa-user-md mr-2"></i> My Health History</a>
            </li>
			<li class="list-item {{ Request::is('chat') ? 'active' : '' }}">
                <a href="{{ URL('') }}/chat" class="link">
				<i class="fa fa-weixin mr-2"></i> Chat with Nutrionist</a> 
            </li>            	
			<li class="list-item"><span class="link">
                    <i class="icon fa icon fa-sign-out mr-2"></i>
                    <a class="dropdown-action-item" href="{{ URL('') }}/logout">
                    <i class="nav_icon logout menu-icon nk-sprite-global nk-sprite-global-log-out"></i> 
                    Log Out</a>
                </span> 
            </li>
		</ul>
	</div>
</div>
