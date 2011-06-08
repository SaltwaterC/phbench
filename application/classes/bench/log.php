<?php defined('SYSPATH') or die('No direct access allowed.');

class Bench_Log extends Codebench {
	
	public $description = 'Log parser expressions: <a href="http://docstore.mik.ua/orelly/webprog/pcook/ch11_14.htm">O\'Reilly</a> vs. SaltwaterC.';
	
	public $subjects = array(
		'0.0.0.0 - - [08/Mar/2011:16:09:48 +0000] "GET /id/122530 HTTP/1.1" 200 20642 "http://example.com/id/122530" "Mozilla/5.0 (Windows; U; Windows NT 5.1; pt-PT) AppleWebKit/531.22.7 (KHTML, like Gecko) Version/4.0.5 Safari/531.22.7" "-"',
		'0.0.0.0 - - [08/Mar/2011:16:09:51 +0000] "-" 400 0 "-" "-"',
		'0.0.0.0 - - [08/Mar/2011:16:09:52 +0000] "GET /id/471387 HTTP/1.1" 200 730036224 "http://example.com/id/122447" "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/534.13 (KHTML, like Gecko) Chrome/9.0.597.107 Safari/534.13"',
		'0.0.0.0 - - [08/Mar/2011:16:09:55 +0000] "GET /id/636045 HTTP/1.1" 206 285548739 "-" "GetRight/6.3e"',
		'0.0.0.0 - - [08/Mar/2011:16:09:55 +0000] "GET /id/636045 HTTP/1.1" 200 172384196 "-" "GetRight/6.3e"',
		'0.0.0.0 - - [08/Mar/2011:16:09:58 +0000] "GET /id/603695 HTTP/1.1" 403 200 "http://example.com/id/603695" "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)" "-"',
		'0.0.0.0 - - [08/Mar/2011:16:09:58 +0000] "GET /id/471343 HTTP/1.0" 206 15710615 "-" "GetRight/6.3e"',
		'0.0.0.0 - - [08/Mar/2011:16:10:07 +0000] "GET /id/470521 HTTP/1.1" 206 61854 "http://example.com/id/470521" "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)"',
		'0.0.0.0 - - [08/Mar/2011:16:10:10 +0000] "GET /id/135821 HTTP/1.1" 206 105750989 "-" "GetRight/6.3e"',
		'0.0.0.0 - - [08/Mar/2011:16:10:11 +0000] "GET /id/470826 HTTP/1.0" 206 192720 "http://example.com/id/470826" "Download Master"',
	);
	
	public function bench_regex_original($log_entry = '')
	{
		/**
		 * Original O'Reilly expression
		 */
		$pattern = '/^([^ ]+) ([^ ]+) ([^ ]+) (\[[^\]]+\]) "(.*) (.*) (.*)" ([0-9\-]+) ([0-9\-]+) "(.*)" "(.*)"$/';
		preg_match($pattern, $log_entry, $matches);
		return $matches;
	}
	
	public function bench_regex_fixed_optimized($log_entry = '')
	{
		/**
		 * Changelog & Bug Fixes:
		 * 
		 * Turned off the greedy matching for the request matching since this
		 * makes the original regex at least 10 times slower (and increasing for
		 * longer paths)
		 * Fixes 400 (bad request) matching
		 * Uses the D modifier
		 * Fixes the "might be there" HTTP_X_FORWARDED_FOR
		 * 
		 * The expression was validated agains a over 1 milion entries
		 * production log that's now processed in seconds, not minutes.
		 */
		$pattern = '/^([^ ]+) ([^ ]+) ([^ ]+) (\[[^\]]+\]) "(?:(.*?)(?: (.*?) (.*?))?)" ([0-9\-]+) ([0-9\-]+) "(.*)" "(.*)"\s?(?:"(.*)")?$/D';
		preg_match($pattern, $log_entry, $matches);
		
		$size = sizeof($matches);
		if ($size === 12)
		{
			$matches[] = '-'; // fix the missing X-Forwarded-For
			$size++;
		}
		
		if ($size !== 13) // broken match
		{
			return array();
		}
		
		return $matches;
	}
	
} // End Log