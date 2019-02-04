<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at.
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Authenticator;

// final class GoogleAuthenticator
// {
//     /**
//      * @var int
//      */
//     private $passCodeLength;

//     /**
//      * @var int
//      */
//     private $secretLength;

//     /**
//      * @var int
//      */
//     private $pinModulo;

//     /**
//      * NEXT_MAJOR: remove this property.
//      */
//     private $fixBitNotation;

//     /**
//      * @param int $passCodeLength
//      * @param int $secretLength
//      */
//     public function __construct(int $passCodeLength = 6, int $secretLength = 10)
//     {
//         $this->passCodeLength = $passCodeLength;
//         $this->secretLength = $secretLength;
//         $this->pinModulo = pow(10, $this->passCodeLength);
//     }

//     /**
//      * @param $secret
//      * @param $code
//      *
//      * @return bool
//      */
//     public function checkCode($secret, $code)
//     {
//         $time = floor(time() / 30);
//         for ($i = -1; $i <= 1; ++$i) {
//             if ($this->codesEqual($this->getCode($secret, $time + $i), $code)) {
//                 return true;
//             }
//         }

//         return false;
//     }

//     /**
//      * @param $secret
//      * @param null $time
//      *
//      * @return string
//      */
//     public function getCode($secret, $time = null)
//     {
//         if (!$time) {
//             $time = floor(time() / 30);
//         }

//         $base32 = new FixedBitNotation(5, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567', true, true);
//         $secret = $base32->decode($secret);

//         $time = pack('N', $time);
//         $time = str_pad($time, 8, chr(0), STR_PAD_LEFT);

//         $hash = hash_hmac('sha1', $time, $secret, true);
//         $offset = ord(substr($hash, -1));
//         $offset = $offset & 0xF;

//         $truncatedHash = $this->hashToInt($hash, $offset) & 0x7FFFFFFF;
//         $pinValue = str_pad($truncatedHash % $this->pinModulo, 6, '0', STR_PAD_LEFT);

//         return $pinValue;
//     }

//     *
//      * NEXT_MAJOR: Add a new parameter called $issuer.
//      *
//      * @param string $user
//      * @param string $hostname
//      * @param string $secret
//      *
//      * @return string
     
//     public function getUrl($user, $hostname, $secret)
//     {
//         $args = func_get_args();
//         $encoder = 'https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=';
//         $urlString = '%sotpauth://totp/%s@%s%%3Fsecret%%3D%s'.(array_key_exists(3, $args) && !is_null($args[3]) ? ('%%26issuer%%3D'.$args[3]) : '');
//         $encoderURL = sprintf($urlString, $encoder, $user, $hostname, $secret);

//         return $encoderURL;
//     }

//     /**
//      * @return string
//      */
//     public function generateSecret()
//     {
//         $secret = random_bytes($this->secretLength);

//         $base32 = new FixedBitNotation(5, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567', true, true);

//         return $base32->encode($secret);
//     }

//     /**
//      * @param string $bytes
//      * @param int    $start
//      *
//      * @return int
//      */
//     private function hashToInt(string $bytes, int $start): int
//     {
//         $input = substr($bytes, $start, strlen($bytes) - $start);
//         $val2 = unpack('N', substr($input, 0, 4));

//         return $val2[1];
//     }

//     /**
//      * A constant time code comparison.
//      *
//      * @param string $known known code
//      * @param string $given code received from a user
//      *
//      * @return bool
//      *
//      * @see http://codereview.stackexchange.com/q/13512/6747
//      */
//     private function codesEqual(string $known, string $given): bool
//     {
//         if (strlen($given) !== strlen($known)) {
//             return false;
//         }

//         $res = 0;

//         $knownLen = strlen($known);

//         for ($i = 0; $i < $knownLen; ++$i) {
//             $res |= (ord($known[$i]) ^ ord($given[$i]));
//         }

//         return $res === 0;
//     }
// }



/**
 * PHP Class for handling Google Authenticator 2-factor authentication.
 *
 * @author Michael Kliewe
 * @copyright 2012 Michael Kliewe
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 *
 * @link http://www.phpgangsta.de/
 */
