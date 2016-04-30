<?php
/**
 * ブロック一覧view
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<article class="block-setting-body">
	<?php echo $this->BlockTabs->main(BlockTabsHelper::MAIN_TAB_BLOCK_INDEX); ?>

	<?php echo $this->BlockIndex->description(); ?>

	<div class="tab-content">
		<?php echo $this->BlockIndex->create(); ?>
			<?php echo $this->BlockIndex->addLink(); ?>

			<?php echo $this->BlockIndex->startTable(); ?>
				<thead>
					<tr>
						<?php echo $this->BlockIndex->tableHeader(
								'Frame.block_id'
							); ?>
						<?php echo $this->BlockIndex->tableHeader(
								'Iframe.url', __d('iframes', 'URL'),
								array('sort' => true)
							); ?>
						<?php echo $this->BlockIndex->tableHeader(
								'Iframe.height', __d('iframes', 'Frame height'),
								array('sort' => true, 'type' => 'numeric')
							); ?>
						<?php echo $this->BlockIndex->tableHeader(
								'Iframe.created_user', __d('net_commons', 'Created user'),
								array('sort' => true, 'type' => 'handle')
							); ?>
						<?php echo $this->BlockIndex->tableHeader(
								'Iframe.created', __d('net_commons', 'Created datetime'),
								array('sort' => true, 'type' => 'datetime')
							); ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($iframes as $iframe) : ?>
						<?php echo $this->BlockIndex->startTableRow($iframe['Block']['id']); ?>
							<?php echo $this->BlockIndex->tableData(
									'Frame.block_id', $iframe['Block']['id']
								); ?>
							<?php echo $this->BlockIndex->tableData(
									'Iframe.url', $iframe['Iframe']['url'],
									array('blockId' => $iframe['Block']['id'], 'type' => 'link')
								); ?>
							<?php echo $this->BlockIndex->tableData(
									'Iframe.height', $iframe['Iframe']['height'],
									array('type' => 'numeric', 'format' => ['domain' => 'iframes', 'singular' => '%dpx', 'plural' => '%dpx'])
								); ?>
							<?php echo $this->BlockIndex->tableData(
									'TrackableCreator', $iframe,
									array('type' => 'handlename')
								); ?>
							<?php echo $this->BlockIndex->tableData(
									'Iframe.created', $iframe['Iframe']['created'],
									array('type' => 'datetime')
								); ?>
						<?php echo $this->BlockIndex->endTableRow(); ?>
					<?php endforeach; ?>
				</tbody>
			<?php echo $this->BlockIndex->endTable(); ?>

		<?php echo $this->BlockIndex->end(); ?>

		<?php echo $this->element('NetCommons.paginator'); ?>
	</div>
</article>
