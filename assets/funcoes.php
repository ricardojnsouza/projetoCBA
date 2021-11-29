<?php
    function login($user, $pass) {
        $result = null;
        $mysql = $GLOBALS['mysql'] ?? null;
        if ($mysql === null) {
            return false;
        }

        // - prepara e executa o select para confrontar a autenticação do usuário!
        $pass = hash("sha256", $pass);
        $sql = "SELECT `idusuario`, `nomeusuario`, NOW() `now` FROM `usuario` WHERE `emailusuario` = ? AND `senhausuario` = ? AND (`inicio_bloqueio` IS NULL OR NOW() > DATE_ADD(`inicio_bloqueio`, INTERVAL 15 MINUTE))";
        try {
            $ps = $mysql->prepare($sql);
            $result = $ps->execute([ $user, $pass ]);
        }
        catch (Exception $e) {
            print("$sql<br><pre>");
            print_r($values);
            print("</pre>Falha ao consultar dados em <font color='red'>usuario</font>: '" . $e->getMessage() . "'<br>");
            print("<strong>StackTrace</strong>:<pre>");
            print($e->getTraceAsString());
            print("</pre>");
        }
        // -
        if ($result === true) {
            $results = $ps->fetchAll();
            // - usuário e senha inválido!
            if (count($results) === 0) {
                // - verifica se o usuário existe na base, se existir incrementa o numero de tentativas e caso o numero de tentativas exceda as 5 tentativas, marca o usuário com o início do bloqueio.
                $sql = "SELECT `idusuario` FROM `usuario` WHERE `emailusuario` = ?";
                try {
                    $ps = $mysql->prepare($sql);
                    $result = $ps->execute([ $user ]);
                    if ($result === true) {
                        $results = $ps->fetchAll();
                        // - obtém o 'id' do usuário localizado pelo email e prepara o comando para atualizar o contador de tentativas.
                        foreach ($results as $reg) {
                            $sql = "UPDATE `usuario` SET `tentativas` = (IFNULL(`tentativas`, 0) + 1), `inicio_bloqueio` = IF(IFNULL(`tentativas`, 0) >= 4, NOW(), `inicio_bloqueio`) WHERE `idusuario` = ?";
                            $ps = $mysql->prepare($sql);
                            $ps->execute([ $reg['idusuario'] ]);
                            break;
                        }
                    }
                }
                catch (Exception $e) {
                    print("$sql<br><pre>");
                    print_r($values);
                    print("</pre>Falha ao consultar dados em <font color='red'>usuario</font>: '" . $e->getMessage() . "'<br>");
                    print("<strong>StackTrace</strong>:<pre>");
                    print($e->getTraceAsString());
                    print("</pre>");
                }
                $_SESSION["auth_token"] = null;
                return false;
            }
            // - usuário e senha válidos -> gera o token para o usuário
            $id = 0;
            $token = null;
            foreach ($results as $reg) {
                $id = $reg['idusuario'];
                $token = hash("sha256", $reg['idusuario'] . $reg['nomeusuario'] . $reg['now']);
                break;
            }
            // - registra o token de sesssão e reinicia o número de tentativas de acesso para o usuário.
            if ($token !== null && $id > 0) {
                try {
                    $sql = "UPDATE `usuario` SET `token` = ?, `tentativas` = 0, `inicio_bloqueio` = NULL WHERE `idusuario` = ?";
                    $ps = $mysql->prepare($sql);
                }
                catch (Exception $e) {
                    print("$sql<br><pre>");
                    print_r($values);
                    print("</pre>Falha ao atualizar dados em <font color='red'>usuario</font>: '" . $e->getMessage() . "'<br>");
                    print("<strong>StackTrace</strong>:<pre>");
                    print($e->getTraceAsString());
                    print("</pre>");
                }
                $result = $ps->execute([ $token, $id ]);
                if ($result === true) {
                    $_SESSION["auth_token"] = $token;
                    return $token;
                }
            }
        }
        $_SESSION["auth_token"] = null;
        return false;
    }
    function logout($token) {
        $result = null;
        $mysql = $GLOBALS['mysql'] ?? null;
        if ($mysql === null) {
            return false;
        }

        // - prepara e executa o select para confrontar a autenticação do usuário!
        $sql = "SELECT `idusuario` FROM `usuario` WHERE `token` = ?";
     
        try {
            $ps = $mysql->prepare($sql);
            $result = $ps->execute([ $token ]);
        }
        catch (Exception $e) {
            print("$sql<br><pre>");
            print_r($values);
            print("</pre>Falha ao consultar dados em <font color='red'>usuario</font>: '" . $e->getMessage() . "'<br>");
            print("<strong>StackTrace</strong>:<pre>");
            print($e->getTraceAsString());
            print("</pre>");
        }
        // -
        if ($result === true) {
            $results = $ps->fetchAll();
            if (count($results) === 0) {
                return false;
            }
            // - gera o token para o usuário
            $id = 0;
            foreach ($results as $reg) {
                $id = $reg['idusuario'];
                break;
            }
            // - registra o token de sesssão para o usuário
            if ($token !== null && $id > 0) {
                try {
                    $sql = "UPDATE `usuario` SET `token` = NULL WHERE `idusuario` = ? AND `token` = ?";
                    $ps = $mysql->prepare($sql);
                    $result = $ps->execute([ $id, $token ]);
                }
                catch (Exception $e) {
                    print("$sql<br><pre>");
                    print_r($values);
                    print("</pre>Falha ao atualizar dados em <font color='red'>usuario</font>: '" . $e->getMessage() . "'<br>");
                    print("<strong>StackTrace</strong>:<pre>");
                    print($e->getTraceAsString());
                    print("</pre>");
                }
                if ($result === true) {
                    $_SESSION["auth_token"] = null;
                    return true;
                }
            }
            return false;
        }
        $_SESSION["auth_token"] = null;
    }
    function isBlockedUser($user) {
        $result = null;
        $mysql = $GLOBALS['mysql'] ?? null;
        if ($mysql === null) {
            return false;
        }

        // - prepara e executa o select para confrontar a autenticação do usuário!
        $sql = "SELECT IF(`inicio_bloqueio` IS NOT NULL AND NOW() <= DATE_ADD(`inicio_bloqueio`, INTERVAL 15 MINUTE), 1, 0) `bloqueado` FROM `usuario` WHERE `emailusuario` = ?";
        try {
            $ps = $mysql->prepare($sql);
            $result = $ps->execute([ $user ]);
        }
        catch (Exception $e) {
            print("$sql<br><pre>");
            print_r([ $user ]);
            print("</pre>Falha ao consultar dados em <font color='red'>usuario</font>: '" . $e->getMessage() . "'<br>");
            print("<strong>StackTrace</strong>:<pre>");
            print($e->getTraceAsString());
            print("</pre>");
        }
        // -
        if ($result === true) {
            $results = $ps->fetchAll();
            // - usuário e senha inválido!
            if (count($results) > 0) {
                $bloqueado = false;
                foreach ($results as $reg) {
                    $bloqueado = intval($reg['bloqueado']) === 1 ? true : false;
                    break;
                }
                return $bloqueado;
            }
        }
        return false;
    }
    function getUserByToken($token) {
        $result = null;
        $mysql = $GLOBALS['mysql'] ?? null;
        if ($mysql === null) {
            return false;
        }

        // - prepara e executa o select para confrontar a autenticação do usuário!
        $sql = "SELECT `idusuario`, `nomeusuario`, `emailusuario`, `bloqueado`, `inicio_bloqueio` FROM `usuario` WHERE `token` = ?";
     
        try {
            $ps = $mysql->prepare($sql);
            $result = $ps->execute([ $token ]);
        }
        catch (Exception $e) {
            print("$sql<br><pre>");
            print_r($values);
            print("</pre>Falha ao consultar dados em <font color='red'>usuario</font>: '" . $e->getMessage() . "'<br>");
            print("<strong>StackTrace</strong>:<pre>");
            print($e->getTraceAsString());
            print("</pre>");
        }
        // -
        if ($result === true) {
            $results = $ps->fetchAll();
            if (count($results) === 0) {
                return false;
            }
            $output = [];
            foreach ($results as $reg) {
                // - remove os índices numericos
                foreach ($reg as $key => $value) {
                    if (gettype($key) === "string") {
                        $output[$key] = is_numeric($value) ? doubleval($value) : $value;
                    }
                }
            }
            return $output;
        }
        $_SESSION["auth_token"] = null;
    }

    // -- -------------------- --
	// -- Funções de conversão --
	// -- -------------------- --

    function isDatetimeValid($value, $output = false, $format = "Y-m-d H:i:s.u") {
		$dt = DateTime::createFromFormat($format, $value);
		if (!$output) {
			return $dt !== false && !array_sum($dt::getLastErrors());
		}
		else if ($dt !== false && !array_sum($dt::getLastErrors())) {
			return $dt;
		}
		return false;
	}

	function isDateValid($value, $output = false, $format = "Y-m-d") {
		return isDatetimeValid($value, $output, $format);
	}

	function DtoUTC($value) {
		$value = strtotime($value);
		$value = date("Y-m-d\TH:i:s", $value);
		return $value;
	}

	// -- [DD/MM/AAAA] => [AAAA-MM-DD]
	function CtoD($value) {
		return PlainToDate($value);
	}

	function PlainToDate($value) {
		$dt = isDatetimeValid($value, true, "d/m/Y H:i:s");
		$dt = ($dt == null ? isDateValid($value, true, "d/m/Y") : $dt);
		return ($dt == null ? null : $dt->format("Y-m-d"));
	}

	// -- [AAAA-MM-DD] => [DD/MM/AAAA]
	function DtoC($value) {
		return DateToPlain($value);
	}

	function DateToPlain($value) {
		$dt = isDatetimeValid($value, true, "Y-m-d H:i:s");
		$dt = ($dt == null ? isDateValid($value, true, "Y-m-d") : $dt);
		return ($dt == null ? null : $dt->format("d/m/Y"));
	}

	// -- [DD/MM/AAAA HH:ii:ss] => [AAAA-MM-DD HH:ii:ss]
	function CtoT($value) {
		return PlainToDatetime($value);
	}

	function PlainToDatetime($value) {
		$dt = isDatetimeValid($value, true, "d/m/Y H:i:s");
		$dt = ($dt == null ? isDateValid($value, true, "d/m/Y") : $dt);
		return ($dt == null ? null : $dt->format("Y-m-d H:i:s"));
	}

	// -- [AAAA-MM-DD HH:ii:ss] => [DD/MM/AAAA HH:ii:ss]f
	function TtoC($value) {
		return DatetimeToPlain($value);
	}

	function DatetimeToPlain($value) {
		$dt = isDatetimeValid($value, true, "Y-m-d H:i:s.u");
		$dt = ($dt == false ? isDateValid($value, true, "Y-m-d H:i:s") : $dt);
		$dt = ($dt == false ? isDateValid($value, true, "Y-m-d") : $dt);
		return ($dt == false ? null : $dt->format("d/m/Y H:i:s"));
	}
?>