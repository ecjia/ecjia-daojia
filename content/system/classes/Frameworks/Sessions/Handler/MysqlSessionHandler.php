<?php


namespace Ecjia\System\Frameworks\Sessions\Handler;

use Ecjia\System\Frameworks\Contracts\EcjiaSessionInterface;
use Ecjia\System\Frameworks\Sessions\Traits\EcjiaSessionSpecTrait;
use Royalcms\Component\NativeSession\Serialize;

/**
 * Session handler using a PDO connection to read and write data.
 *
 * Session data is a binary string that can contain non-printable characters like the null byte.
 * For this reason this handler base64 encodes the data to be able to save it in a character column.
 *
 * This version of the PdoSessionHandler does NOT implement locking. So concurrent requests to the
 * same session can result in data loss due to race conditions.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Michael Williams <michael.williams@funsational.com>
 * @author Tobias Schultze <http://tobion.de>
 */
class MysqlSessionHandler implements \SessionHandlerInterface, EcjiaSessionInterface
{

    use EcjiaSessionSpecTrait;

    /**
     * @var \PDO PDO instance
     */
    private $pdo;

    /**
     * @var string Table name
     */
    private $table;

    /**
     * @var string Column for session id
     */
    private $idCol;

    /**
     * @var string Column for session data
     */
    private $dataCol;

    /**
     * @var string Column for timestamp
     */
    private $timeCol;
    
    /**
     * @var string Column for session user id
     */
    private $useridCol;
    
    /**
     * @var string Column for session user type
     */
    private $usertypeCol;

    /**
     * Constructor.
     *
     * List of available options:
     *  * db_table: The name of the table [required]
     *  * db_id_col: The column where to store the session id [default: sess_id]
     *  * db_data_col: The column where to store the session data [default: sess_data]
     *  * db_time_col: The column where to store the timestamp [default: sess_time]
     *  * db_userid_col: The column where to store the user id [default: user_id]
     *  * db_usertype_col: The column where to store the user type [default: user_type]
     *
     * @param \PDO  $pdo       A \PDO instance
     * @param array $dbOptions An associative array of DB options
     *
     * @throws \InvalidArgumentException When "db_table" option is not provided
     */
    public function __construct(\PDO $pdo, array $dbOptions = array())
    {
        if (!array_key_exists('db_table', $dbOptions)) {
            throw new \InvalidArgumentException('You must provide the "db_table" option for a PdoSessionStorage.');
        }
        if (\PDO::ERRMODE_EXCEPTION !== $pdo->getAttribute(\PDO::ATTR_ERRMODE)) {
            throw new \InvalidArgumentException(sprintf('"%s" requires PDO error mode attribute be set to throw Exceptions (i.e. $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION))', __CLASS__));
        }
        $this->pdo = $pdo;
        $dbOptions = array_merge(array(
            'db_id_col'   => 'sess_id',
            'db_data_col' => 'sess_data',
            'db_time_col' => 'sess_time',
            'db_userid_col' => 'user_id',
            'db_usertype_col' => 'user_type',
        ), $dbOptions);

        $this->table = $dbOptions['db_table'];
        $this->idCol = $dbOptions['db_id_col'];
        $this->dataCol = $dbOptions['db_data_col'];
        $this->timeCol = $dbOptions['db_time_col'];
        $this->useridCol = $dbOptions['db_userid_col'];
        $this->usertypeCol = $dbOptions['db_usertype_col'];
    }

    /**
     * {@inheritdoc}
     */
    public function open($savePath, $sessionName)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function destroy($sessionId)
    {
        // delete the record associated with this id
        $sql = "DELETE FROM $this->table WHERE $this->idCol = :id";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $sessionId, \PDO::PARAM_STR);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new \RuntimeException(sprintf('PDOException was thrown when trying to delete a session: %s', $e->getMessage()), 0, $e);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function gc($maxlifetime)
    {
        // delete the session records that have expired
        $sql = "DELETE FROM $this->table WHERE $this->timeCol < :time";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':time', time() - $maxlifetime, \PDO::PARAM_INT);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new \RuntimeException(sprintf('PDOException was thrown when trying to delete expired sessions: %s', $e->getMessage()), 0, $e);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function read($sessionId)
    {
        $sql = "SELECT $this->dataCol FROM $this->table WHERE $this->idCol = :id";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $sessionId, \PDO::PARAM_STR);
            $stmt->execute();

            // We use fetchAll instead of fetchColumn to make sure the DB cursor gets closed
            $sessionRows = $stmt->fetchAll(\PDO::FETCH_NUM);
            
            if ($sessionRows) {
                return $sessionRows[0][0];
            }

