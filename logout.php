<?php
require_once('./resource/session.php');
require_once('./resource/utilities.php');
session_destroy();
redirectTo('index');
