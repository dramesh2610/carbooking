<!DOCTYPE html>
<html>
<head>
    <title>Carlist</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>/Assets/css/main.css" />
<style>

</style>
</head>
<body>
	<div class="wrapper">
  
  <h2 class="hero-headline typography-hero-headline">CarzzeeGO. It’s in the&nbsp;Air.</h2>
  
</div>

<div class="container-fluid">
	<div class="car-search" style="display: flex; width: 41.1%; padding:10px">
		<h5 style="width: 25%;">
			Year Search:
		</h5>
		<select class="form-control" id='search_year' onChange='yearsearch()'>
			<option>Select year</option>
			<?php
				for($i = 1909; $i <= 2020; $i++) {
					echo "<option>".$i."</option>";
				}
			?>
		</select>
	</div>
	<div class="car-data row" id="total_data">
		<!-- Column 1 -->
		<?php include_once 'company_list_view.php'; ?>
		<!-- Column 2 -->
		<?php include_once 'car_list_view.php'; ?>
		<!-- Column 3 -->
		<?php include_once 'car_data_view.php'; ?>
	</div>
</div>



</body>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#campanylist').DataTable();
    } );
    $(document).ready(function() {
        $('#carlist').DataTable({searching: false, paging: false, info: false});
    } );
    // get the list of cars and display in column 2
	function carlist() {
		var companyId = "#"+event.target.id;
		var companyName = $(companyId).text();
		$.ajax({
			url: "<?php echo base_url()?>/home/getCarList",
			type: 'POST',
			dataType:'json',
			data : {
				companyName : companyName,
			},
			success:function(data){
				var rowData=[];
				for(var i = 0; i < data.length ; i++) {
					var row = "<tr>"+
						"<td onclick='cardata()' id="+data[i]['id']+">"+data[i]['car_model']+"</td>"+
					"</tr>";
					rowData.push(row);
				}
				$("#car_list_tr").html(rowData);
			}
		});
	}
	// get the list of cars and display in column 3
	function cardata() {
		var carModelId = event.target.id;
		$.ajax({
			url: "<?php echo base_url()?>/home/getCarData",
			type: 'POST',
			dataType:'json',
			data : {
				carModelId : carModelId,
			},
			success:function(data){
				var car_detail = "<div class='card' style='margin-top: 40px; padding-top: 10px;'>"+
					"<div class='card-header'><label>CAR DETAIL</label></div>"+
						"<img src='https://static.tcimg.net/vehicles/primary/f8dbd13868cae982/2020-Acura-MDX-white-full_color-driver_side_front_quarter.png' alt='Cars' style='width:100%'>"+
						"<h1>"+data[0].name+"</h1>"+
						"<p class='price'>Price:"+data[0].year+" $</p>"+
						"<p><b>Year:</b>" +data[0].year+"</p>"+
						"<p><b>Company:</b>" +data[0].company+"</p>"+
						"<a href='<?php echo base_url() ?>/stripContoller'><button class='btn btn-primary'>Buy</button></a>"+
					"</div>";
				$("#car_detail").html(car_detail);
			}
		});
	}

	// Year based search
	function yearsearch() {
		var yearSearch = $("#search_year").val();
		$.ajax({
			url: "<?php echo base_url()?>/home/getYearData",
			type: 'POST',
			dataType:'json',
			data : {
				yearSearch : yearSearch,
			},
			success:function(data){
				var yearSearchData = data;
				console.log(data);
				var rowData=[];
				if(data.length < 1){
					var row = "<tr><td>Oops! No data available.</td></tr>";
					rowData.push(row);
				}
				for(var i = 0; i < data.length ; i++) {
					var row = "<tr><td onclick='carlist()' id="+data[i]['company']+">"+data[i]['company']+"</td></tr>";
					rowData.push(row);
				}
				$("#company_list_tr").html(rowData)
			}
		});
	}

	function buyData() {
		buyCarId = event.target.id;
		$.ajax({
			url: "<?php echo base_url()?>/home/buyDataInsert",
			type: 'POST',
			dataType:'json',
			data : {
				buyCarId : buyCarId,
			},
			success:function(data){
			}
		});
	}
</script>

</html>
