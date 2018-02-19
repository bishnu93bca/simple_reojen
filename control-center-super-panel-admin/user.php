<?php

require("../connect/db.php");

global $connection;

$active_tab = "user";
require_once('base.php');
$BaseClassObject = new Base();
$content = "home.php";

$BaseClassObject->loadView($active_tab);
$where = 1;
//$users = $BaseClassObject->getAllData('users',$where);

$usr = $connection->query("select * from users order by date_of_creation desc");

while($rows = $usr->fetch_assoc()){
	$users[] = $rows;
}


?>
<div class="content-wrapper">        
  <section class="content">
    <div class="row">
      <div class="col-md-12 col-xs-12 col-sm-12">
        <div class="box">
            <div class="box-header"> 
                <span><h1 class="box-title"><b> Users </b></h1></span>
                <!-- <span>
                    <a type="button" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-xs pull-right" style="margin: -3px 0px 0px 0px;">Add
                    </a>
                </span> -->
            </div>
            
            <div class="box-body">
                <table class="col-md-12 col-xs-12 col-sm-12 table table-striped table-condensed table-bordered" id="sample_1">
                    <thead>
                      <tr>
                        <th> <input type="checkbox" id="chkAll"></th>
                        <th>Mobile number </th>
                        <th>Name </th>
                        <th>Country </th>
                        <th>CompanyName </th>
						<th>Date Of Creation</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        if(!empty($users))
                        {
                          foreach ($users as $key => $value) 
                          {
                      ?>
                            <tr>
                                <td><input class="chkVal" type="checkbox" value="<?=$value['id']?>"><label for="option"></label></td>
                                <td><?=$value['mobile_no']?></td>
                                <td><?=$value['fname'].' '.$value['mname'].' '.$value['lname']?></td>
                                <td><?=$value['Country']?></td>
                                <td><?=$value['CompanyName']?></td>
								<td><?=($value['date_of_creation'] != 0) ? date("Y-m-d H:i:s",$value['date_of_creation']) : "" ?></td>								
                                <td>
                                <a href="edit_user.php?pid=<?=$value['user_id']?>" type="button" class="btn btn-xs btn-primary" style="margin: 2px;">
                                Edit
                                </a>
                            <!--     <a href="" onclick="return confirmDelete('../query.php?s_id=<?=$value['id']?>');" data-toggle="modal" type="button" class="btn btn-xs btn-danger deleteEventButton" style="margin: 2px;" data-id="<?php echo $value['id']; ?>">
                                Delete
                                </a> -->
                                </td>
                              </tr>                           
                        <?php } }
                      ?>
                    </tbody>
                </table>
				<table>
					<tr>
						<td>Go to page: <input type="text" id="pageSearch_text" style="width:30px;border: 1px solid rgb(164, 156, 156);"></input> <button class="btn bg-info" id="page_search">GO</button></td>
					</tr>
				</table>
                <button id="delAll" class="btn btn-xs btn-danger deleteEventButton" style="margin: 2px;" >
                Delete
                </button>
            </div>
        </div>
      </div>
    </div>
  </section>
</div>
<!-- Modal -->
<script type="text/javascript">
function confirmDelete(url) 
  {
    if (confirm("Are you sure you want to delete this?")) 
    {
        window.location.href=url;
    } 
    else 
    {
      return false;
    }
  }  
$(document).ready(function(){
   // to delete multiple files
   $("#delAll").click(function()
   {
    if (confirm("Are you sure you want to delete selected records?")) 
    {
      var id=[];
      var count = 0;
      $('.chkVal').each(function(index){
            if($(this).prop('checked'))
            {
              id[count] = $(this).val();
              count++;
            }
         });
      if(id.length !== 0)
      {
        $.ajax({
              type: "POST",
              url: "../query.php?del_id=1",
              data: {data:id},
              success: function(result) 
              { 
                if(result);
                {
                  alert('Deleted successfully'); 
                  window.location.reload();
                }
              }       
        });
      }
      else
      {
        alert('Please select atleast one row');
      } 
    } 
    else 
    {
      return false;
    }            
   });           //for check all
   $('#chkAll').click(function(){
     if($(this).prop('checked'))
     {
        $('.chkVal').prop('checked', true);
     }
     else
     {
        $('.chkVal').prop('checked',false);
     }    
   });
 });
</script>
<?php
$BaseClassObject->getFooterView();
?>