            return '';
        } catch (\PDOException $e) {
            throw new \RuntimeException(sprintf('PDOException was thrown when trying to read the session data: %s', $e->getMessage()), 0, $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function write($sessionId, $data)
    {
        $encoded = $data;
        
        $sessionData = Serialize::unserialize($data);

        if (! isset($sessionData['session_user_id'])) {
            $sessionData['session_user_id'] = '';
        }

        if (! isset($sessionData['session_user_type'])) {
            $sessionData['session_user_type'] = '';
        }
        
        try {
            // We use a single MERGE SQL query when supported by the database.
            $mergeSql = $this->getMergeSql();

            if (null !== $mergeSql) {
                $mergeStmt = $this->pdo->prepare($mergeSql);
                $mergeStmt->bindParam(':id', $sessionId, \PDO::PARAM_STR);
                $mergeStmt->bindParam(':data', $encoded, \PDO::PARAM_STR);
                $mergeStmt->bindValue(':time', time(), \PDO::PARAM_INT);
                $mergeStmt->bindValue(':user_id', $sessionData['session_user_id'], \PDO::PARAM_INT);
                $mergeStmt->bindValue(':user_type', $sessionData['session_user_type'], \PDO::PARAM_STR);
                $mergeStmt->execute();

                return true;
            }

            $updateStmt = $this->pdo->prepare(
                "UPDATE $this->table SET $this->dataCol = :data, $this->timeCol = :time, $this->useridCol = :user_id, $this->usertypeCol = :user_type WHERE $this->idCol = :id"
            );
            $updateStmt->bindParam(':id', $sessionId, \PDO::PARAM_STR);
            $updateStmt->bindParam(':data', $encoded, \PDO::PARAM_STR);
            $updateStmt->bindValue(':time', time(), \PDO::PARAM_INT);
            $updateStmt->bindValue(':user_id', $sessionData['session_user_id'], \PDO::PARAM_INT);
            $updateStmt->bindValue(':user_type', $sessionData['session_user_type'], \PDO::PARAM_STR);
            $updateStmt->execute();

            // When MERGE is not supported, like in Postgres, we have to use this approach that can result in
            // duplicate key errors when the same session is written simultaneously. We can just catch such an
            // error and re-execute the update. This is similar to a serializable transaction with retry logic
            // on serialization failures but without the overhead and without possible false positives due to
            // longer gap locking.
            if (!$updateStmt->rowCount()) {
                try {
                    $insertStmt = $this->pdo->prepare(
                        "INSERT INTO $this->table ($this->idCol, $this->dataCol, $this->timeCol, $this->useridCol, $this->usertypeCol) VALUES (:id, :data, :time, :user_id, :user_type)"
                    );
                    $insertStmt->bindParam(':id', $sessionId, \PDO::PARAM_STR);
                    $insertStmt->bindParam(':data', $encoded, \PDO::PARAM_STR);
                    $insertStmt->bindValue(':time', time(), \PDO::PARAM_INT);
                    $insertStmt->bindValue(':user_id', $sessionData['session_user_id'], \PDO::PARAM_INT);
                    $insertStmt->bindValue(':user_type', $sessionData['session_user_type'], \PDO::PARAM_STR);
                    $insertStmt->execute();
                } catch (\PDOException $e) {
                    // Handle integrity violation SQLSTATE 23000 (or a subclass like 23505 in Postgres) for duplicate keys
                    if (0 === strpos($e->getCode(), '23')) {
                        $updateStmt->execute();
                    } else {
                        throw $e;
                    }
                }
            }
        } catch (\PDOException $e) {
            throw new \RuntimeException(sprintf('PDOException was thrown when trying to write the session data: %s', $e->getMessage()), 0, $e);
        }

        return true;
    }

    /**
     * Returns a merge/upsert (i.e. insert or update) SQL query when supported by the database.
     *
     * @return string|null The SQL string or null when not supported
     */
    private function getMergeSql()
    {
        return "INSERT INTO $this->table ($this->idCol, $this->dataCol, $this->timeCol, $this->useridCol, $this->usertypeCol) VALUES (:id, :data, :time, :user_id, :user_type) ".
                    "ON DUPLICATE KEY UPDATE $this->dataCol = VALUES($this->dataCol), $this->timeCol = VALUES($this->timeCol), $this->useridCol = VALUES($this->useridCol), $this->usertypeCol = VALUES($this->usertypeCol)";
    }

    /**
     * Return a PDO instance
     *
     * @return \PDO
     */
    protected function getConnection()
    {
        return $this->pdo;
    }
    
    
//    /**
//     * 删除指定用户的session
//     * @param int $user_id 用户ID
//     * @param int $user_type 用户类型user,admin,merchant
//     * @return boolean
//     */
//    public function deleteSpecSession($userId, $userType)
//    {
//        // delete the record associated with this id
//        $sql = "DELETE FROM $this->table WHERE $this->useridCol = :user_id AND $this->usertypeCol = :user_type";
//
//        try {
//            $stmt = $this->pdo->prepare($sql);
//            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
//            $stmt->bindParam(':user_type', $userType, \PDO::PARAM_STR);
//            $stmt->execute();
//        } catch (\PDOException $e) {
//            throw new \RuntimeException(sprintf('PDOException was thrown when trying to delete a session: %s', $e->getMessage()), 0, $e);
//        }
//
//        return true;
//    }
//
//    /**
//     * 获取当前在线用户总数
//     * @return number
//     */
//    public function getUserCount($userType)
//    {
//        $sql = "SELECT COUNT($this->idCol) AS COUNT FROM $this->table WHERE $this->usertypeCol = :user_type";
//
//        try {
//            $stmt = $this->pdo->prepare($sql);
//            $stmt->bindParam(':user_type', $userType, \PDO::PARAM_STR);
//            $stmt->execute();
//
//            // We use fetchAll instead of fetchColumn to make sure the DB cursor gets closed
//            $sessionRows = $stmt->fetchAll(\PDO::FETCH_NUM);
//
//            if ($sessionRows) {
//                return $sessionRows[0][0];
//            }
//
//            return '';
//        } catch (\PDOException $e) {
//            throw new \RuntimeException(sprintf('PDOException was thrown when trying to read the session data: %s', $e->getMessage()), 0, $e);
//        }
//    }
//
//    /**
//     * 获取指定session_id的数据
//     * @param string $session_id
//     */
//    public function getSessionData($sessionId)
//    {
//        $data = $this->read($sessionId);
//        $sessionData = Serialize::unserialize($data);
//        return $sessionData;
//    }
}
