<?php

$a = \timglabisch\PhpRtTrace\RtInternalTracer::traceVariableAssign(0, 'a', 3, 3, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/assign/RtTraceExampleAssignBasic.php');
$a = \timglabisch\PhpRtTrace\RtInternalTracer::traceVariableAssign($a + 1, 'a', 4, 4, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/assign/RtTraceExampleAssignBasic.php');
$a = \timglabisch\PhpRtTrace\RtInternalTracer::traceVariableAssign('a' . 'b', 'a', 5, 5, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/assign/RtTraceExampleAssignBasic.php');
$a = \timglabisch\PhpRtTrace\RtInternalTracer::traceVariableAssign(1 + 2, 'a', 6, 6, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/assign/RtTraceExampleAssignBasic.php');
if ($a = \timglabisch\PhpRtTrace\RtInternalTracer::traceVariableAssign(\true, 'a', 8, 8, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/assign/RtTraceExampleAssignBasic.php')) {
}
if (!($a = \timglabisch\PhpRtTrace\RtInternalTracer::traceVariableAssign($aa = \timglabisch\PhpRtTrace\RtInternalTracer::traceVariableAssign(1 - 3, 'aa', 9, 9, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/assign/RtTraceExampleAssignBasic.php'), 'a', 9, 9, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/assign/RtTraceExampleAssignBasic.php'))) {
}