<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title">New Associate Documents</div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url();?>/Dashboard">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
			</li>
			<li class="active">New Associate Documents</li>
		</ol>
	</div>
</div>
<div id="the-pdf"></div>

<?php if( $verify ) : if( $this->session->userdata('role_id') != 4 ) : ?>
	<div class="row">
		<div class="col-md-6">	
			<!-- <form action="<?php //echo current_url().'/1'; ?>" method="POST">
				<input type="hidden" name="associate_id" value="<?php //echo $associate_id; ?>">
				<input type="hidden" name="document_id" value="<?php //echo $document_id; ?>"> -->
				<div class="text-right">
					<button type="submit" name="verify" value="1" class="btn btn-danger" data-toggle="modal" data-target="#reject_document">Decline</button>
				</div>
			<!-- </form> -->
		</div>
		<div class="col-md-6">
			<form action="<?php echo current_url(); ?>" method="POST">
				<input type="hidden" name="associate_id" value="<?php echo $associate_id; ?>">
				<input type="hidden" name="document_id" value="<?php echo $document_id; ?>">
				<div class="">
					<button type="submit" name="verify" value="1" class="btn btn-primary">Verify</button>
				</div>
			</form>
		</div>
	</div>
<?php endif; endif; ?>

<div class="modal fade" id="reject_document" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<form class="modal-content" id="modal-form" method="post" action="<?php echo current_url().'/1'; ?>" autocomplete="off">
			<div class="modal-header bg-danger">
				<h5 class="modal-title m-0">Reject Document</h5>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<input type="hidden" name="associate_id" value="<?php echo $associate_id; ?>">
					<input type="hidden" name="document_id" value="<?php echo $document_id; ?>">
					<label for="" class="small">
						Comment
						<span class="required"> * </span>
					</label>
					<textarea name="comment" id="comment" class="form-control" placeholder="Write Comment For Rejection In 255 Characters" required></textarea>
					<!-- <input type="text" name="field_name" value="" class="form-control" placeholder="Field Name" required> -->
				</div>
			</div>
			<div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		        <button type="submit" class="btn btn-primary">Decline</button>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.min.js"></script>
<script>
	$(document).ready(function(){
		$( "#modal-form" ).validate({
			rules: {
				comment: {
		      		required: true,
		      		maxlength: 255
		    	}
			}
			
		});
	});

	var options = {
		height: "1200px",
		pdfOpenParams: { view: 'FitV', page: '2' }
	};

	PDFObject.embed("<?php echo base_url('new_associate/read/' . $associate_id . '/' . $document_id); ?>", "#the-pdf", options);

</script>
