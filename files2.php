<?php 
include 'db_connect.php';
$folder_parent = isset($_GET['fid']) ? $_GET['fid'] : 0;

// Modify the query to exclude the "Template" folder
$folders = $conn->query("SELECT * FROM folders where parent_id = $folder_parent and user_id = '".$_SESSION['login_id']."'  order by name asc");

// Fetch the number of files for each folder
$folderCounts = array();
$filesCountQuery = $conn->query("SELECT folder_id, COUNT(*) as count FROM files where user_id = '".$_SESSION['login_id']."' GROUP BY folder_id");
while ($row = $filesCountQuery->fetch_assoc()) {
    $folderCounts[$row['folder_id']] = $row['count'];
}

$files = $conn->query("SELECT * FROM files where folder_id = $folder_parent and user_id = '".$_SESSION['login_id']."'  order by name asc");
?>

<style>
.folder-item{
	cursor: pointer;
}

.card-body {
    border: 1px solid #ccc;
    padding: 15px;
    margin: 10px;
    border-radius: 5px;
	box-shadow: 3px 3px 5px rgb(15 182 237 / 71%);
    transition: box-shadow 0.3s cubic-bezier(0, -1.49, 1, 0.3);
}

.card-body:hover {
    box-shadow: 3px 3px 5px rgb(243 9 146 / 84%);
    transition: box-shadow 0.3s cubic-bezier(0, -1.49, 1, 0.3);
}

.ps-3 {
    padding-left: 3rem!important;
}
.custom-menu {
	z-index: 1000;
	position: absolute;
	background-color: #ffffff;
	border: 1px solid #0000001c;
	border-radius: 5px;
	padding: 8px;
	min-width: 13vw;
}
a.custom-menu-list {
width: 100%;
display: flex;
color: #4c4b4b;
font-weight: 600;
font-size: 1em;
padding: 1px 11px;
}
.file-item{
cursor: pointer;
}
a.custom-menu-list:hover,.file-item:hover,.file-item.active {
background: #80808024;
}
a.custom-menu-list span.icon{
	width:1em;
	margin-right: 5px
}

