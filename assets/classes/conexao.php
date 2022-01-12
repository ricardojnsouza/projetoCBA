<?php
class Conexao
{

	private $connection;

	public function __construct($type, $host, $port, $base, $user, $pass, $ssl = false)
	{
		try {
			switch (strtoupper($type)) {
				case "MYSQL":
					$options = [
						'MultipleActiveResultSets' => false,
						PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
					];
					// -
					if ($ssl === true) {
						$options = [
							'MultipleActiveResultSets' => false,
							PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
							PDO::MYSQL_ATTR_SSL_CA => 'D:/_DATA/MySQL 5.7 Data/Data/ca-cert.pem',
							PDO::MYSQL_ATTR_SSL_KEY => 'D:/_DATA/MySQL 5.7 Data/Data/client-key.pem',
							PDO::MYSQL_ATTR_SSL_CERT => 'D:/_DATA/MySQL 5.7 Data/Data/client-cert.pem',
							PDO::MYSQL_ATTR_SSL_CIPHER => 'DHE-RSA-AES256-SHA',
							PDO::MYSQL_ATTR_SSL_CAPATH => null,
							PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
						];
					}
					$this->connection = new PDO("mysql:host=$host:$port;dbname=$base;charset=utf8", $user, $pass, $options);

					break;
				default:
					$this->connection = new PDO("sqlsrv:server=$host,$port;Database = $base", $user, $pass, array('MultipleActiveResultSets' => false));
					$this->connection->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_UTF8);
			}
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			print("Falha ao conectar ao banco de dados: <font color='red'> " . utf8_encode($e->getMessage()) . "</font><br>");
			// - removido por motivos de segurança!
			//print("<strong>StackTrace</strong>:<pre>");
			//print($e->getTraceAsString());
			//print("</pre>");
			die;
		}
	}

	public function getLastInsertID()
	{
		if (!$this->isConnected()) {
			return false;
		}
		return $this->connection->lastInsertId();
	}

	public function getConnection()
	{
		if (!$this->isConnected()) {
			return false;
		}
		return $this->connection;
	}

	public function quote($text)
	{
		if (!$this->isConnected()) {
			return false;
		}
		return $this->connection->quote($text);
	}

	// -

	public function isConnected()
	{
		return ($this->connection !== null && $this->connection !== false);
	}

	// -

	public function execute($sql)
	{
		if ($this->isConnected()) {
			return $this->connection->exec($sql);
		}
		die("Conexão inativa!");
		return false;
	}
	public function prepare($sql)
	{
		if ($this->isConnected()) {
			return $this->connection->prepare($sql);
		}
		die("Conexão inativa!");
		return false;
	}
	public function query($sql)
	{
		if ($this->isConnected()) {
			return $this->connection->query($sql);
		}
		die("Conexão inativa!");
		return false;
	}

	// -

	public function getQueryData($sql, $fetch = PDO::FETCH_ASSOC)
	{
		$stmt = $this->query($sql, $fetch);
		if ($stmt !== null) {
			$regs = [];
			while ($reg = $stmt->fetch()) {
				$regs[] = $reg;
			}
			return $regs;
		}
		return null;
	}
}

// = repositorio da conexao global =
$mysql = new Conexao("MYSQL", $GLOBALS['mysql_host'], $GLOBALS['mysql_port'], $GLOBALS['mysql_db'], $GLOBALS['mysql_user'], $GLOBALS['mysql_pass'], $GLOBALS['mysql_ssl']);
