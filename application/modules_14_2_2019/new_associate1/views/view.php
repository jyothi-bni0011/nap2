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

<form action="<?php echo current_url(); ?>" method="POST">
	<input type="hidden" name="associate_id" value="<?php echo $associate_id; ?>">
	<input type="hidden" name="document_id" value="<?php echo $document_id; ?>">
	<div class="text-center">
		<button type="submit" name="verify" value="1" class="btn btn-primary">Verify</button>
	</div>
</form>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.min.js"></script>
<script>
	var options = {
		height: "1200px",
		pdfOpenParams: { view: 'FitV', page: '2' }
	};

	PDFObject.embed("<?php echo base_url('new_associate/read/' . $associate_id . '/' . $document_id); ?>", "#the-pdf", options);

</script>
