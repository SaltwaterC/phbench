$(document).ready(function () {
	phbench.get_tests(tests_url);
	phbench.stop_buttons();
	$('#status').text('page loaded');
});

var results = {
	time: 0
};

var phbench = {
	
	data: {},
	
	timeouts: [],
	
	iterate: 0,
	
	get_tests: function (tests_url) {
		$.ajax({
			async: false,
			url: tests_url,
			success: function (data) {
				$.each(data, function (test, info) {
					$('#tests').append('<tr><td>' + test + '</td><td>' + info.description + '</td><td><span id="time_' + info.name + '">0 ms</td><td><span id="mean_' + info.name + '">0 ms</td><td><span id="stddev_' + info.name + '">0 ms</td></tr>');
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
			
			// Global timer
			results.time += time;
			$('#time').text(results.time + ' ms');
			
			if ( ! results[test.name]) {
				results[test.name] = {
					time: [],
					timer: 0,
					mean: 0,
					stddev: 0
				};
			}
			
			// test time
			results[test.name].timer += time;
			$('#time_' + test.name).text(results[test.name].timer + ' ms');
			
			results[test.name].time.push(time);
			
			// test mean
			var mean = 0;
			for (var i in results[test.name].time) {
				mean += results[test.name].time[i];
			}
			results[test.name].mean = mean / results[test.name].time.length;
			$('#mean_' + test.name).text(results[test.name].mean.toFixed(3) + ' ms');
			
			// test standard variation
			var variance = 0;
			for (var i in results[test.name].time) {
				variance += Math.pow(results[test.name].time[i] - results[test.name].mean, 2);
			}
			variance = variance / results[test.name].time.length;
			results[test.name].stddev = Math.sqrt(variance);
			$('#stddev_' + test.name).text(results[test.name].stddev.toFixed(3) + ' ms');
			
			$('#log').append('<p class=\'log\'>Executed ' + test.name + ' in ' + time + ' miliseconds</p>');
			
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
		results = {
			time: 0
		};
		
		phbench.timeouts = [];
		phbench.iterate = 0;
		$.each(phbench.data, function (key, value) {
			$('#time_' + value.name).text('0 ms');
			$('#mean_' + value.name).text('0 ms');
			$('#stddev_' + value.name).text('0 ms');
		});
		$('#time').text('0 ms');
		$('#mean').text('0 ms');
		$('#stddev').text('0 ms');
		$('#log').text('').append('<p>Log:</p>');
	}
	
}
