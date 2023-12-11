{$year_start = 'year_start'|config}
{$year_current = $smarty.now|date_format:"%Y"}
{$year_interval = ($year_current > $year_start) ? ($year_start|cat:'-'|cat:$year_current) : $year_current}

<footer class="footer border-top mt-5">
	<div class="footer-copyright text-center py-3">&copy; {$year_interval} {'site_name'|config}</div>
</footer>
