<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title"><?= $title; ?></div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
			</li>
                        <li class="active"><?= $title; ?></li>
        </ol>
    </div>
</div>
<div><?php echo $this->session->flashdata('message');?></div>
<div class="row">
	<div class="col-md-12">
		<div class="card  card-box">
			<div class="card-body ">
				<!-- <div class="col-md-6">
        			<select class="form-control" id="department">
        				<option value="0">Select Department</option>
        				<option value="1">Job Title</option>
        				<option value="2">Organizational Unit</option>
        				<option value="3">Functional Area</option>
        				<option value="4">Department</option>
        			</select>
        		</div> -->
				<div class="table-scrollable">
					<table id="tableExport1" class="display table table-hover table-checkable order-column m-t-20" style="width: 100%">
						<thead>
							<tr>
								<th>Sr No</th>
								<th> Username </th>
								<th> Job Title  </th>
								<th> Department   </th>
								<th> Functional Area        </th>
								<th> Organizational Unit    </th>
								<th> Start Date    </th>
								
							</tr>
                        </thead>
                        <tbody>
                     	<?php $i=1; foreach($new_associates as $new_associate): ?>
                     		<tr class="odd gradeX">
								<td><?= $i++;?></td>
								<td><?php echo $new_associate->{NEW_ASSOCIATE_USERNAME}; ?></td>
								<td><?php echo $new_associate->{JOB_POSITION_CODE}; ?></td>
								<td><?php echo $new_associate->{DEPARTMENT_NAME}; ?></td>
								<td><?php echo $new_associate->{FUNCTIONAL_AREA_NAME}; ?></td>
								<td><?php echo $new_associate->{ORGANIZATIONAL_UNIT_NAME}; ?></td>
								<td><?php echo $new_associate->{NEW_ASSOCIATE_START_DATE}; ?></td>
								
							</tr>
                     	<?php endforeach; ?>
                     	<!-- <tfoot>
				            <tr>
				                <th>Sr No</th>
								<th> Username </th>
								<th> Job Title  </th>
								<th> Department   </th>
								<th> Functional Area        </th>
								<th> Organizational Unit    </th>
								<th> Start Date    </th>
				            </tr>
				        </tfoot> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body">
				Are you sure you want to deactivate this record?
			</div>
			<div class="modal-footer">
				<form method="post">
					<input type="hidden" name="site_id" id="site_id" value="">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="submit" id="site_submit" class="btn btn-danger">Deactivate</button>
				</form>
			</div>
		</div>
	</div>
</div>	
<div class="modal fade" id="act_exampleModalCenter" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body">
				Are you sure you want to activate this record?
			</div>
			<div class="modal-footer">
				<form method="post">
					<input type="hidden" name="act_site_id" id="act_site_id" value="">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="submit" id="act_site_submit" class="btn btn-success">Activate</button>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="delete_role" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body">
				Are you sure you want to delete this record?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-danger category_id" data-id="">Delete</button>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	var title = '<?php echo $this->session->userdata('role_name'); ?>' + ' portal';
    $('#tableExport1').DataTable( {
		"ordering": false,
    	dom: 'Bfrtip',
        buttons: [
        {
        	extend: 'copyHtml5',
			filename: title
        },
        {
        	extend: 'excelHtml5',
			filename: title
        },    
            
        {
        	extend: 'csvHtml5',
			filename: title
        },
        {
        	extend: 'pdfHtml5',
			filename: title
        }, 
		
		],
        initComplete: function () {
            this.api().columns([1,2,3,4]).every( function () {
                var column = this;
                var select = $('<select><option value="">--select--</option></select>')
                    .appendTo( $(column.header()) )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
    } );
} );
</script>						