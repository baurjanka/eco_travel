<?php

function utf8_substr($str, $from, $len) {
    return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $from . '}' .
            '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $len . '}).*#s', '$1', $str);
}

function pager_navigation($pager, $uri, $query_string = '', $page = null) {
    if (!$pager->haveToPaginate()) {
        return '';
    }

    $navigation = '<ul class="pagination pull-right">';
    $query_string = (preg_match('/\?/', $query_string) ? '' : '?') . $query_string;
    $query_string .= ($query_string == '?' ? 'page=' : '&page=');

    // First and previous page
    if ($pager->getPage() != 1) {
        $navigation .= '<li><a class="prev-page" href="' . url_for($uri) . $query_string . $pager->getFirstPage() . '">&laquo;</a></li>';
        $navigation .= '<li><a class="prev-page" href="' . url_for($uri) . $query_string . $pager->getPreviousPage() . '">&lsaquo;</a></li>';
    } else {
        $navigation .= '<li class="disabled"><a href="#" >&laquo;</a></li>';
        $navigation .= '<li class="disabled"><a href="#" >&lsaquo;</a></li>';
    }

    // Pages one by one
    $links = array();
    foreach ($pager->getLinks() as $page) {
        if ($page == $pager->getPage()) {
            $links[] = '<li class="active"><a href="#">' . $page . '</a></li>';
        } else {
            $links[] = '<li><a href="' . url_for($uri) . $query_string . $page . '">' . $page . '</a></li>';
        }
    }
    $navigation .= join('', $links);

    // Next and last page
    if ($pager->getPage() != $pager->getLastPage()) {
        $navigation .= '<li><a class="next-page" href="' . url_for($uri) . $query_string . $pager->getNextPage() . '">&rsaquo;</a></li>';
        $navigation .= '<li><a class="next-page" href="' . url_for($uri) . $query_string . $pager->getLastPage() . '">&raquo;</a></li>';
    } else {
        $navigation .= '<li class="disabled"><a href="#">&rsaquo;</a></li>';
        $navigation .= '<li class="disabled"><a href="#">&raquo;</a></li>';
    }
    $navigation .= '</ul>';

    return $navigation;
}

function time_ago($from_time, $to_time = null, $include_seconds = false) {
    if (!is_numeric($from_time)) {
        $from_time = strtotime($from_time);
    }

    $to_time = $to_time ? $to_time : time();
    if ($from_time > $to_time)
        $from_time = $to_time;

    $distance_in_minutes = floor(abs($to_time - $from_time) / 60);
    $distance_in_seconds = floor(abs($to_time - $from_time));

    $string = '';
    $parameters = array();

    if ($distance_in_minutes <= 1) {
        if (!$include_seconds) {
            $string = $distance_in_minutes == 0 ? 'Дөнгөж сая' : 'Минутын өмнө';
        } else {
            if ($distance_in_seconds <= 5) {
                $string = 'секундын өмнө';
            } else if ($distance_in_seconds >= 6 && $distance_in_seconds <= 10) {
                $string = '10 секундын өмнө';
            } else if ($distance_in_seconds >= 11 && $distance_in_seconds <= 20) {
                $string = '20 секундын өмнө';
            } else if ($distance_in_seconds >= 21 && $distance_in_seconds <= 40) {
                $string = '30 секундын өмнө';
            } else if ($distance_in_seconds >= 41 && $distance_in_seconds <= 59) {
                $string = '50 секундын өмнө';
            } else {
                $string = 'Минутын өмнө';
            }
        }
    } else if ($distance_in_minutes >= 2 && $distance_in_minutes <= 44) {
        $string = '%minutes% минутын өмнө';
        $parameters['%minutes%'] = $distance_in_minutes;
    } else if ($distance_in_minutes >= 45 && $distance_in_minutes <= 89) {
        $string = 'Цагийн өмнө';
    } else if ($distance_in_minutes >= 90 && $distance_in_minutes <= 1439) {
        $string = '%hours% цагийн өмнө';
        $parameters['%hours%'] = round($distance_in_minutes / 60);
    } else if ($distance_in_minutes >= 1440 && $distance_in_minutes <= 2879) {
        $string = 'Хоногийн өмнө';
    } else if ($distance_in_minutes >= 2880 && $distance_in_minutes <= 43199) {
        $string = '%days% хоногийн өмнө';
        $parameters['%days%'] = round($distance_in_minutes / 1440);
    } else if ($distance_in_minutes >= 43200 && $distance_in_minutes <= 86399) {
        $string = 'Сарын өмнө';
    } else {
        return date("Y-m-d H:i", $from_time);
    }
    return strtr($string, $parameters);
}

function available_product_option($options) {
    $str = '<select name="product_availability" id="product_availability">';
    foreach ($options as $key => $value) {
        $str.='<option value="' . $key . '">' . $value . '</option>';
    }
    $str .= '</select>';
    return $str;
}

function multiple_product_option($cart, $p_id) {
    $str = '';
    foreach ($cart as $package => $product) {
        if (isset($product[$p_id])) {
            if ($package != 'stock') {
                $pk = Doctrine::getTable('Package')->findOneBy('id', $package);
                if ($pk) {
                    $title = date('Y-m-d', strtotime($pk->getOpenDate())) . '-ны захиалга:&nbsp;';
                } else {
                    $title = 'Алдаа';
                }
            } else {
                $title = 'Бэлэн байгаа';
            }

            $str.= $title . '<select name="re_chose_' . $package . '" id="re_chose_total" style="width: 50px"';

            if (6 >= $product[$p_id]['real_total'] && $product[$p_id]['real_total'] > 0) {
                for ($i = 0; $i <= $product[$p_id]['real_total']; $i++) {
                    $str .= '<option value="' . ($package . '_' . $p_id . '_' . $product[$p_id]['real_total']) . '" ' . ($product[$p_id]['total'] == $i ? "selected" : "") . '>' . $i . '</option>';
                }
            } else if (6 < $product[$p_id]['real_total']) {
                for ($i = 0; $i <= 6; $i++) {
                    $str .= '<option value="' . ($package . '_' . $p_id . '_' . $product[$p_id]['real_total']) . '" ' . ($product[$p_id]['total'] == $i ? "selected" : "") . '>' . $i . '</option>';
                }
            }

            $str.='</select><br/>';
        }
    }
    return $str;
}
