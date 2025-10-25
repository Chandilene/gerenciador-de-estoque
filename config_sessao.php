<?php
$tempo_expiracao = 3600; // 1 hora

// Configura o tempo de vida do cookie. DEVE vir ANTES de session_start()
session_set_cookie_params($tempo_expiracao);

session_start();
