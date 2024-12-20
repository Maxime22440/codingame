<?php
$binary = implode('', array_map(function($c) { return str_pad(decbin(ord($c)), 7, '0', STR_PAD_LEFT); }, str_split(stream_get_line(STDIN, 101, "\n"))));
echo trim(preg_replace_callback('/(0+|1+)/', function($m) { return ($m[0][0] === '1' ? '0 ' : '00 ') . str_repeat('0', strlen($m[0])) . ' '; }, $binary)) . "\n";
