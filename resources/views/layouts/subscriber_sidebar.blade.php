<div class="col-md-4 col-lg-3">
	<div class="user-left-nav">
		<ul class="list-unstyled user-nav-list">
			<li class="list-item {{ Request::is('profile') ? 'active' : '' }}">
				<a href="profile" class="link"> <i class="icon fa icon fa-user-circle-o"></i>My Profile</a>
			</li>
			<li class="list-item {{ Request::is('mysubscription') ? 'active' : '' }}" >
                <a href="mysubscription" class="link"><i class="fa fa-shopping-basket"></i> My Subscriptions</a> 
            </li>
			<li class="list-item {{ Request::is('mealprogram') ? 'active' : '' }}">
				<a href="mealprogram" class="link"><i class="icon fa icon fa-cutlery"></i>Meal Prograram </a>
			</li>
			<li class="list-item {{ Request::is('chat') ? 'active' : '' }}">
                <a href="{{ URL('') }}/chat" class="link">
					<i class="fa fa-weixin"></i> Chat with Nutrionist</a> 
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