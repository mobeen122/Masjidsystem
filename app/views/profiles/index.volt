{{ content() }}
<div class="row">
	<div class="col-md-12">
		<div class="portlet light ">
			<div class="portlet-title">
				<div class="caption">Manage Permissions </div>
				<div class="tools"><div class="btn-group btn-group-devided">{{ link_to("profiles/create", "Create Profiles", "class": "btn btn-transparent red btn-sm") }}</div>
				</div>
			</div>
			
			<div class="portlet-body form">
				<form method="post" action="{{ url("profiles/search") }}" autocomplete="off">
				    <div class="form-body">
				    	<div class="row">
							<div class="col-lg-4 col-md-4 col-xm-4 col-xs-12">
								<div class="form-group">
									<label for="id" class="control-label col-md-3">ID</label>
									<div class="col-md-9">{{ form.render("id") }}</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-xm-4 col-xs-12">
								<div class="form-group">
									<label for="name" class="control-label col-md-3">Name</label>
									<div class="col-md-9">{{ form.render("name") }}</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-xm-4 col-xs-12">
								{{ submit_button("Search", "class": "btn btn-primary") }}
							</div>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>	

