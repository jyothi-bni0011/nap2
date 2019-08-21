<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
<?php if ( $document->document_type == 2 ): ?>
	<?php //print_r( $document ); print_r($associate_document); ?>
	<div class="card-header bg-danger"><span class="card-title">Instruction</span></div>
	<div class="card-body generate-variable pl-3 pr-3 pt-3 pb-0">
		<?php 
			$url = "";
			if ( $associate_document->file_url != '' ) 
			{
				$url = base_url() . $associate_document->file_url;	
			} 
			else
			{
				$url = base_url('assets/uploaded_documents/' . $document->document_template );
			}
		?>
		Please download the document <a href="<?= $url; ?>" data-toggle="tooltip" title="Download" download><?= $document->document_title; ?></a> for editing. After editing upload it.
		<br>
		<a href="<?= $url; ?>" class="btn bg-success p-2 btn-circle" data-toggle="tooltip" title="Download" download><i class="fa fa-download" aria-hidden="true"></i> &nbsp; Download PDF</a>

		&nbsp; &nbsp; &nbsp; 
		
		<?php if( $document->document_type == 2 AND $associate_document->status == 1 || $associate_document->status == 3 ): ?>
			<a href="javascript:" class="btn bg-success p-2 btn-circle" onclick="call_upload_file();return false;" data-toggle="tooltip" title="Upload"><i class="fa fa-upload" aria-hidden="true"></i>&nbsp; Upload PDF</a>
			<span style="font-size: smaller;" id="file_info"><i>(Max allowed Size: <?php echo ini_get('upload_max_filesize'); ?>)<i/></span>
			<form id="upload_file_form" method="post" name="upload_file_form" enctype="multipart/form-data" action="<?php echo base_url('document/generate/upload_by_new_associate') ?>">
				<input type="file" name="upload_file" id="upload_file" style="display: none;" accept="application/pdf">
				<input type="hidden" name="doc_id" id="doc_id" value="<?=$document->document_id;?>">
				<input type="hidden" name="associate_id" value="<?=$associate_document->user_id;?>">
				<?php if( array_key_exists('from', $_GET) ): ?>
					<input type="hidden" name="from" value="1">
				<?php endif; ?>
			</form>
		<?php else: ?>
			<span style="font-size: smaller;" ><i>Document Already Uploaded<i/></span>
		<?php endif; ?>

	</div>
<?php else: ?>
<div class="row">
	<div class="col-md-3">
		<?php if( $_GET ): ?>
			<?php if( $_GET['r'] == 'view' ): ?>
				<form class="card card-primary border-0" method="POST" action="<?php echo current_url().'?r=view'; ?>" autocomplete="off">
			<?php else: ?>
				<form class="card card-primary border-0" method="POST" action="<?php echo current_url().'?r=dashboard'; ?>" autocomplete="off">
			<?php endif; ?>
		<?php else: ?>
		<form class="card card-primary border-0" method="POST" enctype="multipart/form-data" action="<?php echo current_url(); ?>" autocomplete="off">
		<?php endif; ?>
			<input type="hidden" name="document_id" value="<?php echo $document->document_id; ?>">
			<div class="card-header bg-danger"><span class="card-title">Available variables</span></div>
			<div class="card-body generate-variable pl-3 pr-3 pt-3 pb-0">
				<?php if( ! empty($variables) ): foreach ($variables as $variable): ?>
				<?php $varname = "var_" . str_replace(['{','}'], "", $variable->varname); ?>
				<div class="form-group">
					<?php if ( array_key_exists($varname, $signature_variables) ): ?>
						<input type="hidden" name="<?php echo $varname; ?>" > 

						<button name="<?php echo $varname; ?>" class="<?php echo $varname; ?>" id="signature" onclick="return false;"><?php echo $variable->field_name; ?></button>
					<?php else: ?>
                                            <?php if($variable->type_id==1):?>
                                                <input type="radio" name="var_feild_radio" id="<?php echo $varname; ?>" class="update-changes" value="<?php echo $variable->varname; ?>" required="">
                                            
                                                <?php echo $variable->field_name; endif; ?>
                                            <?php if($variable->type_id==0):?>
                                            <label for="" class="small mb-0"><?php echo $variable->field_name; ?></label>
                                            <input type="text" name="<?php echo $varname; ?>" id="<?php echo $varname; ?>" class="form-control update-changes" value="<?php echo set_value($varname); ?>">
                                            
                                                <?php endif; ?>
                                             <?php if($variable->type_id==2):?>
                                            <input type="hidden" name="<?php echo $varname; ?>" value="<?php echo $varname; ?>">
                                           <input type="file" id="fileinput" name="variable_file" style="height:0;overflow:hidden;">
						<button name="<?php echo $varname; ?>" class="<?php echo $varname; ?>" id="attachment" onclick="return false;"><?php echo $variable->field_name; ?></button>

                                            <div class="preview"></div>
                                          
                                             <?php endif; ?>
                                            
                                        <?php endif; ?>
				</div>
				<?php endforeach; else: ?>
				<a href="#" class="no-variable border-0 list-group-item list-group-item-action">Read and Review –  No signature is required.</a>
				<?php endif; ?>
			</div>
			<button class="btn bg-danger btn-block" type="submit">Create Document</button>
		</form>
                                  
	</div>
    
	<div class="col-md-9">
		<?php if( !empty($message) ) echo $message; ?>
		<div class="card card-primary generate-document">
			<div class="card-body">
				<?php echo $template; ?>
			</div>
		</div>
	</div>
    
