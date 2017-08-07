<?php 
	require_once("libs/conn_203.php");
	$objDb = new Db();
	$db = $objDb->database;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Report 1</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>

	<div class="container">
		<div class="row">
			<div class="page-header text-center">
				<h3>รายงานแสดงข้อมูลศูนย์ต่างประเทศ</h3>
			</div>
		</div>
		<div class="row">
			<form action="index.php" method="post">
				<div class="text-center">
					<div class="col-md-offset-2 col-md-8 col-md-offset-2">
						<div class="form-group">
							<div class="col-md-2">
								<label>วันที่อนุมัติ</label>
							</div>
							<div class="col-md-4">
								<input type="date" name="startdate" class="form-control" value="<?php echo $_POST['startdate']; ?>">
							</div>
							<div class="col-md-2">
								<label>จนถึงวันที่</label>
							</div>
							<div class="col-md-4">
								<input type="date" name="enddate" class="form-control" value="<?php echo $_POST['enddate']; ?>">
							</div>
						</div>

						<br>

						<div class="form-group">
							<div class="col-md-2">
								<label>สาขา</label>
							</div>
							<div class="col-md-10">
								<select class="form-control">
									<option> -- กรุณาเลือกสาขา -- </option>
								</select>
							</div>
						</div>

						<br>

						<div class="form-group">
							<div class="col-md-2">
								<label>ประเทศ</label>
							</div>
							<div class="col-md-10">
								<select class="form-control" name="country" required>
		                            <option value=""> -- เลือกประเทศ -- </option>
		                            <?php
		                            $query = $db->prepare("SELECT * FROM Country");
		                            $query->execute();
		                              while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
		                            ?>
		                            <option value="<?=$row['CountryID']?>"><?=$row['CountryName']?></option>
		                            <?php } ?>
	                            </select>
							</div>
						</div>

						<br>

						<div class="form-group" style="float: right;padding-right: 15px">
							<button class="btn btn-success" type="submit" >รายงาน</button>
							<button class="btn btn-danger" type="reset" >ล้างค่า</button>
						</div>
					</div>
				</div>
			</form>
		</div>

		<hr>

		<?php 
			$query = $db->prepare("SELECT TOP 10 b.BranchID,b.BranchName,b.OpenDate,p.ProvinceName,c.CountryName FROM WalletBranch b INNER JOIN Province p ON p.ProvinceID = b.ProvinceID INNER JOIN Country c ON c.CountryID = b.CountryID WHERE b.CountryID = CONVERT(VARCHAR(50), :country) AND b.OpenDate BETWEEN :startdate AND :enddate");
            $query->execute(['country'=>$_POST['country'],'startdate'=>$_POST['startdate'],'enddate'=>$_POST['enddate']]);
		?>
		<div class="row">
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th class="text-center">วันที่</th>
							<th class="text-center">รหัสสาขา</th>
							<th class="text-center">ชื่อสาขา</th>
							<th class="text-center">ประเภทสาขา</th>
							<th class="text-center">จังหวัด</th>
							<th class="text-center">ประเทศ</th>
						</tr>
					</thead>
					<?php
	                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
	                  ?>
					<tbody>
						<tr>
                      		<td><?=$row['OpenDate']?></td>
                      		<td><?=$row['BranchID']?></td>
                      		<td><?=$row['BranchName']?></td>
                      		<td><?=$row['TypeID']?></td>
                      		<td><?=$row['ProvinceName']?></td>
                      		<td><?=$row['CountryName']?></td>
						</tr>
					</tbody>
					<?php } ?>
				</table>
			</div>
		</div>
	</div>

	<script type="text/javascript" scr="js/bootstrap.min.js"></script>
	<script type="text/javascript" scr="js/jquery.js"></script>
</body>
</html>