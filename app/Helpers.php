<?php

namespace app\Helpers;

class Cipher
{
	private $keyMatrix;
	private $modulus;

	public function __construct($key)
	{
		$this->keyMatrix = $this->generateKeyMatrix($key);
		$this->modulus = 256; // Jumlah karakter alfabet dalam Hill Cipher
	}

	private function generateKeyMatrix($key)
	{
		$keyMatrix = array(
			array($key[0], $key[1]),
			array($key[2], $key[3])
		);

		return $keyMatrix;
	}

	private function multiplyMatrix($matrixA, $matrixB)
	{
		$result = array(
			array(0),
			array(0)
		);

		for ($i = 0; $i < 2; $i++) {
			for ($j = 0; $j < 1; $j++) {
				$sum = 0;
				for ($k = 0; $k < 2; $k++) {
					$sum += $matrixA[$i][$k] * $matrixB[$k][$j];
				}
				$result[$i][$j] = $sum % $this->modulus;
			}
		}

		return $result;
	}

	private function inverseMatrix2x2($matrix)
	{
		$a = $matrix[0][0];
		$b = $matrix[0][1];
		$c = $matrix[1][0];
		$d = $matrix[1][1];

		$determinant = ($a * $d) - ($b * $c);

		if ($determinant == 0) {
			return "Matriks tidak dapat diinvers karena determinannya nol.";
		} else {
			$inversedMatrix = [
				[$d, -$b],
				[-$c, $a]
			];

			$scalar = 1 / $determinant;

			for ($i = 0; $i < 2; $i++) {
				for ($j = 0; $j < 2; $j++) {
					$inversedMatrix[$i][$j] *= $scalar;
				}
			}

			return $inversedMatrix;
		}
	}

	public function encrypt(string $plainText)
	{
		if ($plainText == NULL) {
			return NULL;
		}

		for ($i = 0; $i < strlen($plainText); $i++) {
			$arrayDecimals[] = intval(ord($plainText[$i]));
		}

		$matrixCount = ceil(count($arrayDecimals) / 2);

		$encryptedText = '';
		$encryptedTextDec = [];
		for ($i = 0; $i < $matrixCount; $i++) {
			$matrix = array(
				array($arrayDecimals[$i * 2]),
				array($arrayDecimals[$i * 2 + 1] ?? 0)
			);

			$resultMatrix = $this->multiplyMatrix($this->keyMatrix, $matrix);

			$encryptedTextDec[] = $resultMatrix[0][0];
			$encryptedTextDec[] = $resultMatrix[1][0];
			$ii = mb_convert_encoding(chr($resultMatrix[0][0]), 'UTF-8', mb_detect_encoding(chr($resultMatrix[0][0]), "UTF-8, ISO-8859-1, ISO-8859-15", true));
			$ij = mb_convert_encoding(chr($resultMatrix[1][0]), 'UTF-8', mb_detect_encoding(chr($resultMatrix[1][0]), "UTF-8, ISO-8859-1, ISO-8859-15", true));

			$encryptedText .=  $ii . $ij;
		}

		return array(
			"data" => $encryptedText,
			"dec" => implode(",", $encryptedTextDec)
		);
	}

	public function decrypt(string $encryptedText)
	{
		if ($encryptedText == NULL) {
			return NULL;
		}

		// $encryptedText = mb_str_split($encryptedText, 1, 'UTF-8');
		// $arrayDecimals = [];
		// for ($i = 0; $i < count($encryptedText); $i++) {
		// 	$arrayDecimals[] = intval(ord($encryptedText[$i]));
		// }
		// for ($i = 0; $i < mb_strlen($encryptedText); $i++) {
		// 	$arrayDecimals[] = intval(ord(mb_substr($encryptedText, $i, 1)));
		// }

		$arrayDecimals = explode(',', $encryptedText);

		$matrixCount = ceil(count($arrayDecimals) / 2);

		// $decryptedText = [];
		$decryptedText = '';
		for ($i = 0; $i < $matrixCount; $i++) {
			$matrix = array(
				array($arrayDecimals[$i * 2]),
				array($arrayDecimals[$i * 2 + 1] ?? 0)
			);

			$resultMatrix = $this->multiplyMatrix($this->inverseMatrix2x2($this->keyMatrix), $matrix);

			// $decryptedText[] = $resultMatrix[0][0];
			// $decryptedText[] = $resultMatrix[1][0];
			$decryptedText .= chr($resultMatrix[0][0]) . chr($resultMatrix[1][0]);
		};

		return trim(mb_convert_encoding($decryptedText, 'UTF-8', mb_detect_encoding($decryptedText, "UTF-8, ISO-8859-1, ISO-8859-15", true)));
	}

	public static function encryptVig($text, $key = NULL)
	{
		($key == NULL) ? $key = env('VIGNERE_KEY') : $key = $key;
		$key = strtolower($key);

		$ki = 0;
		$kl = strlen($key);
		$length = strlen($text);

		for ($i = 0; $i < $length; $i++) {
			if (ctype_alpha($text[$i])) {
				if (ctype_upper($text[$i])) {
					$text[$i] = chr(((ord($key[$ki]) - ord("a") + ord($text[$i]) - ord("A")) % 26) + ord("A"));
				} else {
					$text[$i] = chr(((ord($key[$ki]) - ord("a") + ord($text[$i]) - ord("a")) % 26) + ord("a"));
				}

				$ki++;
				if ($ki >= $kl) {
					$ki = 0;
				}
			}
		}

		return $text;
	}

	public static function decryptVig($text, $key = NULL)
	{
		($key == NULL) ? $key = env('VIGNERE_KEY') : $key = $key;
		$key = strtolower($key);

		$ki = 0;
		$kl = strlen($key);
		$length = strlen($text);

		for ($i = 0; $i < $length; $i++) {
			if (ctype_alpha($text[$i])) {
				if (ctype_upper($text[$i])) {
					$x = (ord($text[$i]) - ord("A")) - (ord($key[$ki]) - ord("a"));

					if ($x < 0) {
						$x += 26;
					}

					$x = $x + ord("A");

					$text[$i] = chr($x);
				} else {
					$x = (ord($text[$i]) - ord("a")) - (ord($key[$ki]) - ord("a"));

					if ($x < 0) {
						$x += 26;
					}

					$x = $x + ord("a");

					$text[$i] = chr($x);
				}

				$ki++;
				if ($ki >= $kl) {
					$ki = 0;
				}
			}
		}

		return $text;
	}
}
