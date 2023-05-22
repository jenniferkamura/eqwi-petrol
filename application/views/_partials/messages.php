
<style type="text/css">

.alert {
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
    width: 50%;
}

.alert-success {
    color: #3c763d;
    background-color: #dff0d8;
    border-color: #d6e9c6;
  }

.alert-info{

    color: #31708f;
    background-color: #d9edf7;
    border-color: #bce8f1;
  } 

.alert-warning{   
    color: #8a6d3b;
    background-color: #fcf8e3;
    border-color: #faebcc;
  } 

.alert-danger
{
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
}

</style>


 <?php if($this->session->flashdata('success')){?>
  <div class="col-md-3 col-md-offset-3 alert alert-success">
     <i class="fa fa-check"></i>
      <?php echo $this->session->flashdata('success'); ?>       
  </div>
<?php } ?>

 <?php if($this->session->flashdata('error')){?>
  <div class="col-md-3 col-md-offset-3 alert alert-danger">
     <i class="fa fa-times"></i>
      <?php echo $this->session->flashdata('error'); ?>
  </div>
<?php } ?>

<?php if($this->session->flashdata('info')){?>
  <div class="col-md-3 col-md-offset-3 alert alert-info">
     <i class="fa fa-info-circle"></i>
      <?php echo $this->session->flashdata('info'); ?>
  </div>
<?php } ?>

 <?php if($this->session->flashdata('warning')){?>
  <div class="col-md-3 col-md-offset-3 alert alert-warning">
     <i class="fa fa-exclamation-triangle"></i>
      <?php echo $this->session->flashdata('warning'); ?>
  </div>
<?php } ?>
<div class="clearfix"></div>