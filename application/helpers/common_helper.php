<?php

/**
 * Is Ajax check for ajax request
 */
function is_ajax() {
    $C = & get_instance();
    if (!$C->input->is_ajax_request())
        exit('No direct script access allowed');
}

function checkadminlogin() {
    $C = & get_instance();
    $sessionData = $C->session->userdata(PROJECT_NAME . '_user_data');
    if (!empty($sessionData)) {
        return true;
    } else {
        redirect('admin/login');
    }
}

function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getImage($dir_type, $image_name) {
    $image_url = '';

    //user image
    if ($dir_type == 'user') {
        if ($image_name) {
            if (file_exists(PROFILEPIC . $image_name)) {
                $image_url = base_url() . PROFILEPIC . $image_name;
            } else {
                $image_url = base_url() . DEFAULT_IMG . 'user.jpg';
            }
        } else {
            $image_url = base_url() . DEFAULT_IMG . 'user.jpg';
        }
    }

    //Logo image
    if ($dir_type == 'logo') {
        if ($image_name) {
            if (file_exists(SITE_LOGO . $image_name)) {
                $image_url = base_url() . SITE_LOGO . $image_name;
            } else {
                $image_url = base_url() . DEFAULT_IMG . 'default.png';
            }
        } else {
            $image_url = base_url() . DEFAULT_IMG . 'default.png';
        }
    }

    //Contact us image
    if ($dir_type == 'contact_us_image') {
        if ($image_name) {
            if (file_exists(CONTACT_US_IMG . $image_name)) {
                $image_url = base_url() . CONTACT_US_IMG . $image_name;
            } else {
                $image_url = base_url() . DEFAULT_IMG . 'default.png';
            }
        } else {
            $image_url = base_url() . DEFAULT_IMG . 'default.png';
        }
    }

    //Product image
    if ($dir_type == 'product_image') {
        if ($image_name) {
            if (file_exists(PRODUCT_IMG . $image_name)) {
                $image_url = base_url() . PRODUCT_IMG . $image_name;
            } else {
                $image_url = base_url() . DEFAULT_IMG . 'default.png';
            }
        } else {
            $image_url = base_url() . DEFAULT_IMG . 'default.png';
        }
    }

    //Boarding slider image
    if ($dir_type == 'boarding_slider') {
        if ($image_name) {
            if (file_exists(BOARDING_SLIDER_IMG . $image_name)) {
                $image_url = base_url() . BOARDING_SLIDER_IMG . $image_name;
            } else {
                $image_url = base_url() . DEFAULT_IMG . 'default.png';
            }
        } else {
            $image_url = base_url() . DEFAULT_IMG . 'default.png';
        }
    }

    //User document image
    if ($dir_type == 'user_documents') {
        if ($image_name) {
            if (file_exists(USER_DOCUMENTS . $image_name)) {
                $image_url = base_url() . USER_DOCUMENTS . $image_name;
            } else {
                $image_url = base_url() . DEFAULT_IMG . 'default.png';
            }
        } else {
            $image_url = base_url() . DEFAULT_IMG . 'default.png';
        }
    }

    //Vehicle image
    if ($dir_type == 'vehicle_photo') {
        if ($image_name) {
            if (file_exists(VEHICLE_IMG . $image_name)) {
                $image_url = base_url() . VEHICLE_IMG . $image_name;
            } else {
                $image_url = base_url() . DEFAULT_IMG . 'default.png';
            }
        } else {
            $image_url = base_url() . DEFAULT_IMG . 'default.png';
        }
    }
    
    //SIGNATURE image
    if ($dir_type == 'signature') {
        if ($image_name) {
            if (file_exists(SIGNATURE . $image_name)) {
                $image_url = base_url() . SIGNATURE . $image_name;
            } else {
                $image_url = base_url() . DEFAULT_IMG . 'default.png';
            }
        } else {
            $image_url = base_url() . DEFAULT_IMG . 'default.png';
        }
    }
    
    //Advertisement image
    if ($dir_type == 'advertisement') {
        if ($image_name) {
            if (file_exists(ADVERTISEMENT . $image_name)) {
                $image_url = base_url() . ADVERTISEMENT . $image_name;
            } else {
                $image_url = base_url() . DEFAULT_IMG . 'default.png';
            }
        } else {
            $image_url = base_url() . DEFAULT_IMG . 'default.png';
        }
    }
    
    //Invoice image
    if ($dir_type == 'invoice_image') {
        if ($image_name) {
            if (file_exists(INVOICE_IMAGE . $image_name)) {
                $image_url = base_url() . INVOICE_IMAGE . $image_name;
            } else {
                $image_url = base_url() . DEFAULT_IMG . 'default.png';
            }
        } else {
            $image_url = base_url() . DEFAULT_IMG . 'default.png';
        }
    }
    return $image_url;
}

function formatSizeUnits($bytes) {
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}

function getDateTimeDifference($datetime_1, $datetime_2) {

    $start_datetime = new DateTime($datetime_1);
    $diff = $start_datetime->diff(new DateTime($datetime_2));

    $result = '';
    if ($diff->y) {
        $result .= $diff->y . ' Years ';
    }
    if ($diff->m) {
        $result .= $diff->m . ' Months ';
    }
    if ($diff->d) {
        $result .= $diff->d . ' Days ';
    }
    if ($diff->h) {
        $result .= $diff->h . ' Hrs ';
    }
    if ($diff->i) {
        $result .= $diff->i . ' Min ';
    }
    if ($diff->s) {
        $result .= $diff->s . ' Sec';
    }
    return $result;
}

function ordinal_number($number) {
    $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
    if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
        return $number . 'th';
    } else {
        return $number . $ends[$number % 10];
    }
}

function humanTiming($time) {

    $time = time() - strtotime($time); // to get the time since that moment
    $time = ($time < 1) ? 1 : $time;
    $tokens = array(
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit)
            continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '') . ' ago';
    }
}
