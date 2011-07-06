<?php
// http://securestring.googlecode.com/svn-history/r25/trunk/php/crypt_sha256.php

/** "Unix crypt using SHA-256", as specified by Ulrich Drepper
 * Version 0.4 2008-04-03, http://www.akkadia.org/drepper/SHA-crypt.txt
 *
 * This version attempt to match the Drepper source code as closely as
 * possible.
 */

/** helper function to do sha-256 and return raw bytes
 *
 */
function sha256_raw($data) {
    return hash('sha256', $data, true);
}

/** Crazy base64 algorithm used in crypt
 *
 */
function b64_from_24bit($b2, $b1, $b0, $n) {
    $CHARS = "./0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    $w = ($b2 << 16) | ($b1 << 8) | $b0;
    $buf = '';
    while ($n-- > 0) {
        $buf .= substr($CHARS, $w & 0x3f, 1);
        $w >>= 6;
    }
    return $buf;
}

/** Explicit crypt using sha-256 as specified by Ulrich Drepper
 *  http://www.akkadia.org/drepper/SHA-crypt.txt
 *
 *  @param $use_native  try to use built-in version if available.
 *   This is mostly present for testing.
 */
function crypt_sha256($key, $salt, $rounds) {
	
    // pure php version
    $salt = substr($salt, 0, 16);
    $salt_len = strlen($salt);

    $key_len = strlen($key);

    /* Prepare for the real work.  */
    /* Add the key string.  */
    /* The last part is the salt string.  This must be at most 16
     characters and it ends at the first `$' character (for
     compatibility with existing implementations).  */
    $ctx = $key . $salt;

    /* Compute alternate SHA256 sum with input KEY, SALT, and KEY.  The
       final result will be added to the first context.  */
    /* Add key.  */
    /* Add salt.  */
    /* Add key again.  */
    $alt_ctx = $key . $salt . $key;

    /* Now get result of this (32 bytes) and add it to the other
       context.  */
    $alt_result = sha256_raw($alt_ctx);

    /* Add for any character in the key one byte of the alternate sum.  */
    for ($cnt = $key_len; $cnt > 32; $cnt -= 32) {
        $ctx .= $alt_result;
    }
    $ctx .= substr($alt_result, 0, $cnt);

    /* Take the binary representation of the length of the key and for every
       1 add the alternate sum, for every 0 the key.  */
    for ($cnt = $key_len; $cnt > 0; $cnt >>= 1) {
        if (($cnt & 1) != 0) {
            $ctx .= $alt_result;
        } else {
            $ctx .= $key;
        }
    }
    /* Create intermediate result.  */
    $alt_result = sha256_raw($ctx);

    /* Start computation of P byte sequence.  */
    $alt_ctx = '';
    /* For every character in the password add the entire password.  */
    for ($cnt = 0; $cnt < $key_len; ++$cnt) {
        $alt_ctx .= $key;
    }
    /* Finish the digest.  */
    $tmp_result = sha256_raw($alt_ctx);

    /* Create byte sequence P. */
    $p_bytes = '';
    for ($cnt = $key_len; $cnt >= 32; $cnt -= 32) {
        $p_bytes .= $tmp_result;
    }
    $p_bytes .= substr($tmp_result, 0, $cnt);

    /* Start computation of S byte sequence.  */
    $alt_ctx = '';
    /* For every character in the password add the entire password.  */
    for ($cnt = 0; $cnt < 16 + ord(substr($alt_result, 0, 1)); ++$cnt) {
        $alt_ctx .= $salt;
    }
    /* Finish the digest.  */
    $tmp_result = sha256_raw($alt_ctx);

    /* Create byte sequence S.  */
    $s_bytes = '';
    for ($cnt = $salt_len; $cnt >= 32; $cnt -= 32) {
        $s_bytes .= $tmp_result;
    }
    $s_bytes .= substr($tmp_result, 0, $cnt);

    /* Repeatedly run the collected hash value through SHA256 to burn
     CPU cycles.  */
    for ($cnt = 0; $cnt < $rounds; ++$cnt) {
        /* New context.  */
        $ctx = '';

        /* Add key or last result.  */
        if (($cnt & 1) !== 0) {
            $ctx .= $p_bytes;
        } else {
            $ctx .= $alt_result;
        }
        /* Add salt for numbers not divisible by 3.  */
        if ($cnt % 3 != 0) {
            $ctx .= $s_bytes;
        }

        /* Add key for numbers not divisible by 7.  */
        if ($cnt % 7 != 0) {
            $ctx .= $p_bytes;
        }

        /* Add key or last result.  */
        if (($cnt & 1) != 0) {
            $ctx .= $alt_result;
        } else {
            $ctx .= $p_bytes;
        }

        /* Create intermediate result.  */
        $alt_result = sha256_raw($ctx);
    }

    /* convert php string to something more C-like */
    $count = strlen($alt_result);
    $strchars = str_split($alt_result);
    $chars = array();
    for ($cnt = 0; $cnt < $count; ++$cnt) {
        array_push($chars, ord($strchars[$cnt]));
    }

    /* do crazy base 64 encoding */
    $encoded = '';
    $encoded .= b64_from_24bit($chars[0],  $chars[10], $chars[20], 4);
    $encoded .= b64_from_24bit($chars[21], $chars[1],  $chars[11], 4);
    $encoded .= b64_from_24bit($chars[12], $chars[22], $chars[2],  4);
    $encoded .= b64_from_24bit($chars[3],  $chars[13], $chars[23], 4);
    $encoded .= b64_from_24bit($chars[24], $chars[4],  $chars[14], 4);
    $encoded .= b64_from_24bit($chars[15], $chars[25], $chars[5],  4);
    $encoded .= b64_from_24bit($chars[6],  $chars[16], $chars[26], 4);
    $encoded .= b64_from_24bit($chars[27], $chars[7],  $chars[17], 4);
    $encoded .= b64_from_24bit($chars[18], $chars[28], $chars[8],  4);
    $encoded .= b64_from_24bit($chars[9],  $chars[19], $chars[29], 4);
    $encoded .= b64_from_24bit(0,          $chars[31], $chars[30], 3);

    /* Now we can construct the result string.  It consists of three
       parts.  */
    return "\$5\$rounds=${rounds}\$${salt}\$${encoded}";
}
