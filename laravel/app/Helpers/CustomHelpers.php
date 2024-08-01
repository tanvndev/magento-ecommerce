<?php

if (!function_exists('getServiceInstance')) {
    function getServiceInstance($modelName)
    {
        $folderName = str_replace('Catalogue', "", $modelName);
        $serviceInterfaceNameSpace = 'App\Services\Interfaces\\' . ucfirst($folderName) . '\\' . ucfirst($modelName)  . 'ServiceInterface';
        if (interface_exists($serviceInterfaceNameSpace)) {
            // hàm app() giúp truy cập các đối tượng đã đăng ký trong container
            return app($serviceInterfaceNameSpace);
        }
        return null;
    }
}
if (!function_exists('generateStrongPassword')) {
    function generateStrongPassword($length = 12)
    {
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $specialChars = '!@#$%^&*()_+-=[]{}|';

        $allChars = $uppercase . $lowercase . $numbers . $specialChars;
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $password .= $allChars[random_int(0, strlen($allChars) - 1)];
        }

        return $password;
    }
}
if (!function_exists('getRepositoryInstance')) {
    function getRepositoryInstance($modelName)
    {
        $repositoryInterfaceNameSpace = 'App\Repositories\Interfaces\\' . ucfirst($modelName) . 'RepositoryInterface';
        if (interface_exists($repositoryInterfaceNameSpace)) {
            // hàm app() giúp truy cập các đối tượng đã đăng ký trong container
            return app($repositoryInterfaceNameSpace);
        }
        return null;
    }
}


if (!function_exists('formatToCommas')) {
    function formatToCommas($nStr)
    {
        $nStr = strval($nStr);
        $nStr = str_replace('.', '', $nStr);
        $str = "";
        for ($i = strlen($nStr); $i > 0; $i -= 3) {
            $a = $i - 3 < 0 ? 0 : $i - 3;
            $str = substr($nStr, $a, $i - $a) . "." . $str;
        }
        $str = substr($str, 0, -1);
        return $str;
    }
}
if (!function_exists('convertPrice')) {

    function convertPrice($priceString)
    {
        $priceWithoutDots = str_replace('.', '', $priceString);
        // Chuyển đổi chuỗi thành số nguyên
        $price = intval($priceWithoutDots);
        return $price;
    }
}
if (!function_exists('formatCurrency')) {

    function formatCurrency($amount, $currencyCode = 'vn')
    {
        switch (strtoupper($currencyCode)) {
            case 'VN':
                // Định dạng cho tiền tệ Việt Nam (VND)
                return number_format($amount, 0, ',', '.') . ' ₫';
            case 'CN':
                // Định dạng cho tiền tệ Trung Quốc (CNY)
                return '¥' . number_format($amount, 2, '.', ',');
            case 'EN':
                // Định dạng cho tiền tệ Hoa Kỳ (USD)
                return '$' . number_format($amount, 2, '.', ',');
            default:
                // Nếu mã tiền tệ không được hỗ trợ, trả về số tiền gốc
                return $amount;
        }
    }
}


if (!function_exists('recursive')) {

    function recursive($data, $parent_id = 0)
    {
        $result = [];
        if (!is_null($data) && count($data) > 0) {
            foreach ($data as $key => $value) {
                if ($value->parent_id == $parent_id) {
                    $result[] = [
                        'item' => $value,
                        'children' => recursive($data, $value->id)
                    ];
                }
            }
        }

        return $result;
    }
}


if (!function_exists('convertDateTime')) {
    function convertDateTime($dateTime = '', $format = 'd/m/Y H:i')
    {
        return date($format, strtotime($dateTime));
    }
}


if (!function_exists('cut_string_and_decode')) {
    function cut_string_and_decode($str = null, $n = 200)
    {
        $str = html_entity_decode($str);
        $str = strip_tags($str);
        if (mb_strlen($str) > $n) {
            $str = mb_substr($str, 0, $n) . '...';
        }
        return $str;
    }
}
if (!function_exists('sortString')) {
    function sortString($string)
    {
        if ($string == '') {
            return '';
        }

        $array = explode(", ", $string);
        sort($array, SORT_NUMERIC);
        $sortedNumbers = implode(", ", $array);
        return $sortedNumbers;
    }
}





if (!function_exists('generateStar')) {
    function generateStar($rate)
    {
        $filledStars = round($rate, 0);
        $starArray = array();

        for ($index = 0; $index < 5; $index++) {
            if ($index < $filledStars) {
                $starArray[] = '<i class="fas fa-star"></i>';
            } else {
                $starArray[] = '<i class="far fa-star"></i>';
            }
        }
        return implode(' ', $starArray);
    }
}

