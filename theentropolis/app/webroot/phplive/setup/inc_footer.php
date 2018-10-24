	</div>

</div>

<div style="padding-top: 100px; padding-bottom: 100px;">
	<div style="width: 970px; margin: 0 auto; font-size: 10px; text-align: right;">
		&copy; OSI Codes Inc. - <a href="<?php echo $CONF["BASE_URL"] ?>/setup/system.php">Check for new version</a>

		<div id="div_debug_console_footer" style="<?php echo ( isset( $VAR_DEBUG_OUT ) && $VAR_DEBUG_OUT ) ? "" : "display: none;" ?> margin-top: 15px; text-align: right;">
			<span>
			<?php
				$var_process_end = ( $var_microtime ) ? microtime(true) : time() ;
				$pd = $var_process_end - $var_process_start ; if ( !$pd ) { $pd = 0.001 ; }
				$pd = str_replace( ",", ".", $pd ) ;
				$var_mem_end = ( function_exists( "memory_get_usage" ) ) ? memory_get_usage() : 0 ;
				$var_mem_usage = round( ( $var_mem_end - $var_mem_start ) * .001 ) ;
				print "DB queries: " . $dbh['qc'] . " / Process Duration: ".number_format( $pd, 3 )." / Server Mem: ".$var_mem_usage."Kb" ;
			?>
			</span>
		</div>
	</div>
</div>

</body>
</html>
<?php
	if ( isset( $dbh ) && $dbh['con'] ) { database_mysql_close( $dbh ) ; }
?>
