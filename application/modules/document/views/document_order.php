<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
    <div class="page-title-breadcrumb">
        <div class=" pull-left">
            <div class="page-title"><?= $title; ?></div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url('dashboard'); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
            </li>
            <li class="active"><?= $title; ?></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <?php if (!empty($message)) echo $message; ?>
        <div><?php echo $this->session->flashdata('message'); ?></div>
        <div class="card card-box">
            <div class="card-body" id="bar-parent">
                <form id="assign_doc" method="POST" action="<?php echo base_url('document/assign_document'); ?>" class="form-horizontal" autocomplete="off">
                    <div class="form-body">
                        <div class="container">
                            <a href="javascript:void(0);" class="reorder_link" id="saveReorder">Reorder documents</a>
                            <div id="reorderHelper" class="light_box" style="display:none;">1. Drag Document to reorder.<br>2. Click 'Save Reordering' when finished.</div>
                            <div class="gallery">
                                   
                                            <ul class="reorder_ul reorder-category-list">
                                                
                                                <?php /*echo "Tatal Documents:". count($documents);*/foreach ($documents as $key => $doc): if ($doc->{DOCUMENT_ID}){ ?>
                                                <li id="image_li_<?= $doc->{DOCUMENT_ID} ?>" class="ui-sortable-handle">
                                                    <a href="javascript:void(0);" style="float:none;" class="image_link">
                                                       <?= $doc->{DOCUMENT_TITLE} ?>
                                                    </a>
                                                </li>
                                                <?php } ?>
                                            <?php  endforeach; ?>
                                            </ul>
                                   
                            </div>
                        </div>


                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .container{
    margin-top:50px;
    padding: 10px;
}
ul, ol, li {
    margin: 0;
    padding: 0;
    list-style: none;
}
.reorder_link {
    color: #3675B4;
    border: solid 2px #3675B4;
    border-radius: 3px;
    text-transform: uppercase;
    background: #fff;
    font-size: 18px;
    padding: 10px 20px;
    margin: 15px 15px 15px 0px;
    font-weight: bold;
    text-decoration: none;
    transition: all 0.35s;
    -moz-transition: all 0.35s;
    -webkit-transition: all 0.35s;
    -o-transition: all 0.35s;
    white-space: nowrap;
}
.reorder_link:hover {
    color: #fff;
    border: solid 2px #3675B4;
    background: #3675B4;
    box-shadow: none;
}
#reorder-helper{
    margin: 18px 10px;
    padding: 10px;
}
.light_box {
    background: #efefef;
    padding: 20px;
    margin: 15px 0;
    text-align: center;
    font-size: 1.2em;
}

/* image gallery */
.gallery{
    width:100%;
    float:left;
    margin-top:15px;
}
.gallery ul{
    margin:0;
    padding:0;
    list-style-type:none;
}
.gallery ul li{
    padding:7px;
    border:2px solid #ccc;
    float:left;
    margin:10px 7px;
    background:none;
    width:auto;
    height:auto;
}
.gallery img{
    width:250px;
}

/* notice box */
.notice, .notice a{
    color: #fff !important;
}
.notice {
    z-index: 8888;
    padding: 10px;
    margin-top: 20px;
}
.notice a {
    font-weight: bold;
}
.notice_error {
    background: #E46360;
}
.notice_success {
    background: #657E3F;
}
    .panel-default>.panel-heading {
        color: #333;
        background-color: #f5f5f5;
        border-color: #ddd;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script type="text/javascript">
                                        $(document).ready(function () {
                                            $('.reorder_link').on('click', function () {
                                                $("ul.reorder-category-list").sortable({tolerance: 'pointer'});
                                                $('.reorder_link').html('save reordering');
                                                $('.reorder_link').attr("id", "saveReorder");
                                                $('#reorderHelper').slideDown('slow');
                                                $('.image_link').attr("href", "javascript:void(0);");
                                                $('.image_link').css("cursor", "move");

                                                $("#saveReorder").click(function (e) {
                                                    if (!$("#saveReorder i").length) {
                                                        $(this).html('').prepend('<img width="20px" src="<?php echo base_url();?>assets/img/refresh-animated.gif"/>');
                                                        $("ul.reorder-category-list").sortable('destroy');
                                                        $("#reorderHelper").html("Reordering Documents - This could take a moment. Please don't navigate away from this page.").removeClass('light_box').addClass('notice notice_error');

                                                        var h = [];
                                                        $("ul.reorder-category-list li").each(function () {
                                                            h.push($(this).attr('id').substr(9));
                                                        });

                                                        $.ajax({
                                                            type: "POST",
                                                            url: "<?php echo base_url().'document/assign_document/document_order';?>",
                                                            data: {ids: " " + h + ""},
                                                            success: function (data) {
//                                                                console.log(data);
                                                                window.location.reload();
                                                            }
                                                        });
                                                        return false;
                                                    }
                                                    e.preventDefault();
                                                });
                                            });
                                        });
</script>