</style>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="pagetitle">
			<?php 
			$id = $folder_parent;
			$breadcrumbs = [];

			while ($id > 0) {
				$path = $conn->query("SELECT * FROM folders where id = $id  order by name asc")->fetch_array();
				array_unshift($breadcrumbs, '<li class="breadcrumb-item"><a href="index.php?page=files2&fid=' . $path['id'] . '">' . $path['name'] . '</a></li>');
				$id = $path['parent_id'];
			}

			if (!empty($breadcrumbs)) {
				$repositoryName = end($breadcrumbs);
				array_pop($breadcrumbs);
				echo '<h1>' . strip_tags($repositoryName) . '</h1>';
				echo '<nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=files2"> Repository </a></li>' . implode('', $breadcrumbs) . '</ol></nav>';
			} else {
				$repositoryName = 'Repository';
				echo '<h1>' . $repositoryName . '</h1>';
			}
			?>
		</div><!-- End Page Title -->


		<div class="button-container d-flex align-items-center">
			<button class="btn btn-primary btn-sm mr-2" id="new_folder"><i class="bi bi-plus"></i> New Folder</button>
			<button class="btn btn-primary btn-sm mr-2" id="new_file"><i class="bi bi-upload"></i> Upload File</button>
			<div class="col-md-4 input-group ml-auto">
				<input type="text" class="form-control" id="search" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
				<div class="input-group-append">
					<span class="input-group-text" id="inputGroup-sizing-sm"><i class="bi bi-search"></i></span>
				</div>
			</div>
		</div>

		<hr>
		<section class="section dashboard">
		<h5><b>Folders</b></h5>
			<div class="row">
			<?php
			$styles = array(
				array('color' => '#4154f1', 'background' => '#d3d3f0'),
				array('color' => '#2eca6a', 'background' => '#e0f8e9'),
				array('color' => '#ff771d', 'background' => '#ffecdf')
			);

			$folderCount = 0; // Initialize folder count
			$previousStyleIndex = -1; // Initialize previous style index

			while ($row = $folders->fetch_assoc()):
				$folderId = $row['id'];
				$folderName = $row['name'];
				$fileCount = isset($folderCounts[$folderId]) ? $folderCounts[$folderId] : 0;

				do {
					$randomStyleIndex = array_rand($styles);
				} while ($randomStyleIndex === $previousStyleIndex);

				$randomStyle = $styles[$randomStyleIndex];
				$previousStyleIndex = $randomStyleIndex;

				$subfolderCountQuery = $conn->query("SELECT COUNT(*) as count FROM folders WHERE parent_id = $folderId");
				$subfolderCount = $subfolderCountQuery->fetch_assoc()['count'];

				if ($folderCount % 4 == 0):
					echo '<div class="row">';
				endif;
				?>

				<div class="col-xxl-3 col-md-6 folder-item" data-id="<?php echo $folderId ?>">
					<div class="card info-card revenue-card">
						<div class="card-body">
							<h5 class="card-title"><?php echo $folderName ?></h5>
							<div class="d-flex align-items-center">
								<div class="card-icon rounded-circle ps-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; color: <?php echo $randomStyle['color']; ?>; background: <?php echo $randomStyle['background']; ?>">
                          		<img class="logo" src="assets/img/file.png" width="60" height="60" alt="Folder Icon">
								</div>
								<div class="ps-3">
									<h6><?php echo $fileCount + $subfolderCount ?></h6>
									<span class="text-success small pt-1 fw-bold"><?php echo $fileCount ?></span>
									<span class="text-muted small pt-2 ps-1">Files</span>
									<span class="text-success small pt-1 fw-bold"><?php echo $subfolderCount ?></span>
									<span class="text-muted small pt-2 ps-1">Subfolders</span>
								</div>
								</div>
							</div>
						</div>
					</div>

					<?php
					$folderCount++;

					// Close the row after every 4 folders
					if ($folderCount % 4 == 0):
						echo '</div>';
					endif;

				endwhile;

				// Close the last row if it's not already closed
				if ($folderCount % 4 != 0):
					echo '</div>';
				endif;
				?>

					<h5><b>Files</b></h5>
					<div class="card col-md-12">
								<div class="card-body">
									<table width="100%">
										<tr>
											<th width="5%" class=""></th> 
											<th width="35%" class="">Filename</th>
											<th width="20%" class="">Date</th>
											<th width="40%" class="">Description</th>
										</tr>
										<?php 
											$random_colors = array('#d3d3f0', '#e0f8e9', '#ffecdf');
											$previous_color_index = -1;

											while ($row = $files->fetch_assoc()):
												do {
													$random_index = array_rand($random_colors);
												} while ($random_index === $previous_color_index);

												$random_color = $random_colors[$random_index];
												$previous_color_index = $random_index;

												$name = explode(' ||', $row['name']);
												$name = isset($name[1]) ? $name[0] . " (" . $name[1] . ")." . $row['file_type'] : $name[0] . "." . $row['file_type'];
												$img_arr = array('png', 'jpg', 'jpeg', 'gif', 'psd', 'tif');
												$doc_arr = array('doc', 'docx');
												$pdf_arr = array('pdf', 'ps', 'eps', 'prn');
												$icon = 'fa-file';

												if (in_array(strtolower($row['file_type']), $img_arr))
													$icon = 'fa-image';
												if (in_array(strtolower($row['file_type']), $doc_arr))
													$icon = 'fa-file-word';
												if (in_array(strtolower($row['file_type']), $pdf_arr))
													$icon = 'fa-file-pdf';
												if (in_array(strtolower($row['file_type']), ['xlsx', 'xls', 'xlsm', 'xlsb', 'xltm', 'xlt', 'xla', 'xlr']))
													$icon = 'fa-file-excel';
												if (in_array(strtolower($row['file_type']), ['zip', 'rar', 'tar']))
													$icon = 'fa-file-archive';
												?>

												<tr class='file-item' data-id="<?php echo $row['id'] ?>" data-name="<?php echo $name ?>" style="background-color: <?php echo $random_color; ?>">
													<td>
															<a href="display_file.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary" title="View">
																<i class="fa fa-eye"></i>
															</a>
														</td>
													<td><large><span><i class="fa <?php echo $icon ?>"></i></span><b class="to_file"> <?php echo $name ?></b></large>
														<input type="text" class="rename_file" value="<?php echo $row['name'] ?>" data-id="<?php echo $row['id'] ?>" data-type="<?php echo $row['file_type'] ?>" style="display: none">
													</td>
													<td><i class="to_file"><?php echo date('Y/m/d h:i A', strtotime($row['date_updated'])) ?></i></td>
													<td><i class="to_file"><?php echo $row['description'] ?></i></td>
												</tr>

											<?php endwhile; ?>
									</table>
									
								</div>
					</div>
		</section>
	</div>
</div>
<div id="menu-folder-clone" style="display: none;">
	<a href="javascript:void(0)" class="custom-menu-list file-option edit bg-info text-white"><i class="bi bi-pen-fill mr-2"></i> Rename</a>
	<a href="javascript:void(0)" class="custom-menu-list file-option delete bg-danger text-white"><i class="bi bi-trash-fill mr-2"></i> Delete</a>
</div>

<div id="menu-file-clone" style="display: none;">
	<a href="javascript:void(0)" class="custom-menu-list file-option edit bg-info text-white"><i class="bi bi-pen-fill mr-2"></i> Rename</a>
	<a href="javascript:void(0)" class="custom-menu-list file-option download bg-warning text-white"><i class="bi bi-cloud-arrow-down-fill mr-2"></i>  Download</a>
	<a href="javascript:void(0)" class="custom-menu-list file-option delete bg-danger text-white"><i class="bi bi-trash-fill mr-2"></i> Delete</a>
</div>

