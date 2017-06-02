{{ content() }}

<div class="row">
	<div class="col-md-6">
		<div class="portlet light ">
			<div class="portlet-title">
				<div class="caption">Login</div>				
			</div>
			
			<div class="portlet-body form">
				<form method="post" autocomplete="off">
				{{ form.render('csrf', ['value': security.getToken()]) }}
				    <div class="form-body">
				    	<div class="form-group">
							<label class="control-label col-md-3">Email Address</label>
							<div class="col-md-9">{{ form.render('email') }}</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Password</label>
							<div class="col-md-9">{{ form.render('password') }}</div>
						</div>										
					</div>
					<div class="form-actions">
					<div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                {{ form.render('Login') }}                            
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"> </div>
                	</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>