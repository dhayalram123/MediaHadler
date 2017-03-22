<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="table-responsive">
	<table class="table table-striped table-sm">
		<thead class="thead-default">
			<tr>
				<th style=""></th>
				<th style="">Preview</th>
				<th style="">Name</th>
				<th style="width:15%">Dimensions (px)</th>
				<th style="width:8%">File size</th>
				<th style="width:8%">Rename</th>
				<th style="width:8%">Delete</th>
			</tr>
		</thead>
		<tbody>
			<!-- folders -->
			<?php if (isset($folders)): ?>
				<?php foreach ($folders as $folder): ?>						
					<tr>						
						<td><input type="checkbox" name="rm[]" value="<?php echo $folder['path']; ?>" data-media="folder" data-raw-name="<?php echo $folder['name']; ?>" data-path="<?php echo $folder['path']; ?>"></td>
						<td><a class="mediapath" href="<?php echo $folder['path']; ?>"><span class="fa fa-folder"></span></a></td>
						<td><a class="mediapath" href="<?php echo $folder['path']; ?>"><?php echo $folder['name']; ?></a></td>
						<td></td>
						<td></td>
						<td><a class="btn btn-sm btn-info btn-rename" title="Rename" data-media="folder" data-raw-name="<?php echo $folder['name']; ?>" data-path="<?php echo $folder['path']; ?>"><span class="fa fa-pencil"></span></a></td>
						<td><a class="btn btn-sm btn-danger btn-delete" href="<?php echo $folder['path']; ?>" data-media="folder" title="Delete"><span class="fa fa-times"></span></a></td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
			<!-- files -->
			<?php if (isset($media['files'])): ?>
				<?php foreach ($media['files'] as $file): ?>		
					<?php if ($file['type'] == 'image'): ?>
						<tr>
							<td><input type="checkbox" name="rm[]" value="<?php echo $file['path']; ?>" data-media="file" data-raw-name="<?php echo $file['raw_name']; ?>" data-path="<?php echo $file['path']; ?>"></td>
							<td><a class="gallery-item mfp-image" data-group="3" href="<?php echo base_url($file['anchor_url']); ?>" title="<?php echo $file['raw_name']; ?>"><img src="<?php echo base_url($file['url']); ?>" alt="<?php echo $file['name']; ?>" style="<?php echo 'width:'.$file['width_16'].'px;height:'.$file['height_16'].'px'; ?>" /></a></td>
							<td><a class="gallery-item mfp-image" data-group="4" href="<?php echo base_url($file['anchor_url']); ?>" title="<?php echo $file['raw_name']; ?>"><?php echo $file['name']; ?></a></td>
							<td><?php echo $file['width'].' &#215; '.$file['height']; ?></td>
							<td><?php echo $file['size']; ?></td>
							<td><a class="btn btn-sm btn-info btn-rename" title="Rename" data-media="file" data-raw-name="<?php echo $file['raw_name']; ?>" data-path="<?php echo $file['path']; ?>"><span class="fa fa-pencil"></span></a></td>
							<td><a class="btn btn-sm btn-danger btn-delete" href="<?php echo $file['path']; ?>" data-media="file" title="Delete"><span class="fa fa-times"></span></a></td>
						</tr>
					<?php else: ?>
						<?php 
						$attr1 = 'target="_blank"';
						$attr2 = 'target="_blank"';
						if($file['type'] == 'audio' || $file['type'] == 'video') {
							$attr1 = 'class="gallery-item" data-group="1" data-type="'.$file['type'].'"';
							$attr2 = 'class="gallery-item" data-group="2" data-type="'.$file['type'].'"';
						}
						?>
						<tr>
							<td><input type="checkbox" name="rm[]" value="<?php echo $file['path']; ?>" data-media="file" data-raw-name="<?php echo $file['raw_name']; ?>" data-path="<?php echo $file['path']; ?>"></td>
							<td><a <?php echo $attr1; ?> href="<?php echo base_url($file['url']); ?>" title="<?php echo $file['raw_name']; ?>"><img src="<?php echo base_url($file['icon_url-16']); ?>" alt="<?php echo $file['name']; ?>" style="width:16px;height:16px" /></a></td>
							<td><a <?php echo $attr2; ?> href="<?php echo base_url($file['url']); ?>" title="<?php echo $file['raw_name']; ?>"><?php echo $file['name']; ?></a></td>
							<td></td>
							<td><?php echo $file['size']; ?></td>
							<td><a class="btn btn-sm btn-info btn-rename" target="_top" title="Rename" data-media="file" data-raw-name="<?php echo $file['raw_name']; ?>" data-path="<?php echo $file['path']; ?>"><span class="fa fa-pencil"></span></a></td>
							<td><a class="btn btn-sm btn-danger btn-delete" target="_top" href="<?php echo $file['path']; ?>" data-media="file" title="Delete"><span class="fa fa-times"></span></a></td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
</div>