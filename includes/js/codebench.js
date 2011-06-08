//<![CDATA[
$(document).ready(function() {
	// Insert "Toggle All" button
	var expand_all_text   = '▸ Expand all';
	var collapse_all_text = '▾ Collapse all';
	$('#bench').before('<p id="toggle_all">'+expand_all_text+'<\/p>');

	// Cache these selection operations
	var $runner       = $('#runner');
	var $toggle_all   = $('#toggle_all');
	var $bench_titles = $('#bench > li > h2');
	var $bench_rows   = $('#bench > li > div > table > tbody > tr');

	// Runner form
	$(':input:first', $runner).focus();
	$runner.submit(function() {
		$(':submit', this).attr('value', 'Running…').attr('disabled', 'disabled');
		$('.alert', this).remove();
	});

	// Toggle details for all benchmarks
	$('#toggle_all').click(function() {
		if ($(this).data('expanded')) {
			$(this).data('expanded', false);
			$(this).text(expand_all_text);
			$bench_titles.removeClass('expanded').siblings().hide();
		}
		else {
			$(this).data('expanded', true);
			$(this).text(collapse_all_text);
			$bench_titles.addClass('expanded').siblings().show();
		}
	});
	
	// Toggle details for a single benchmark
	$bench_titles.click(function() {
		$(this).toggleClass('expanded').siblings().toggle();

		// Counts of bench titles
		var total_bench_titles    = $bench_titles.length;
		var expanded_bench_titles = $bench_titles.filter('.expanded').length;

		// If no benchmark details are expanded, change "Collapse all" to "Expand all"
		if (expanded_bench_titles == 0 && $toggle_all.data('expanded')) {
			$toggle_all.click();
		}
		// If all benchmark details are expanded, change "Expand all" to "Collapse all"
		else if (expanded_bench_titles == total_bench_titles && ! $toggle_all.data('expanded')) {
			$toggle_all.click();
		}
	});

	// Highlight clicked rows
	$bench_rows.click(function() {
		$(this).toggleClass('highlight');
	// Highlight doubleclicked rows globally
	}).dblclick(function() {
		var nth_row = $(this).parent().children().index(this) + 1;
		if ($(this).hasClass('highlight')) {
			$bench_rows.filter(':nth-child('+nth_row+')').removeClass('highlight');
		}
		else {
			$bench_rows.filter(':nth-child('+nth_row+')').addClass('highlight');
		}
	});
});
//]]>