class GoogleAuthenticator {
    protected $_codeLength = 6;

    /**
     * Create new secret.
     * 16 characters, randomly chosen from the allowed base32 characters.
     *
     * @param int $secretLength
     *
     * @return string
     */
    public function createSecret($secretLength = 16) {
        $validChars = $this->_getBase32LookupTable();

        // Valid secret lengths are 80 to 640 bits
        if ($secretLength < 16 || $secretLength > 128)
            throw new Exception('Bad secret length');
        
        $secret = '';
        $rnd = false;
        
        if (function_exists('random_bytes'))
            $rnd = random_bytes($secretLength);
        elseif (function_exists('mcrypt_create_iv'))
            $rnd = mcrypt_create_iv($secretLength, MCRYPT_DEV_URANDOM);
        elseif (function_exists('openssl_random_pseudo_bytes')) {
            $rnd = openssl_random_pseudo_bytes($secretLength, $cryptoStrong);
            if (!$cryptoStrong)
                $rnd = false;
        }

        if ($rnd !== false) {
            for ($i = 0; $i < $secretLength; ++$i) {
                $secret .= $validChars[ord($rnd[$i]) & 31];
            }
        } else
            throw new Exception('No source of secure random');

        return $secret;
    }



    /**
     * Calculate the code, with given secret and point in time.
     *
     * @param string   $secret
     * @param int|null $timeSlice
     *
     * @return string
     */
    public function getCode($secret, $timeSlice = null) {
        if ($timeSlice === null)
            $timeSlice = floor(time() / 30);

        $secretkey = $this->_base32Decode($secret);

        // Pack time into binary string
        $time = chr(0).chr(0).chr(0).chr(0).pack('N*', $timeSlice);
        // Hash it with users secret key
        $hm = hash_hmac('SHA1', $time, $secretkey, true);
        // Use last nipple of result as index/offset
        $offset = ord(substr($hm, -1)) & 0x0F;
        // grab 4 bytes of the result
        $hashpart = substr($hm, $offset, 4);

        // Unpak binary value
        $value = unpack('N', $hashpart);
        $value = $value[1];
        // Only 32 bits
        $value = $value & 0x7FFFFFFF;

        $modulo = pow(10, $this->_codeLength);

        return str_pad($value % $modulo, $this->_codeLength, '0', STR_PAD_LEFT);
    }



    /**
     * Get QR-Code URL for image, from google charts.
     *
     * @param string $name
     * @param string $secret
     * @param string $title
     * @param array  $params
     *
     * @return string
     */
    public function getQRCodeGoogleUrl($name, $secret, $title = null, $params = array()) {
        $width = !empty($params['width']) && (int) $params['width'] > 0 ? (int) $params['width'] : 200;
        $height = !empty($params['height']) && (int) $params['height'] > 0 ? (int) $params['height'] : 200;
        $level = !empty($params['level']) && array_search($params['level'], array('L', 'M', 'Q', 'H')) !== false ? $params['level'] : 'M';

        $urlencoded = urlencode('otpauth://totp/'.$name.'?secret='.$secret.'');
        if (isset($title))
            $urlencoded .= urlencode('&issuer='.urlencode($title));

        return 'https://chart.googleapis.com/chart?chs='.$width.'x'.$height.'&chld='.$level.'|0&cht=qr&chl='.$urlencoded.'';
    }



    /**
     * Check if the code is correct. This will accept codes starting from $discrepancy*30sec ago to $discrepancy*30sec from now.
     *
     * @param string   $secret
     * @param string   $code
     * @param int     $discrepancy    This is the allowed time drift in 30 second units (8 means 4 minutes before or after)
     * @param int|null $currentTimeSlice time slice if we want use other that time()
     *
     * @return bool
     */
    public function verifyCode($secret, $code, $discrepancy = 1, $shift = 0) {
        $currentTimeSlice = floor(time() / 30) + $shift;

        if (strlen($code) != 6)
            return false;

        for ($i = -$discrepancy; $i <= $discrepancy; ++$i) {
            $calculatedCode = $this->getCode($secret, $currentTimeSlice + $i);
            if ($this->timingSafeEquals($calculatedCode, $code))
                return true;
        }

        return false;
    }



