<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Datatable with mysql</title>
<link rel="stylesheet" id="font-awesome-style-css" href="http://phpflow.com/code/css/bootstrap3.min.css" type="text/css" media="all">

<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">

<!-- jQuery -->
<script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>

<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>

<div class="container">
   <table id="example" class="display" width="100%" cellspacing="0">
       <thead>
           <tr>
               <th>Title</th>
               <th>Description</th>
               <th>Category</th>
               <th>Display Url</th>
           </tr>
       </thead>

       <tfoot>
           <tr>
             <th>Title</th>
             <th>Description</th>
             <th>Category</th>
             <th>Display Url</th>
           </tr>
       </tfoot>
   </table>
   </div>

<script>
$( document ).ready(function() {
$('#example').dataTable({
				 "bProcessing": true,
         "bServerSide" : true,
         "sAjaxSource": "https://www.skearch2.com/datatable/get",
				 "aoColumns": [
						            { mData: 'title' } ,
                        { mData: 'description_short' },
                        { mData: 'stitle' },
                        { mData: 'display_url' }
                ]
        });
});
</script>
