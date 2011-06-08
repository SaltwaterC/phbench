/**
 * Uses inflection-js - JavaScript Inflection Support
 * @link: http://code.google.com/p/inflection-js/
 */

var convert = {
	
	core: function (value, unit, base, long_unit, decimals) {
		if (value < 1) {
			throw 'Error: The input value must be at least 1.';
		}
		
		if (decimals == null) {
			decimals = 3;
		}
		var index = Math.floor(Math.log(value) / Math.log(base));
		var length = unit.length - 1;
		if (index > length) {
			index = length;
		}
		value = (value / Math.pow(base, index)).toFixed(decimals);
		if (long_unit == true && value == 1) {
			unit[index] = unit[index].singularize();
		}
		return value + ' ' + unit[index];
	},
	
	bytes: function (bytes, si, long_unit, decimals) {
		var unit = [];
		var base = 0;
		if (si == false) {
			if (long_unit == null || long_unit == false) {
				unit = [
					'B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'
				];
			}
			else {
				unit = [
					'Bytes',
					'Kibibytes',
					'Mebibytes',
					'Gibibytes',
					'Tebibytes',
					'Pebibytes',
					'Exbibytes',
					'Zebibytes',
					'Yobibytes'
				];
			}
			base = 1024;
		}
		else {
			if (long_unit == null || long_unit == false) {
				unit = [
					'B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'
				];
			}
			else {
				unit = [
					'Bytes', 
					'Kilobytes',
					'Megabytes',
					'Gigabytes',
					'Terabytes',
					'Petabytes',
					'Exabytes',
					'Zettabytes',
					'Yottabytes'
				];
			}
			base = 1000;
		}
		return convert.core(bytes, unit, base, long_unit, decimals);
	},
	
	microseconds: function (microseconds, long_unit, decimals) {
		var unit = [];
		if (long_unit == null || long_unit == false) {
			unit = ['\u03bcs', 'ms', 's'];
		}
		else {
			unit = ['microseconds', 'miliseconds', 'seconds'];
		}
		return convert.core(microseconds, unit, 1000, long_unit,  decimals);
	}
	
}