    /**
     * Check if the code is correct. This will accept codes starting from $discrepancy*30sec ago to $discrepancy*30sec from now.
     *
     * @param string   $secret
     * @param string   $code
     * @param int     $discrepancy    This is the allowed time drift in 30 second units (8 means 4 minutes before or after)
     * @param int|null $currentTimeSlice time slice if we want use other that time()
     *
     * @return bool
     */
    public function getAdjust($secret, $code, $begin = 0, $end = 0) {
        $currentTimeSlice = floor(time() / 30);

        if (strlen($code) != 6) { return false; }

        for ($i = $begin; $i <= $end; ++$i) {
            $calculatedCode = $this->getCode($secret, $currentTimeSlice+$i);
            if ($this->timingSafeEquals($calculatedCode, $code))
                return $i;
        }

        return false;
    }



    /**
     * Set the code length, should be >=6.
     *
     * @param int $length
     *
     * @return PHPGangsta_GoogleAuthenticator
     */
    public function setCodeLength($length)
    {
        $this->_codeLength = $length;

        return $this;
    }

    /**
     * Helper class to decode base32.
     *
     * @param $secret
     *
     * @return bool|string
     */
    protected function _base32Decode($secret)
    {
        if (empty($secret)) {
            return '';
        }

        $base32chars = $this->_getBase32LookupTable();
        $base32charsFlipped = array_flip($base32chars);

        $paddingCharCount = substr_count($secret, $base32chars[32]);
        $allowedValues = array(6, 4, 3, 1, 0);
        if (!in_array($paddingCharCount, $allowedValues)) {
            return false;
        }
        for ($i = 0; $i < 4; ++$i) {
            if ($paddingCharCount == $allowedValues[$i] &&
                substr($secret, -($allowedValues[$i])) != str_repeat($base32chars[32], $allowedValues[$i])) {
                return false;
            }
        }
        $secret = str_replace('=', '', $secret);
        $secret = str_split($secret);
        $binaryString = '';
        for ($i = 0; $i < count($secret); $i = $i + 8) {
            $x = '';
            if (!in_array($secret[$i], $base32chars)) {
                return false;
            }
            for ($j = 0; $j < 8; ++$j) {
                $x .= str_pad(base_convert(@$base32charsFlipped[@$secret[$i + $j]], 10, 2), 5, '0', STR_PAD_LEFT);
            }
            $eightBits = str_split($x, 8);
            for ($z = 0; $z < count($eightBits); ++$z) {
                $binaryString .= (($y = chr(base_convert($eightBits[$z], 2, 10))) || ord($y) == 48) ? $y : '';
            }
        }

        return $binaryString;
    }

    /**
     * Get array with all 32 characters for decoding from/encoding to base32.
     *
     * @return array
     */
    protected function _getBase32LookupTable()
    {
        return array(
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', //  7
            'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', // 15
            'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', // 23
            'Y', 'Z', '2', '3', '4', '5', '6', '7', // 31
            '=',  // padding char
        );
    }

    /**
     * A timing safe equals comparison
     * more info here: http://blog.ircmaxell.com/2014/11/its-all-about-time.html.
     *
     * @param string $safeString The internal (safe) value to be checked
     * @param string $userString The user submitted (unsafe) value
     *
     * @return bool True if the two strings are identical
     */
    private function timingSafeEquals($safeString, $userString)
    {
        if (function_exists('hash_equals')) {
            return hash_equals($safeString, $userString);
        }
        $safeLen = strlen($safeString);
        $userLen = strlen($userString);

        if ($userLen != $safeLen) {
            return false;
        }

        $result = 0;

        for ($i = 0; $i < $userLen; ++$i) {
            $result |= (ord($safeString[$i]) ^ ord($userString[$i]));
        }

        // They are only identical strings if $result is exactly 0...
        return $result === 0;
    }
}