</div>
<?php endif; ?>

<div class="modal fade" id="signature_modal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="signature-block">
					<canvas id="signature-pad" class="signature-pad" width="470" height="200"></canvas>
				</div>
			</div>
			<div class="modal-footer">
				<input type="file" name="upload" class="hidden">
				<button type="submit" class="btn btn-secondary" id="clear_signature">Clear</button>
				<button type="submit" class="btn btn-primary" id="save_signature">Save</button>
				<button type="submit" class="btn btn-primary" id="upload_signature">Upload</button>
			</div>
		</div>
	</div>
</div>

<script>
 $("#attachment").click(function() {
    
    $("#fileinput").click();
    
  });

  $("#fileinput").change(function() {
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = imageIsLoaded;
      reader.readAsDataURL(this.files[0]);
    }
  });

  function imageIsLoaded(e) {
    var x = 'foo';
    
    var attachment_var = $('input[name="var_voided_check_attachment"]').val();
//    $('.generate-document .' + attachment_var ).empty().append(picture);
			$('.generate-document .' + attachment_var ).after('<span class="' + attachment_var + '"><img src="' + e.target.result + '"  class="img-responsive"/></span>').remove();
			$('form input[name="' + attachment_var + '"]').val(e.target.result);
  }
    
	$(document).ready(function(){
		var file_msg = '<i>(Max file size : <?php echo ini_get('upload_max_filesize'); ?> )<i/>'
		$('input[type="file"]').on('change',function(){
			if ( this.files[0].size < 36700160 ) 
	    	{	
		        $('#file_info').html(file_msg);
				$("#upload_file_form").submit();
	    	}
	    	else
	    	{
	    		$('#file_info').html('<i style="color:red;">(Max file size exceeded.)<i/>');
	    	}
		});
	});

	function call_upload_file()
	{
		$("#upload_file").click();
	}
	
	SignaturePad.prototype.removeBlanks = function () {
		var imgWidth = this._ctx.canvas.width;
		var imgHeight = this._ctx.canvas.height;
		var imageData = this._ctx.getImageData(0, 0, imgWidth, imgHeight),
		data = imageData.data,
		getAlpha = function(x, y) {
			return data[(imgWidth*y + x) * 4 + 3]
		},
		scanY = function (fromTop) {
			var offset = fromTop ? 1 : -1;

			// loop through each row
			for(var y = fromTop ? 0 : imgHeight - 1; fromTop ? (y < imgHeight) : (y > -1); y += offset) {

				// loop through each column
				for(var x = 0; x < imgWidth; x++) {
					if (getAlpha(x, y)) {
						return y;                        
					}      
				}
			}
			return null; // all image is white
		},
		scanX = function (fromLeft) {
			var offset = fromLeft? 1 : -1;

			// loop through each column
			for(var x = fromLeft ? 0 : imgWidth - 1; fromLeft ? (x < imgWidth) : (x > -1); x += offset) {

				// loop through each row
				for(var y = 0; y < imgHeight; y++) {
					if (getAlpha(x, y)) {
						return x;                        
					}      
				}
			}
			return null; // all image is white
		};

		var cropTop 	= scanY(true),
			cropBottom 	= scanY(false),
			cropLeft 	= scanX(true),
			cropRight 	= scanX(false);

		var relevantData = this._ctx.getImageData(cropLeft, cropTop, cropRight-cropLeft, cropBottom-cropTop),canvas_width = (cropRight-cropLeft < 200)? 200:cropRight-cropLeft;

		this._canvas.width = canvas_width;
		this._canvas.height = cropBottom-cropTop;
		this._ctx.clearRect(0, 0, cropRight-cropLeft, cropBottom-cropTop);
		this._ctx.putImageData(relevantData, 0, 0);
	};

	SignaturePad.prototype.removeWhites = function () {
		var imgWidth 	= this._ctx.canvas.width;
		var imgHeight 	= this._ctx.canvas.height;
		var imageData 	= this._ctx.getImageData(0, 0, imgWidth, imgHeight);
		var pix 		= imageData.data;
		var newColor 	= {r:0,g:0,b:0, a:0};

		for (var i = 0, n = pix.length; i <n; i += 4) {
			var r = pix[i],
				g = pix[i+1],
				b = pix[i+2];

			if(r == 255 && g == 255 && b == 255) { 
				pix[i] = newColor.r;
				pix[i+1] = newColor.g;
				pix[i+2] = newColor.b;
				pix[i+3] = newColor.a;
			}
		}

		this._ctx.putImageData(imageData, 0, 0);

	};
        
       
</script>
<style type="text/css">
	.generate-variable [class*="var_"] { /*font-size: 0px;*/color: white; height: 30px; width: 100%; background: #bd2130!important; border-radius: 2px; cursor: pointer; border: 0; }
</style>