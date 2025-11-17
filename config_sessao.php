<?php
$tempo_expiracao = 3600; // 1 hora

session_set_cookie_params($tempo_expiracao);

session_start();