<script>
	
	$('#new_folder').click(function(){
		uni_modal('','manage_folder.php?fid=<?php echo $folder_parent ?>')
	})
	$('#new_file').click(function(){
		uni_modal('','manage_files.php?fid=<?php echo $folder_parent ?>')
	})
	$('.folder-item').dblclick(function(){
		location.href = 'index.php?page=files2&fid='+$(this).attr('data-id')
	})
	$('.folder-item').bind("contextmenu", function(event) { 
    event.preventDefault();
    $("div.custom-menu").hide();
    var custom =$("<div class='custom-menu'></div>")
        custom.append($('#menu-folder-clone').html())
        custom.find('.edit').attr('data-id',$(this).attr('data-id'))
        custom.find('.delete').attr('data-id',$(this).attr('data-id'))
    custom.appendTo("body")
	custom.css({top: event.pageY + "px", left: event.pageX + "px"});

	$("div.custom-menu .edit").click(function(e){
		e.preventDefault()
		uni_modal('Rename Folder','manage_folder.php?fid=<?php echo $folder_parent ?>&id='+$(this).attr('data-id') )
	})
	$("div.custom-menu .delete").click(function(e){
		e.preventDefault()
		_conf("Are you sure to delete this Folder?",'delete_folder',[$(this).attr('data-id')])
	})
})

	//FILE
	$('.file-item').bind("contextmenu", function(event) { 
    event.preventDefault();

    $('.file-item').removeClass('active')
    $(this).addClass('active')
    $("div.custom-menu").hide();
    var custom =$("<div class='custom-menu file'></div>")
        custom.append($('#menu-file-clone').html())
        custom.find('.edit').attr('data-id',$(this).attr('data-id'))
        custom.find('.delete').attr('data-id',$(this).attr('data-id'))
        custom.find('.download').attr('data-id',$(this).attr('data-id'))
    custom.appendTo("body")
	custom.css({top: event.pageY + "px", left: event.pageX + "px"});

	$("div.file.custom-menu .edit").click(function(e){
		e.preventDefault()
		$('.rename_file[data-id="'+$(this).attr('data-id')+'"]').siblings('large').hide();
		$('.rename_file[data-id="'+$(this).attr('data-id')+'"]').show();
	})
	$("div.file.custom-menu .delete").click(function(e){
		e.preventDefault()
		_conf("Are you sure to delete this file?",'delete_file',[$(this).attr('data-id')])
	})
	$("div.file.custom-menu .download").click(function(e){
		e.preventDefault()
		window.open('download.php?id='+$(this).attr('data-id'))
	})

	$('.rename_file').keypress(function(e){
		var _this = $(this)
		if(e.which == 13){
			start_load()
			$.ajax({
				url:'ajax.php?action=file_rename',
				method:'POST',
				data:{id:$(this).attr('data-id'),name:$(this).val(),type:$(this).attr('data-type'),folder_id:'<?php echo $folder_parent ?>'},
				success:function(resp){
					if(typeof resp != undefined){
						resp = JSON.parse(resp);
						if(resp.status== 1){
								_this.siblings('large').find('b').html(resp.new_name);
								end_load();
								_this.hide()
								_this.siblings('large').show()
						}
					}
				}
			})
		}
	})

})
//FILE


	$('.file-item').click(function(){
		if($(this).find('input.rename_file').is(':visible') == true)
    	return false;
		uni_modal($(this).attr('data-name'),'manage_files.php?<?php echo $folder_parent ?>&id='+$(this).attr('data-id'))
	})
	$(document).bind("click", function(event) {
    $("div.custom-menu").hide();
    $('#file-item').removeClass('active')

});
	$(document).keyup(function(e){

    if(e.keyCode === 27){
        $("div.custom-menu").hide();
    $('#file-item').removeClass('active')

    }

});
	$(document).ready(function() {
		$('#search').keyup(function() {
			var searchTerm = $(this).val().toLowerCase();

			// Filter folders
			$('.folder-item').each(function() {
				var folderName = $(this).find('.card-title').text().toLowerCase();
				$(this).toggle(folderName.includes(searchTerm));
			});

			// Filter files
            $('.file-item').each(function() {
                var fileName = $(this).find('b.to_file').text().toLowerCase();
                var fileDate = $(this).find('i.to_file').text().toLowerCase(); 
                $(this).toggle(fileName.includes(searchTerm) || fileDate.includes(searchTerm));
            });
		});
	});
	function delete_folder($id){
		start_load();
		$.ajax({
			url:'ajax.php?action=delete_folder',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp == 1){
					alert_toast("Folder successfully deleted.",'success')
						setTimeout(function(){
							location.reload()
						},1500)
				}
			}
		})
	}
	function delete_file($id){
		start_load();
		$.ajax({
			url:'ajax.php?action=delete_file',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp == 1){
					alert_toast("Folder successfully deleted.",'success')
						setTimeout(function(){
							location.reload()
						},1500)
				}
			}
		})
	}

</script>