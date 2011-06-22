$(document).ready(function () {
	phbench.get_tests(tests_url);
	phbench.stop_buttons();
	$('#status').text('page loaded');
});

var phbench = {
	
	data: {},
	
	time: 0,
	
	timeouts: [],
	
	results: {},
	
	iterate: 0,
	
	get_tests: function (tests_url) {
		$.ajax({
			async: false,
			url: tests_url,
			success: function (data) {
				$.each(data, function (test, info) {
					$('#tests').append('<tr><td>' + test + '</td><td>' + info.description + '</td><td><span id="time_' + info.name + '">0 s</td><td><span id="mean_' + info.name + '">0 s</td><td><span id="stddev_' + info.name + '">0 s</td></tr>');
				});
				$('tr:odd').addClass('alt');
				phbench.data = data;
			},
			error: function () {
				window.alert('Error: Can\'t get the defined tests.');
			}
		});
	},
	
	run_test: function (test, remaining) {
		var time = 0;
		
		$.ajax({
			async: false,
			url: test.url,
			success: function (data) {
				if (data.success == true) {
					time = data.result[0];
				}
				else {
					$('#status').text('failed a test due to response error');
					phbench.stop_buttons(false);
				}
			},
			error: function () {
				$('#status').text('failed a test due to AJAX request error');
				phbench.stop_buttons(false);
			}
		});
		
		if (remaining == true) {
			$('#status').text('executed ' + test.name);
			
			phbench.iterate--;
			$('#remaining_tests').text(phbench.iterate);
			
			phbench.time += time;
			$('#time').text(phbench.time.toFixed(3) + ' s');
			
			if (phbench.results[test.name] == null) {
				phbench.results[test.name] = {'time' : time};
			}
			else {
				phbench.results[test.name]['time'] += time;
			}
			
			$('#time_' + test.name).text(phbench.results[test.name]['time'].toFixed(3) + ' s');
			
			$('#log').append('<p class=\'log\'>Executed ' + test.name + ' in ' + time.toFixed(3) + ' seconds</p>');
			
			if (phbench.iterate == 0) {
				$('#status').text('executed all the tests');
				phbench.stop_buttons();
			}
		}
	},
	
	preload: function () {
		$('#status').text('preloading');
		$.each(phbench.data, function (key, value) {
			phbench.run_test(value);
		});
	},
	
	start_tests: function (iterations, gap) {
		$('#stop_tests').removeAttr('disabled');
		$('#start_tests').attr('disabled', 'disabled');
		phbench.preload();
		phbench.reset();
		$('#status').text('executing the tests');
		for (i = 0; i < iterations; i++) {
			$.each(phbench.data, function (key, value) {
				timeout = window.setTimeout(function () {
					phbench.run_test(value, true);
					value = null;
				}, phbench.iterate * gap);
				phbench.timeouts.push(timeout);
				phbench.iterate++;
			});
		}
	},
	
	stop_tests: function (output) {
		if (output == null) {
			output = true;
		}
		$.each(phbench.timeouts, function (key, value) {
			window.clearTimeout(value);
		});
		$('#remaining_tests').text(0);
		phbench.reset();
		if (output != false) {
			$('#status').text('stopped the tests');
		}
		phbench.stop_buttons();
	},
	
	stop_buttons: function () {
		$('#start_tests').removeAttr('disabled');
		$('#stop_tests').attr('disabled', 'disabled');
	},
	
	reset: function () {
		phbench.timeouts = [];
		phbench.results = {};
		phbench.iterate = 0;
		phbench.time = 0;
		$.each(phbench.data, function (key, value) {
			$('#time_' + value.name).text('0 s');
			$('#mean_' + value.name).text('0 s');
			$('#stddev_' + value.name).text('0 s');
		});
		$('#time').text('0 s');
		$('#mean').text('0 s');
		$('#stddev').text('0 s');
		$('#log').text('').append('<p>Log:</p>');
	}
	
}
