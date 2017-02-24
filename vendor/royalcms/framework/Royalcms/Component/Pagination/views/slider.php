<?php
	$presenter = new Royalcms\Component\Pagination\BootstrapPresenter($paginator);
?>

<?php if ($paginator->getLastPage() > 1): ?>
	<div class="pagination">
		<ul>
			<?php echo $presenter->render(); ?>
		</ul>
	</div>
<?php endif; ?>
