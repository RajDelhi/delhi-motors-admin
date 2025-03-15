<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>

<!-- ****************************** -->
<?php // echo "<pre>"; print_r($list); ?>

<!-- Start Banner -->
<div class="banner" id="banner">
	<div class="row">
		<div class="banner-inner columns">
			<h1 class="banner-title">Item List</h1>
		</div>
	</div>
</div>
<!-- End Banner -->

<!-- start main -->
<main id="main">
	<div class="row main-inner">
		<div class="content full-width column">
			<?php $count_list = !empty($list) ? count($list) : 0; ?>
			<h2>Your Dashboard of Items - <?= $count_list; ?> #  Listings</h2>

			<div class="content-buttons">
				
				<a href="<?php echo base_url() . 'add-item'; ?>" id="add_item" class="button">
					<i class="fas fa-plus small-margin-right"></i> Add New Item
				</a>


				<?php if (is_admin()): ?>
<!--					<a href="<?= base_url() . 'all-list' ?>" id="add" class="button">
						<i class="fas fa-plus small-margin-right"></i> View All Listing
					</a>-->

					<a href="<?= base_url() . 'all-user' ?>" id="add" class="button">
						<i class="fas fa-plus small-margin-right"></i> View All Users
					</a>
				<?php endif; ?>
			</div>

			<div style="float:left; margin-bottom:20px; background-color:lightgreen">
				<?php echo !empty(session()->getFlashdata('success_smg')) ? session()->getFlashdata('success_smg') : ""; ?>
			</div>

			<?php if (!empty($list)): ?>
				<table id="mlsTable">
					<thead>
						<tr>
							<th>Item Name</th>
							<th>HSN Code</th>
							<th>Unit Type</th>
							<th>CGST Rate</th>
							<th>SGST Rate</th>
							<th>Edit</th>
							<th>Delete</th>
							
						</tr>
					</thead>

					<tbody>
						<?php foreach ($list as $item_list): ?> <!-- Sample Data Rows -->
							<?php $id = !empty($item_list['id']) ? $item_list['id'] : ""; ?>
							<tr id="row_<?php echo $id; ?>">
								<td><?= !empty($item_list['name']) ? $item_list['name'] : ""; ?></td>
								<td><?= !empty($item_list['hsn_code']) ? $item_list['hsn_code'] : ""; ?></td>
								<td><?= !empty($item_list['unit']) ? $item_list['unit'] : ""; ?></td>
								<td><?= !empty($item_list['cgst_tax_rate']) ? $item_list['cgst_tax_rate'] : ""; ?></td>
								<td><?= !empty($item_list['sgst_tax_rate']) ? $item_list['sgst_tax_rate'] : ""; ?></td>
								<!-- <td><?php // echo  !empty($item_list['created_at']) ? date("d/m/Y   ", strtotime($item_list['created_at'])) : ""; ?></td> -->
								<td>
									<a href="<?php echo base_url() . 'edit-item/' . base64_encode($id); ?>"
										class="button no-button">
										Edit
									</a>
								</td>
								<td>
									<a href="javascript:void(0)" class="button no-button"
										onclick="delete_item(<?php echo $id; ?>)">
										Delete
									</a>
								</td>
								
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<div class="pagination">
					<button id="prevPage" onclick="prevPage()">Previous</button>
					<span id="pageInfo"></span>
					<button id="nextPage" onclick="nextPage()">Next</button>
				</div>
			<?php else: ?>
				<div style=" text-align:center;"> No Record Found</div>
			<?php endif; ?>
		</div>
	</div>
</main>
<!-- start main  -->

<script>
	const table = document.getElementById('mlsTable').getElementsByTagName('tbody')[0];
	const rowsPerPage = <?php echo PER_PAGE_RECORD; ?>;
	let currentPage = 1;

	function renderTable() {
		const rows = Array.from(table.getElementsByTagName('tr'));
		const totalPages = Math.ceil(rows.length / rowsPerPage);

		rows.forEach((row, index) => {
			row.style.display = 'none';
			if (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage) {
				row.style.display = '';
			}
		});

		document.getElementById('pageInfo').textContent = `Page ${currentPage} of ${totalPages}`;
		document.getElementById('prevPage').disabled = currentPage === 1;
		document.getElementById('nextPage').disabled = currentPage === totalPages;
	}

	function prevPage() {
		if (currentPage > 1) {
			currentPage--;
			renderTable();
		}
	}

	function nextPage() {
		const totalPages = Math.ceil(table.getElementsByTagName('tr').length / rowsPerPage);
		if (currentPage < totalPages) {
			currentPage++;
			renderTable();
		}
	}

	// Initialize the table with pagination
	renderTable();
</script>

<!-- ****************************** -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
	function delete_item(list_id) {
		if (!confirm('Are you sure you want to delete this list item?')) {
			return false;
		}
		$.ajax({
			type: "POST",
			url: "<?= base_url() . 'delete-item'; ?>",
			cache: false,
			data: {
				id: list_id
			},
			success: function (b) {
				var c = $.parseJSON(b);

				if (c.status == 1) {
					$("#row_" + list_id).hide('slow');

				} else {
					alert(c.message);

				}
			},
			error: function (b, d, c) {
				alert("Error: There is some problem in processing. Please try again");
			},
		});

	}


</script>

<?= $this->endSection() ?>