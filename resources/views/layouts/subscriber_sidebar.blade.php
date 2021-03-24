<div class="col-md-4 col-lg-3">
	<div class="user-left-nav">
		<ul class="list-unstyled user-nav-list">
			<li class="list-item {{ Request::is('notification_sub') ? 'active' : '' }}">
				<a href="{{ url('/')}}/notification_sub" class="link"><i class="icon fa icon fa-bell"></i>Notification <span class="notif-count circle_notification"></span></a>
			</li>
			<li class="list-item {{ Request::is('profile') ? 'active' : '' }}">
				<a href="{{ url('/')}}/profile" class="link"> <i class="icon fa icon fa-user-circle-o"></i>My Profile</a>
			</li>
			<li class="list-item {{ Request::is('mysubscription') ? 'active' : '' }}" >
                <a href="{{ url('/')}}/mysubscription" class="link"><i class="fa fa-shopping-basket"></i> My Subscriptions</a> 
            </li>
			<li class="list-item {{ Request::is('mealprogram') ? 'active' : '' }}">
				<a href="{{ url('/')}}/mealprogram" class="link"><i class="icon fa icon fa-cutlery"></i>Meal Prograram </a>
			</li>
            <li class="list-item {{ Request::is('health-history') ? 'active' : '' }}">
                <a href="{{ url('/')}}/health-history" class="link"><i class="fa fa-user-md"></i> My Health History</a>
            </li>
			<li class="list-item {{ Request::is('chat') ? 'active' : '' }}">
                <a href="{{ URL('') }}/chat" class="link">
				<i class="fa fa-weixin"></i> Chat with Nutrionistc </a> 
            </li>
            	
			<li class="list-item"><span class="link">
                <i class="icon fa icon fa-sign-out"></i>
                <a class="dropdown-action-item" href="{{ URL('') }}/logout">
                    <i class="nav_icon logout menu-icon nk-sprite-global nk-sprite-global-log-out"></i> Log Out </a>
                </span> 
            </li>
		</ul>
	</div>
</div>
<style>
.circle_notification {
    width: 20px  !important;
    height: 20px !important;
    position: absolute !important;
    background-color: #8bc34a !important;
    font-size: 12px !important;
    border-radius: 50% !important;
    text-align: center !important;
    line-height: 1.8 !important;
    font-weight: 600 !important;
    margin-left: 11px !important;
    margin-top: 1px !important;
   
}
</style>