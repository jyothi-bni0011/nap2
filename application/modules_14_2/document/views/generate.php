<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
<div class="row">
	<div class="col-md-3">
		<form class="card card-primary border-0" method="POST" action="<?php echo current_url(); ?>" autocomplete="off">
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
					<label for="" class="small mb-0"><?php echo $variable->field_name; ?></label>
					<input type="text" name="<?php echo $varname; ?>" class="form-control update-changes" value="<?php echo set_value($varname); ?>">
					<?php endif; ?>
				</div>
				<?php endforeach; else: ?>
				<a href="#" class="no-variable border-0 list-group-item list-group-item-action">No variables are assigned for this document.</a>
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