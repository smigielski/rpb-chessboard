<?php
/******************************************************************************
 *                                                                            *
 *    This file is part of RPB Chessboard, a WordPress plugin.                *
 *    Copyright (C) 2013-2016  Yoann Le Montagner <yo35 -at- melix.net>       *
 *                                                                            *
 *    This program is free software: you can redistribute it and/or modify    *
 *    it under the terms of the GNU General Public License as published by    *
 *    the Free Software Foundation, either version 3 of the License, or       *
 *    (at your option) any later version.                                     *
 *                                                                            *
 *    This program is distributed in the hope that it will be useful,         *
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of          *
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           *
 *    GNU General Public License for more details.                            *
 *                                                                            *
 *    You should have received a copy of the GNU General Public License       *
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.   *
 *                                                                            *
 ******************************************************************************/
?>

<p>
	<button id="rpbchessboard-addSetCodeButton" class="button">
		<?php _e('Add a new pieceset', 'rpbchessboard'); ?>
	</button>
</p>

<table id="rpbchessboard-setCodeList" class="wp-list-table widefat striped">

	<thead>
		<tr>
			<th scope="col"><?php _e('Name', 'rpbchessboard'); ?></th>
			<th scope="col"><?php _e('Slug', 'rpbchessboard'); ?></th>
			<th scope="col"><?php _e('Default', 'rpbchessboard'); ?></th>
		</tr>
	</thead>

	<tbody>

		<tr>
			<?php RPBChessboardHelperLoader::printTemplate('AdminPage/Theming/PiecesetEdition', $model, array('isNew' => true)); ?>
		</tr>

		<?php foreach($model->getAvailablePiecesets() as $pieceset): ?>
			<tr data-slug="<?php echo htmlspecialchars($pieceset); ?>">

				<td class="has-row-actions">
					<strong class="row-title"><?php echo htmlspecialchars($model->getPiecesetLabel($pieceset)); ?></strong>
					<span class="row-actions rpbchessboard-inlinedRowActions">
						<?php if($model->isBuiltinPieceset($pieceset)): ?>
							<span><a href="#" class="rpbchessboard-action-setDefault"><?php _e('Set default', 'rpbchessboard'); ?></a></span>
						<?php else: ?>
							<span><a href="#" class="rpbchessboard-action-setDefault"><?php _e('Set default', 'rpbchessboard'); ?></a> |</span>
							<span><a href="#" class="rpbchessboard-action-edit"><?php _e('Edit', 'rpbchessboard'); ?></a> |</span>
							<span><a href="#" class="rpbchessboard-action-delete"><?php _e('Delete', 'rpbchessboard'); ?></a></span>
						<?php endif; ?>
					</span>
				</td>

				<td><?php echo htmlspecialchars($pieceset); ?></td>

				<td>
					<?php if($model->isDefaultPieceset($pieceset)): ?>
						<div class="rpbchessboard-tickIcon"></div>
					<?php endif; ?>
				</td>

				<?php if(!$model->isBuiltinPieceset($pieceset)): ?>
					<?php RPBChessboardHelperLoader::printTemplate('AdminPage/Theming/PiecesetEdition', $model, array('isNew' => false, 'pieceset' => $pieceset)); ?>
				<?php endif; ?>

			</tr>
		<?php endforeach; ?>
	</tbody>

	<tfoot>
		<tr>
			<th scope="col"><?php _e('Name', 'rpbchessboard'); ?></th>
			<th scope="col"><?php _e('Slug', 'rpbchessboard'); ?></th>
			<th scope="col"><?php _e('Default', 'rpbchessboard'); ?></th>
		</tr>
	</tfoot>

</table>

<script type="text/javascript">
	jQuery(document).ready(function($) {

		// RPBChessboard.initializeSetCodeEditor = TODO

	});
</script>
