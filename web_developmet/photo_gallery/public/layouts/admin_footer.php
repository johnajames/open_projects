</div>
	</div>
    <div id="footer">Copyright <?php echo date("Y", time()); ?>, John James</div>
  </body>
</html>
<?php if(isset($database)) { $database->close_connection(); } ?>