<style type="text/css">
  .modal-backdrop
{
    opacity:1 !important;
}
</style>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h4 class="modal-title">Select Your Role</h4>
        
      </div>
      <div class="modal-body">
        <form method="post" id="select_role" action="<?php echo base_url('select_user_role'); ?>" autocompleate="off">
          <div class="form-group row">
            <label class="control-label col-md-3">Log in as :
              <span class="required">  </span>
            </label>
            <div class="col-md-5">
              <select class="form-control input-height" name="user_role" id="user_role">
                                 <option value="">Select Role </option>
                                 <?php foreach($roles as $role): ?>
                                    
                                  <option value="<?php echo $role->role_id; ?>" > <?php echo $role->role_name; ?> </option>
                                
                             <?php endforeach; ?>
                              </select> 
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Select</button>
        </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
    $(window).on('load',function(){

        $('#myModal').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#myModal').modal('show');
    });
</script>