if (!function_exists('generateStarPercent')) {
    function generateStarPercent($rate = 100)
    {
        $percent =  round(100 - ($rate / 5 * 100));

        // Start building the HTML string
        $html = '
        <div class="stars-percent lh-1">
        ';

        // Generate 5 stars
        for ($i = 0; $i < 5; $i++) {
            $html .= '
            <svg viewBox="0 0 940.688 940.688">
                <path d="M885.344,319.071l-258-3.8l-102.7-264.399c-19.8-48.801-88.899-48.801-108.6,0l-102.7,264.399l-258,3.8 c-53.4,3.101-75.1,70.2-33.7,103.9l209.2,181.4l-71.3,247.7c-14,50.899,41.1,92.899,86.5,65.899l224.3-122.7l224.3,122.601 c45.4,27,100.5-15,86.5-65.9l-71.3-247.7l209.2-181.399C960.443,389.172,938.744,322.071,885.344,319.071z"/>
            </svg>
            ';
        }

        // Add overlay with dynamic width
        $html .= '
            <div class="overlay" style="width: ' . htmlspecialchars($percent) . '%;"></div>
        </div>
        ';

        return $html;
    }
}

if (!function_exists('renderProress')) {
    function renderProress($rate = 100)
    {
        $percent =  round(100 - ($rate / 5 * 100));

        // Start building the HTML string
        $html = '
        <div class="stars-percent">
        ';

        // Generate 5 stars
        for ($i = 0; $i < 5; $i++) {
            $html .= '
            <svg width="auto" height="auto" viewBox="0 0 940.688 940.688">
                <path d="M885.344,319.071l-258-3.8l-102.7-264.399c-19.8-48.801-88.899-48.801-108.6,0l-102.7,264.399l-258,3.8 c-53.4,3.101-75.1,70.2-33.7,103.9l209.2,181.4l-71.3,247.7c-14,50.899,41.1,92.899,86.5,65.899l224.3-122.7l224.3,122.601 c45.4,27,100.5-15,86.5-65.9l-71.3-247.7l209.2-181.399C960.443,389.172,938.744,322.071,885.344,319.071z"/>
            </svg>
            ';
        }

        // Add overlay with dynamic width
        $html .= '
            <div class="overlay" style="width: ' . htmlspecialchars($percent) . '%;"></div>
        </div>
        ';

        return $html;
    }
}


if (!function_exists('sortAttributeId')) {
    function sortAttributeId($attributeId)
    {
        sort($attributeId, SORT_NUMERIC);
        $attributeId = implode(", ", $attributeId);
        return $attributeId;
    }
}



if (!function_exists('convertVndTo')) {

    function convertVndTo($amountVnd, $currency = 'USD')
    {
        // Example exchange rates; in a real application, you would get these from an API or a config file.
        $exchangeRates = [
            'USD' => 0.000043,
            'EUR' => 0.000038,
            // Add more currencies as needed
        ];

        if (!isset($exchangeRates[$currency])) {
            throw new Exception("Exchange rate for currency '{$currency}' not found.");
        }

        $result = number_format($amountVnd * $exchangeRates[$currency], 2, '.', '');
        return $result;
    }
}

if (!function_exists('abbreviateName')) {
    function abbreviateName($fullName)
    {
        $parts = explode(' ', $fullName);
        $abbreviation = '';
        foreach ($parts as $part) {
            $abbreviation .= strtoupper(substr($part, 0, 1));
        }
        return $abbreviation;
    }
}

if (!function_exists('errorResponse')) {
    function errorResponse(string $message): array
    {
        return [
            'status' => 'error',
            'messages' => $message,
            'data' => null
        ];
    }
}

if (!function_exists('successResponse')) {
    function successResponse(string $message, $data = null): array
    {
        return [
            'status' => 'success',
            'messages' => $message,
            'data' => $data
        ];
    }
}

if (!function_exists('handleResponse')) {
    function handleResponse($response, $successCode = 200)
    {
        $statusCode = $response['status'] === 'success' ? $successCode : 500;
        return response()->json($response, $statusCode);
    }
}


if (!function_exists('renderRatingFilter')) {
    function renderRatingFilter()
    {
        $html = '';
        for ($i = 1; $i <= 5; $i++) {
            $html .= '<div class="mb-3 ps-0 form-check filter-star">';
            $html .= '<input type="checkbox" class="form-check-input filtering" name="rate[]" value="' . $i . '" id="rate_' . $i . '">';
            $html .= '<label class="form-check-label" for="rate_' . $i . '">';
            for ($j = 0; $j < 5; $j++) {
                $html .= '<i class="flaticon-star me-1 ' . ($i > $j ? 'active' : '') . '"></i>';
            }
            $html .= '</label>';
            $html .= '</div>';
        }
        return $html;
    }
}
