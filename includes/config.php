<?php
// Configurações do cartório
define('CARTORIO_NOME',    'Cartório de Registro Civil das Pessoas Naturais e Tabelionato de Notas de Cacaulândia – RO');
define('CARTORIO_CURTO',   'Cartório de Registro Civil e Notas de Cacaulândia');
define('OFICIAL_NOME',     'Alzira Vasconcelos da Silva');
define('CARTORIO_CNS',     '09.576-0');
define('CARTORIO_CNPJ',    '84.744.655/0001-64');
define('CARTORIO_TEL',     '(69) 3532-2033');
define('CARTORIO_EMAIL',   'contato@vasco.not.br');
define('CARTORIO_END',     'Av. João Falcão, 2100 – Centro');
define('CARTORIO_CIDADE',  'Cacaulândia – RO – CEP 76889-000');
define('CARTORIO_MAPA',    'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3924.0!2d-62.9!3d-10.35!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2sCacaul%C3%A2ndia!5e0!3m2!1spt!2sbr!4v1');

// E-mail para receber mensagens do formulário de contato
define('EMAIL_DESTINO', 'contato@vasco.not.br');

// Segurança
define('CSRF_TOKEN_NAME', 'csrf_token');
define('RATE_LIMIT_MAX',  3);   // máx. envios por sessão
