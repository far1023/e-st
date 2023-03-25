// Credits and thanks to https://github.com/develoka/angka-terbilang-js

const units = ['', 'Ribu', 'Juta', 'Milyar', 'Triliun', 'Quadriliun', 'Quintiliun', 'Sextiliun', 'Septiliun', 'Oktiliun', 'Noniliun', 'Desiliun', 'Undesiliun', 'Duodesiliun', 'Tredesiliun', 'Quattuordesiliun', 'Quindesiliun', 'Sexdesiliun', 'Septendesiliun', 'Oktodesiliun', 'Novemdesiliun', 'Vigintiliun'];

const maxIndex = units.length - 1;

function digitToUnit (digit) {
  var curIndex = digit / 3
  return curIndex <= maxIndex ? units[curIndex] : units[maxIndex]
}

const numbers = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan']
function numberToText (index) {
  return numbers[index] || ''
}

function terbilang(angka) {
	const angkaLength   = angka.length
  const angkaMaxIndex = angkaLength - 1

  if (angkaMaxIndex === 0 && Number(angka[0]) === 0) {
    return 'nol'
  }

  let space = ''
  let result = ''

  let i = 0
  while (i !== angkaLength) {

    const digitCount = angkaMaxIndex - i
    const modGroup = digitCount % 3
    const curAngka = Number(angka[i])

    if (digitCount === 3 && curAngka === 1 && (i === 0 || 
      (Number(angka[i - 2]) === 0 && Number(angka[i - 1]) === 0))) {
      result += `${space}seribu`
    } else {
      if (curAngka !== 0) {
        if (modGroup === 0) {
          result += `${space}${numberToText(curAngka)}${(i === angkaMaxIndex ? '' : ' ')}${digitToUnit(digitCount)}`
        } else if (modGroup === 2) {
          if (curAngka === 1) {
            result += `${space}seratus`
          } else {
            result += `${space}${numberToText(curAngka)} ratus`
          }
        } else {
          if (curAngka === 1) {
            const nextAngka = Number(angka[i])
            if (nextAngka === 0) {
              result += `${space}sepuluh`
              if (digitCount !== 1 && (Number(angka[i - 2]) !== 0 || Number(angka[i - 1]) !== 0)) {
                result += ` ${digitToUnit(digitCount - 1)}`
              }
            } else {
              if (nextAngka === 1) {
                result += `${space}sebelas`
              } else {
                result += `${space}${numberToText(nextAngka)} belas`
              }
              if (digitCount !== 1) {
                result += ` ${digitToUnit(digitCount - 1)}`
              }
            }
          } else {
            result += `${space}${numberToText(curAngka)} puluh`
          }
        }
      } else {
        if (modGroup === 0 && (Number(angka[i - 2]) !== 0 || Number(angka[i - 1]) !== 0) && digitCount !== 0) {
          result += ` ${digitToUnit(digitCount)}`
        }
      }
    }

    if (i <= 1) {
      space = ' '
    }
    i++
  }

  return result
}

function terbilangSatuSatu(angka) {
	return angka
    .split('')
    .map(angka => angka == 0 ? 'nol' : numberToText(angka))
    .join(' ')
}

function angkaTerbilang(target, settings={decimal: '.'}) {
  if (typeof target !== "string") target = String(target)
  if (target.indexOf(settings.decimal) > -1) {
    target = target.split(settings.decimal)
    return `${terbilang(target[0])} koma ${terbilangSatuSatu(target[1])}`
  } else {
    return terbilang(target)
  }
}