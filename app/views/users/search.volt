{{ content() }}
<div class="row">
	<div class="col-md-12">
		<div class="portlet light ">
			<div class="portlet-title">
				<div class="caption">                	
                    <span class="caption-subject font-blue-sharp bold uppercase">List of Users</span>
            	</div>
            	<div class="actions">
            		{{ link_to("users/index", "&larr; Go Back", "class": "btn btn-transparent red btn-sm") }}            		
            		<div class="btn-group">
                    	<a class="btn red btn-outline btn-circle" href="javascript:;" data-toggle="dropdown"><i class="fa fa-share"></i><span class="hidden-xs"> Tools </span><i class="fa fa-angle-down"></i></a>
                 		<ul class="dropdown-menu pull-right" id="sample_3_tools">
                       		<li><a href="javascript:;" data-action="0" class="tool-action"><i class="icon-printer"></i> Print</a></li>
                        	<li><a href="javascript:;" data-action="2" class="tool-action"><i class="icon-doc"></i> PDF</a></li>
                      		<li><a href="javascript:;" data-action="3" class="tool-action"><i class="icon-paper-clip"></i> Excel</a></li>
                    	</ul>
                	</div>
            	</div>
			</div>
			<div class="portlet-body">
				{% for user in page.items %}
				{% if loop.first %}
				<table class="table table-striped table-condensed table-light">
				    <thead>
				        <tr>
				            <th>Id</th>
				            <th>Name</th>
				            <th>Email</th>
				            <th>Profile</th>
				            <th>Banned?</th>
				            <th>Suspended?</th>
				            <th>Confirmed?</th>
				            <th>Actions</th>
				        </tr>
				    </thead>
				{% endif %}
				    <tbody>
				        <tr>
				            <td>{{ user.id }}</td>
				            <td>{{ user.name }}</td>
				            <td>{{ user.email }}</td>
				            <td>{{ user.profile.name }}</td>
				            <td>{{ user.banned == 'Y' ? 'Yes' : 'No' }}</td>
				            <td>{{ user.suspended == 'Y' ? 'Yes' : 'No' }}</td>
				            <td>{{ user.active == 'Y' ? 'Yes' : 'No' }}</td>
				            <td width="12%">{{ link_to("users/edit/" ~ user.id, '<i class="icon-pencil font-green"></i>', "class": "btn-xs") }} {{ link_to("users/delete/" ~ user.id, '<i class="fa fa-trash-o font-red"></i>', "class": "btn-xs") }}</td>
				            
				        </tr>
				    </tbody>
				{% if loop.last %}
				    <tbody>
				        <tr>
				            <td colspan="10" align="right">
				            	<div class="pull-left">{{ page.current }}/{{ page.total_pages }}</div>
				                <div class="btn-group">
				                    {{ link_to("users/search", '<i class="icon-fast-backward"></i> First', "class": "btn btn-xs") }}
				                    {{ link_to("users/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn btn-xs ") }}
				                    {{ link_to("users/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn btn-xs") }}
				                    {{ link_to("users/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn btn-xs") }}
				                    
				                </div>
				            </td>
				        </tr>
				    <tbody>
				</table>
				{% endif %}
				{% else %}
				    No users are recorded
				{% endfor %}
			</div>
		</div>
	</div>
</div>


