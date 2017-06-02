
{{ content() }}

<form method="post">
<div class="row">
	<div class="col-md-12">
		<div class="portlet light ">
			<div class="portlet-title">
				<div class="caption">Manage Permissions </div>
			</div>
		<div class="portlet-body">				
			<div align="center">
				<table class="perms">
					<tr>
						<td><label for="profileId">Profile</label></td>
						<td>{{ select('profileId', profiles, 'using': ['id', 'name'], 'useEmpty': true, 'emptyText': '...', 'emptyValue': '') }}</td>
						<td>{{ submit_button('Search', 'class': 'btn btn-primary') }}</td>
					</tr>
				</table>			
			</div>
			{% if request.isPost() and profile %}
			{% for resource, actions in acl.getResources() %}		
				<h3>{{ resource }}</h3>		
				<table class="table table-bordered table-striped" align="center">
					<thead>
						<tr>
							<th width="5%"></th>
							<th>Description</th>
						</tr>
					</thead>
					<tbody>
						{% for action in actions %}
						<tr>
							<td align="center"><input type="checkbox" name="permissions[]" value="{{ resource ~ '.' ~ action }}"  {% if permissions[resource ~ '.' ~ action] is defined %} checked="checked" {% endif %}></td>
							<td>{{ acl.getActionDescription(action) ~ ' ' ~ resource }}</td>
						</tr>
						{% endfor %}
					</tbody>
				</table>
			
			{% endfor %}		
			{% endif %}	
		</div>
		</div>
	</div>
</div>	
					


</form>